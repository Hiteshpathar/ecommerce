<template>
    <PPage title="Orders"
           :primaryAction="primaryAction"
           full-width
    >
        <PCard sectioned>
            <PDataTable
                :resourceName="{singular: 'User', plural: 'Users'}"
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
                                {{'#'+item.order_number}}
                            </PLink>
                        </PDataTableCol>
                        <PDataTableCol>
                            {{formatDate(item.created_at)}}
                        </PDataTableCol>
                        <PDataTableCol>
                            {{item.user?item.user.first_name+' '+item.user.first_name:'No Customer'}}
                        </PDataTableCol>
                        <PDataTableCol>
                            ₹ {{toInr(item.total_amount)}}
                        </PDataTableCol>
                        <PDataTableCol>
                            {{item.quantity}} items
                        </PDataTableCol>
                        <PDataTableCol>
                            <PButtonGroup segmented spacing="extraTight">

                                <PButton title="Edit" @click="
                                            editProduct(item)" size="slim">
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
        </PCard>

        <PModal
            :open="openDeleteModal"
            title="Delete Order"
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
    import moment from 'moment'
    import _ from 'lodash';

    export default {
        name: "Orders",
        data() {
            return {
                sortFilterPopUpStatus: false,
                openDeleteModal: false,
                deleteProductId: null,
                headings: [{
                    content: "Order",
                    value: 'order_number',
                    type: 'text',
                    sortable: false,
                }, {
                    content: "Date",
                    value: 'created_at',
                    type: 'text',
                }, {
                    content: "Customer",
                    value: 'customer_name',
                    type: 'text',
                    sortable: false,
                }, {
                    content: "Total",
                    value: 'total_amount',
                    type: 'text',
                    sortable: false,
                },{
                    content: "Item",
                    value: 'quantity',
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
                    content: 'Create Order',
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
            ...mapGetters('orders', {
                products: 'getOrders', errors: 'getErrors',
                message: 'getMessage'
            }),
            // from() {
            //     return this.serialNumbers.data && this.serialNumbers.data.length > 0 ? (this.serialNumbers.per_page * (this.serialNumbers.current_page - 1)) + 1 : 0;
            // },
            // to() {
            //     return this.serialNumbers.data && this.serialNumbers.data.length > 0 ? (this.from + this.serialNumbers.data.length) - 1 : this.from;
            // },
        },
        methods: {
            ...mapActions('orders', [
                'load',
                'delete',
                'orderCreateUpdate',
                'resetError',
                'loadOrder'
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
            async editProduct(item) {
                this.resetError();
                const response = await this.loadUser(item.id);
                this.openUserModel = true;
                this.isEdit = true;
                this.modelTitle = "Edit User";
                this.isDisableEmail = true;
                this.form = {...response.data};
            },
            openUserView(id) {
                this.$router.push({name: 'view-user', params: {id: id}});
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
            },
            formatDate(value){
                if (value) {
                    return moment(value).format('Do MMM YYYY, h:mm:ss a')
                }
            },
            toInr(amount) {
                return (amount).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');
            }
        }
    }
</script>

<style scoped>

</style>
