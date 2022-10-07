<template>
    <PPage title="Users"
           :primaryAction="primaryAction"
           full-width
    >
        <PCard sectioned>
            <PDataTable
                :headings="headings"
                :footerContent="users.data && users.data.length ? 'Showing '+ from + ' - '+ to +' of '+ users.total + ' results' : 'No data found'"
                :resourceName="{'singular': 'User By Name, Email','plural': 'Users By Name, Email '}"
                :rows="users.data"
                :sort="{value: queryParams.sort,direction: queryParams.order}"
                @sort-changed="handleSort"
                :inputFilter="queryParams.search"
                @input-filter-changed="handleSearch"
                :columnContentTypes="[]"
                hasFilter
            >
                <template v-slot:item="{item}">
                    <PDataTableRow>
                        <PDataTableCol firstColumn>
                            <PLink @click.stop="openUserView(item.id)">
                                {{item.first_name}} {{item.last_name}}
                            </PLink>
                        </PDataTableCol>
                        <PDataTableCol>
                            {{item.email}}
                        </PDataTableCol>
                        <PDataTableCol>
                            {{item.location}}
                        </PDataTableCol>
                        <PDataTableCol numeric>
                            {{item.orders_count+' Orders'}}
                        </PDataTableCol>
                        <PDataTableCol numeric>
                            ₹ {{item.total_spent?toInr(item.total_spent):'0.00'}}
                        </PDataTableCol>
                        <PDataTableCol>
                            <PButtonGroup segmented spacing="extraTight">

                                <PButton title="Resend" @click="onResend(item.id)" size="slim">
                                    <PIcon source="MobileAcceptMajor" v-if="item.is_email_sent"/>
                                    <PIcon source="EmailMajor" v-else/>
                                </PButton>

                                <PButton title="Edit" @click="
                                            editUser(item)" size="slim">
                                    <PIcon source="EditMajor"/>
                                </PButton>

                                <PButton title="Delete" destructive size="slim" @click="deleteUser(item.id)">
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
                            Filter
                        </PButton>
                        <PCard slot="content" sectioned="" style="max-width:500px;max-height:400px">
                            Filter by
                            <PStack vertical="">
                                <PStackItem>
                                    <PRadioButton label="Last Update" id="test1" checked name="updated_at"/>
                                </PStackItem>
                                <PStackItem>
                                    <PRadioButton label="Amount Spent" id="test2" name="total_spent"/>
                                </PStackItem>
                                <PStackItem>
                                    <PRadioButton label="Total Orders" id="test3" name="total_orders"/>
                                </PStackItem>
                            </PStack>
                        </PCard>
                    </PPopover>
                </PButtonGroup>
            </PDataTable>
            <Pagination
                :pageCount=users.last_page?users.last_page:1
                :defaultPage="setDefaultPage"
                :click-handler="handlePagination"
            >
            </Pagination>
        </PCard>
        <PModal
            :open="openDeleteModal"
            title="Delete User"
            sectioned
            :secondaryActions='[
                {
                    "content":"Delete",
                    "destructive":true,
                    onAction:()=>{this.deleteUser(null)}
                }
            ]'
            @close="openDeleteModal = !openDeleteModal"
        >
            <PTextStyle>Are you sure you want to delete user?</PTextStyle>
        </PModal>
        <PModal
            sectioned
            :title="modelTitle"
            :primaryAction="{content: 'Save', onAction: createUser}"
            :secondaryActions="[{content:'Close', onAction: () => {openUserModel = false}}]"
            :open="openUserModel" @close="openUserModel = !openUserModel"
            large
        >
            <PLayout sectioned>
                <PLayoutAnnotatedSection
                    title="User OverView"
                >
                    <PFormLayout>
                        <PFormLayoutGroup>
                            <PTextField label="First Name *" placeholder="First Name" v-model="form.first_name"
                                        :error="errors.first_name ? errors.first_name[0] : ''" id="first_name">
                            </PTextField>
                            <PTextField label="Last Name" placeholder="Last Name" v-model="form.last_name"
                                        :error="errors.last_name ? errors.last_name[0] : ''" id="last_name"/>
                        </PFormLayoutGroup>
                        <PFormLayoutGroup>
                            <PTextField label="Email *" placeholder="Email" v-model="form.email"
                                        :error="errors.email ? errors.email[0] : ''" id="email"
                                        :disabled="isDisableEmail"/>
                            <PTextField label="Mobile Number*" placeholder="Mobile Number" v-model="form.mobile"
                                        :error="errors.mobile ? errors.mobile[0] : ''" id="mobile"/>
                        </PFormLayoutGroup>
                    </PFormLayout>
                </PLayoutAnnotatedSection>

                <PLayoutAnnotatedSection
                    title="Address"
                    description="The primary address of this customer"
                >
                    <PFormLayout>
                        <PFormLayoutGroup>
                            <PTextField label="First Name *" placeholder="First Name" v-model="form.address.first_name"
                                        id="first_name"/>
                            <PTextField label="Last Name" placeholder="Last Name" v-model="form.address.last_name"
                                        id="last_name"/>
                            <PTextField label="Email *" placeholder="Email" v-model="form.address.email"
                                        id="email"
                                        :disabled="isDisableEmail"/>
                            <PTextField label="Mobile Number*" placeholder="Mobile Number" v-model="form.address.mobile"
                                        id="mobile"/>
                            <PTextField label="Address *" placeholder="Address" v-model="form.address.address1"
                                        id="address"/>
                            <PTextField label="Apartment, Suite, etc.*" placeholder="Apartment, Suite, etc." v-model="form.address.address2"
                                        id="address2"/>
                            <PTextField label="City" placeholder="City" v-model="form.address.city"
                                        id="city"/>
                            <PTextField label="State" placeholder="State" v-model="form.address.state"
                                        id="state"/>
                            <PTextField label="Country" placeholder="Country" v-model="form.address.country"
                                        id="country"/>
                            <PTextField label="Pin Code" placeholder="Pin Code" v-model="form.address.postal_code"
                                        id="postal_code"/>
                        </PFormLayoutGroup>
                    </PFormLayout>
                </PLayoutAnnotatedSection>
            </PLayout>
        </PModal>

    </PPage>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import _ from 'lodash';
    import Pagination from '../../../components/Pagination';

    export default {
        name: "Users",
        components:{
            Pagination
        },
        data() {
            return {
                setDefaultPage: 0,
                sortFilterPopUpStatus: false,
                openDeleteModal: false,
                deleteUserId: null,
                headings: [{
                    content: "Full Name",
                    value: 'first_name',
                    type: 'text',
                    sortable: false,
                }, {
                    content: "Email",
                    value: 'email',
                    type: 'text',
                }, {
                    content: "Location",
                    value: 'location',
                    type: 'text',
                    sortable: false,
                },{
                    content: "Orders",
                    value: 'orders_count',
                    type: 'numeric',
                }, {
                    content: "Spent",
                    value: 'total_spent',
                    type: 'numeric',
                }, {
                    content: "Actions",
                    value: "",
                    type: "text",
                    sortable: false,
                }],
                queryParams: {
                    limit: process.env.MIX_PAGE_LIMIT,
                    page: 1,
                    search: null,
                    sort: "",
                    order: "none",
                },
                form: {
                    _method: "POST",
                    id: null,
                    first_name: '',
                    last_name: '',
                    email: '',
                    mobile: '',
                    address:{
                        first_name: '',
                        last_name: '',
                        email:'',
                        mobile: '',
                        address1:'',
                        address2:'',
                        city:'',
                        country:'',
                        postal_code:'',
                        is_primary:1
                    }
                },
                isDisableEmail: true,
                openUserModel: false,
                modelTitle: "Add New User",
                isEdit: false,
                openDealerModel: false,
                primaryAction: {
                    content: 'Add New',
                    onAction: this.openCreateUserModel,
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
            ...mapGetters('users', {
                users: 'getUsers', errors: 'getErrors',
                message: 'getMessage'
            }),
            from() {
                return this.users.data && this.users.data.length > 0 ? (this.users.per_page * (this.users.current_page - 1)) + 1 : 0;
            },
            to() {
                return this.users.data && this.users.data.length > 0 ? (this.from + this.users.data.length) - 1 : this.from;
            },
        },
        methods: {
            ...mapActions('users', [
                'load',
                'delete',
                'userCreateUpdate',
                'sendMail',
                'resetError',
                'loadUser'
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
                this.setDefaultPage=0
            },
            openCreateUserModel() {
                this.resetError();
                this.openUserModel = true;
                this.modelTitle = "Add New User";
                this.isDisableEmail = false;
                this.isEdit = false;
                this.form.id = null;
                this.form.first_name = "";
                this.form.last_name = "";
                this.form.email = "";
                this.form.mobile = "";
                this.form.address={
                    first_name: '',
                        last_name: '',
                        email:'',
                        mobile: '',
                        address1:'',
                        address2:'',
                        city:'',
                        country:'',
                        postal_code:'',
                        is_primary:1
                }
            },
            async createUser() {
                if (this.isEdit) {
                    this.form._method = "PUT";
                } else {
                    this.form._method = "POST";
                }
                if (this.pending) {
                    this.form.pending = this.pending;
                }
                await this.userCreateUpdate(this.form);
                if (this.errors.length === 0) {
                    this.$pToast.open({
                        message: this.message
                    });
                    this.isEdit = false;
                    this.openUserModel = false;
                    this.form.id = null;
                    this.form.first_name = "";
                    this.form.last_name = "";
                    this.form.email = "";
                    this.form.address={
                        first_name: '',
                        last_name: '',
                        email:'',
                        mobile: '',
                        address1:'',
                        address2:'',
                        city:'',
                        country:'',
                        postal_code:'',
                        is_primary:1
                    }
                    this.load(this.queryParams);
                }
            },
            async editUser(item) {
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
            async deleteUser(id = null) {
                this.openDeleteModal = true;
                if (id) {
                    this.deleteUserId = id;
                } else {
                    let {data} = await this.delete({'id': this.deleteUserId});
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
                    this.deleteUserId = null;
                }
            },
            async onResend(id) {
                let {data} = await this.sendMail({'id': id});
                this.$pToast.open({
                    message: data.message
                });
                this.load(this.queryParams);
            },
            toInr(amount) {
                return (amount).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');
            }
        }
    }
</script>

<style scoped>

</style>
