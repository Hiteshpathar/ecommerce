<template>
    <PPage :breadcrumbs='[{"content":"Users","to":to}]' :title="pageTitle" :primaryAction="primaryAction"
    >
        <PLayout>
            <PLayoutSection>
                <PCard sectioned="">
                    <PStack>
                        <PStackItem width="33%">
                            <PTextStyle>Amount spent</PTextStyle>
                            <PDisplayText element="h2">₹44,997.00</PDisplayText>
                        </PStackItem>
                        <PStackItem><PVerticalDivider /></PStackItem>
                        <PStackItem width="30%">
                            <PTextStyle>Amount spent</PTextStyle>
                            <PDisplayText element="h2">₹44,997.00</PDisplayText>
                        </PStackItem>
                        <PStackItem><PVerticalDivider /></PStackItem>
                        <PStackItem>
                            <PTextStyle>Amount spent</PTextStyle>
                            <PDisplayText element="h2">₹44,997.00</PDisplayText>
                        </PStackItem>
                    </PStack>
                </PCard>
                <PCard title="Last Order Placed" sectioned="" :actions="[]">
                    <PEmptyState
                        heading="This customer hasn’t placed any orders."
                        image="https://cdn.shopify.com/s/files/1/0262/4071/2726/files/emptystate-files.png"
                        :primaryAction='{"content":"Create Order"}'
                    >
                    </PEmptyState>
                </PCard>
            </PLayoutSection>
            <PLayoutSection secondary="">
                <PCard title="Customer" sectioned=""
                       :actions='[{"content":"Edit","to":"/to-route"}]'>
                    <PStack>
                        <PStackItem fill="">
                            <PLink @click.stop="">
                                {{user.email}}
                            </PLink>
                        </PStackItem>
                        <PStackItem>
                            <PButton plain="">Icon</PButton>
                        </PStackItem>
                    </PStack>
                    <PStack>
                        <PStackItem>{{user.mobile}}</PStackItem>
                    </PStack>
                    <br>
                    <PHorizontalDivider></PHorizontalDivider>
                    <br>
                    <PStack>
                        <PStackItem fill="">
                            <PHeading>Default Address</PHeading>
                        </PStackItem>
                        <PStackItem>
                            <PLink @click.stop="">
                                Manage
                            </PLink>
                        </PStackItem>
                    </PStack>
                    <br>
                    <PStack>
                        <PStackItem>
                            <PTextStyle>{{user.default_address.address1??''}} {{user.default_address.address2??''}}</PTextStyle>
                        </PStackItem>
                    </PStack>
                    <PStack>
                        <PStackItem>
                            <PTextStyle>{{user.default_address.postal_code??''}} {{user.default_address.city??''}}
                                {{user.default_address.state??''}}
                            </PTextStyle>
                        </PStackItem>
                    </PStack>
                    <PStack>
                        <PStackItem>
                            <PTextStyle>{{user.default_address.country??''}}</PTextStyle>
                        </PStackItem>
                    </PStack>
                    <PStack>
                        <PStackItem>
                            <PTextStyle>{{user.default_address.mobile??''}}</PTextStyle>
                        </PStackItem>
                    </PStack>

                    <PStack>
                        <PStackItem>
                            <PButton plain="" @click="this.openCreateAddressModel">Add new address</PButton>
                        </PStackItem>
                    </PStack>
                </PCard>
            </PLayoutSection>
        </PLayout>
        <PModal
            sectioned
            :title="modelTitle"
            :primaryAction="{content: 'Save', onAction: createAddress}"
            :secondaryActions="[{content:'Close', onAction: () => {openAddressModel = false}}]"
            :open="openAddressModel" @close="openAddressModel = !openAddressModel"
        >
            <PLayout sectioned>
                <PFormLayout>
                    <PTextField label="Country" placeholder="Country" v-model="form.address.country"
                                id="country"/>
                    <PFormLayoutGroup>
                        <PTextField label="First Name *" placeholder="First Name" v-model="form.address.first_name"
                                    id="first_name"/>
                        <PTextField label="Last Name" placeholder="Last Name" v-model="form.address.last_name"
                                    id="last_name"/>
                    </PFormLayoutGroup>
<!--                    <PTextField label="Address *" placeholder="Address" v-model="form.address.address1"-->
<!--                                id="address"/>-->
                    <PTextField label="Apartment, Suite, etc.*" placeholder="Apartment, Suite, etc."
                                v-model="form.address.address2"
                                id="address2"/>
                    <PFormLayoutGroup condensed>
                        <PTextField label="City" placeholder="City" v-model="form.address.city"
                                    id="city"/>
                        <PTextField label="State" placeholder="State" v-model="form.address.state"
                                    id="state"/>
                        <PTextField label="Pin Code" placeholder="Pin Code" v-model="form.address.postal_code"
                                    id="postal_code"/>
                    </PFormLayoutGroup>
                    <PTextField label="Mobile Number*" placeholder="Mobile Number" v-model="form.address.mobile"
                                id="mobile"/>
                </PFormLayout>
            </PLayout>
        </PModal>
    </PPage>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        data() {
            return {
                pageTitle: "",
                subTitle: "",
                user: {},
                to: {name: "users"},
                primaryAction: {
                    content: 'Add New',
                    onAction: this.openCreateAddressModel,
                },
                openAddressModel: false,
                modelTitle: "Add New Address",
                isDisableEmail: false,
                isEdit: false,
                form: {
                    _method: "POST",
                    id: null,
                    first_name: '',
                    last_name: '',
                    email: '',
                    mobile: '',
                    address: {
                        first_name: '',
                        last_name: '',
                        mobile: '',
                        address1: '',
                        address2: '',
                        city: '',
                        country: '',
                        postal_code: '',
                        is_primary: 1
                    }
                },
            }
        },
        async created() {
            const response = await this.loadUser(this.$route.params.id);
            this.user = {...response.data};
            this.pageTitle = "User - " + this.user.first_name + ' ' + this.user.last_name;
        },
        computed: {
            ...mapGetters('users', {
                errors: 'getErrors',
                message: 'getMessage'
            }),
        },

        methods: {
            ...mapActions('users', [
                'loadUser',
                'resetError',
                'addressCreateUpdate'
            ]),
            backToList() {
                this.$router.push({name: 'users'});
            },
            changeDateFormat(date, date_format = 'Do MMMM YYYY') {
                return date ? moment(date).format(date_format) : 'N/A';
            },
            getMonthDifference(startDate, endDate) {
                return (
                    endDate.getMonth() -
                    startDate.getMonth() +
                    12 * (endDate.getFullYear() - startDate.getFullYear())
                );
            },
            openCreateAddressModel() {
                this.resetError();
                this.openAddressModel = true;
                this.modelTitle = "Add New Address";
                this.isDisableEmail = false;
                this.isEdit = false;
                this.form.id = null;
                this.form.first_name = "";
                this.form.last_name = "";
                this.form.email = "";
                this.form.mobile = "";
                this.form.address1 = '';
                this.form.address2 = '';
                this.form.city = '';
                this.form.country = '';
                this.form.postal_code = '';
                this.form.is_primary = 1

            },
            async createAddress() {
                if (this.isEdit) {
                    this.form._method = "PUT";
                } else {
                    this.form._method = "POST";
                }
                if (this.pending) {
                    this.form.pending = this.pending;
                }
                await this.addressCreateUpdate(this.form);
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
                    this.form.address = {
                        first_name: '',
                        last_name: '',
                        email: '',
                        mobile: '',
                        address1: '',
                        address2: '',
                        city: '',
                        country: '',
                        postal_code: '',
                        is_primary: 1
                    }
                    this.load(this.queryParams);
                }
            },
            async editAddress(item) {
                this.resetError();
                const response = await this.loadUser(item.id);
                this.openUserModel = true;
                this.isEdit = true;
                this.modelTitle = "Edit User";
                this.isDisableEmail = true;
                this.form = {...response.data};
            },
        }
    }
</script>
