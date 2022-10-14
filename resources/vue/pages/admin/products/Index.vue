<template>
    <PPage title="Products"
           :primaryAction="primaryAction"
           full-width
    >
        <PCard sectioned>
            <PDataTable
                :resourceName="{singular: 'Product', plural: 'Products'}"
                :footerContent="products.data && products.data.length ? 'Showing '+ from + ' - '+ to +' of '+ products.total + ' results' : 'No data found'"
                :headings="headings"
                :rows="products.data"
                :sort="{value: queryParams.sort,direction: queryParams.order}"
                :inputFilter="queryParams.search"
                @input-filter-changed="handleSearch"
                :columnContentTypes="[]"
                hasFilter
                @sort-changed="handleSort"
            >
                <template v-slot:item="{item}">
                    <PDataTableRow>
                        <PDataTableCol firstColumn>
                            <PLink @click.stop="openUserView(item.id)">
                                {{item.title}}
                            </PLink>
                        </PDataTableCol>
                        <PDataTableCol>
                            <PBadge status="success" :progress="null" v-if="item.is_active===1">Active</PBadge>
                            <PBadge status="info" :progress="null" v-else>Draft</PBadge>
                        </PDataTableCol>
                        <PDataTableCol>
                            {{item.inventory!==null?item.inventory+' in stock':'inventory not tracked'}}
                        </PDataTableCol>
                        <PDataTableCol>
                            {{item.category?item.category.name:''}}
                        </PDataTableCol>
                        <PDataTableCol>
                            <PButtonGroup segmented spacing="extraTight">

                                <PButton title="Edit" @click="editProduct(item.id)" size="slim">
                                    <PIcon source="EditMajor"/>
                                </PButton>

                                <PButton title="Delete" destructive size="slim" @click="deleteProduct(item.id)">
                                    <PIcon source="DeleteMajor"/>
                                </PButton>
                            </PButtonGroup>
                        </PDataTableCol>
                    </PDataTableRow>
                </template>
                <PButtonGroup slot="filter" segmented>
                    <PPopover id="popover_1" :active.sync="sortFilterPopUpStatus" fullWidth="" fullHeight
                              preferredAlignment="right">
                        <PButton slot="activator" @click="sortFilterPopUpStatus = !sortFilterPopUpStatus"
                                 :disclosure="sortFilterPopUpStatus ? 'down' : 'up'">
                            Status
                        </PButton>
                        <PCard slot="content" sectioned="" style="max-width:500px;max-height:400px">
                            <PStack vertical="">
                                <PStackItem>
                                    <PRadioButton label="Active" id="test1" checked name="updated_at"/>
                                </PStackItem>
                                <PStackItem>
                                    <PRadioButton label="Draft" id="test2" name="total_spent"/>
                                </PStackItem>
                            </PStack>
                        </PCard>
                    </PPopover>
                </PButtonGroup>
            </PDataTable>
            <Pagination
                :pageCount=products.last_page?products.last_page:1
                :defaultPage="setDefaultPage"
                :click-handler="handlePagination"
            >
            </Pagination>
        </PCard>

        <PModal
            :open="openDeleteModal"
            title="Delete Product"
            sectioned
            :secondaryActions='[
                {
                    "content":"Delete",
                    "destructive":true,
                    onAction:()=>{this.deleteProduct(null)}
                }
            ]'
            @close="openDeleteModal = !openDeleteModal"
        >
            <PTextStyle>Are you sure you want to delete this Product?</PTextStyle>
        </PModal>

    </PPage>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import _ from 'lodash';

    export default {
        name: "products",
        data() {
            return {
                setDefaultPage: 0,
                sortFilterPopUpStatus: false,
                openDeleteModal: false,
                deleteProductId: null,
                headings: [{
                    content: "Product",
                    value: 'title',
                    type: 'text',
                }, {
                    content: "Status",
                    value: 'is_active',
                    type: 'text',
                    sortable: false,
                }, {
                    content: "Inventory",
                    value: 'inventory',
                    type: 'text',
                }, {
                    content: "Type",
                    value: 'category_id',
                    type: 'text',
                    sortable: false,
                }, {
                    content: "Actions",
                    value: "",
                    type: "numeric",
                    sortable: false,
                }],
                queryParams: {
                    limit: process.env.MIX_PAGE_LIMIT,
                    page: 1,
                    search: null,
                    sort: "",
                    order: "none",
                },

                primaryAction: {
                    content: 'Add New',
                    onAction: () => {
                        this.$router.push({name: 'add-product'});
                    },
                },
            }
        },
        watch: {
            queryParams: {
                deep: true,
                async handler() {
                    this.$router.replace({query: this.queryParams});
                    this.load(this.queryParams);
                }
            },
        },
        async created() {
            this.queryParams = {
                limit: process.env.MIX_PAGE_LIMIT,
                page: this.$router.currentRoute.query.page ? parseInt(this.$router.currentRoute.query.page) : 1,
                sort: this.$router.currentRoute.query.sort ? this.$router.currentRoute.query.sort : '',
                order: this.$router.currentRoute.query.order ? this.$router.currentRoute.query.order : 'none',
                search: this.$router.currentRoute.query.search ? this.$router.currentRoute.query.search : null,
            };
        },
        computed: {
            ...mapGetters('products', {
                products: 'getProducts', errors: 'getErrors',
                message: 'getMessage'
            }),
            from() {
                return this.products.data && this.products.data.length > 0 ? (this.products.per_page * (this.products.current_page - 1)) + 1 : 0;
            },
            to() {
                return this.products.data && this.products.data.length > 0 ? (this.from + this.products.data.length) - 1 : this.from;
            },
        },
        methods: {
            ...mapActions('products', [
                'load',
                'delete',
                'resetError',
                'loadProduct'
            ]),

            handleSort(sort, direction) {
                this.setDefaultPage = 1;
                this.queryParams.sort = sort;
                this.queryParams.order = direction;
            },
            handleSearch: _.debounce(function (search) {
                this.queryParams.search = search;
                this.queryParams.page = 1;
                this.setDefaultPage = 1;
            }, 500),
            handlePagination(pageNum) {
                this.queryParams.page = pageNum;
                this.setDefaultPage = 0
            },
            editProduct(id) {
                this.$router.push({name: 'add-product', params: {id: id}});
            },
            async deleteProduct(id = null) {
                this.openDeleteModal = true;
                if (id) {
                    this.deleteProductId = id;
                } else {
                    let {data} = await this.delete({'id': this.deleteProductId});
                    if (data.error) {
                        this.$pToast.open({
                            message: data.error
                        });
                    } else {
                        this.$pToast.open({
                            message: data.message
                        });
                        this.load(this.queryParams);
                    }
                    this.openDeleteModal = false;
                    this.deleteProductId = null;
                }
            },
            async onResend(id) {
                let {data} = await this.sendMail({'id': id});
                this.$pToast.open({
                    message: data.message
                });
                this.load(this.queryParams);
            }
        }
    }
</script>

<style scoped>

</style>
