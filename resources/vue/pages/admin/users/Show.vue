<template>
    <PPage :breadcrumbs='[{"content":"Users","to":to}]' :title="pageTitle" fullWidth :primaryAction="primaryAction"
    >
        <PCard sectioned>
            <PStack distribution="equalSpacing" vertical v-for="address in user.address" :key="address"
                    v-if="address.is_primary ===1">
                <PStackItem>
                    <PStack distribution="equalSpacing">
                        <PStackItem>
                            Name: <b>{{address.first_name}} {{address.last_name}}</b>
                        </PStackItem>
                        <PStackItem>
                            Email: <b>{{address.email}}</b>
                        </PStackItem>
                        <PStackItem>
                            Phone: <b>{{address.mobile}}</b>
                        </PStackItem>
                        <PStackItem>
                            <PLink>Edit</PLink>
                        </PStackItem>
                    </PStack>
                </PStackItem>
                <PStackItem>
                    <PStack distribution="equalSpacing">
                        <PStackItem>
                            City: <b>{{address.city}}</b>
                        </PStackItem>
                        <PStackItem>
                            Country: <b>{{address.country}}</b>
                        </PStackItem>
                        <PStackItem>
                            Postal Code: <b>{{address.postal_code}}</b>
                        </PStackItem>
                        <PStackItem>
                            <PButton v-if="address.is_primary===0">Make Default</PButton>
                        </PStackItem>
                    </PStack>
                </PStackItem>
                <PStackItem>
                    <PStack distribution="equalSpacing">
                        <PStackItem>
                            Address : <b>{{address.address1}},{{address.address2}}</b>
                        </PStackItem>
                    </PStack>
                </PStackItem>
            </PStack>
        </PCard>
        <PCard sectioned>
            <PStack distribution="equalSpacing" vertical v-for="address in user.address" :key="address"
                    v-if="address.is_primary ===0">
                <PStackItem>
                    <PStack distribution="equalSpacing">
                        <PStackItem>
                            Name: <b>{{address.first_name}} {{address.last_name}}</b>
                        </PStackItem>
                        <PStackItem>
                            Email: <b>{{address.email}}</b>
                        </PStackItem>
                        <PStackItem>
                            Phone: <b>{{address.mobile}}</b>
                        </PStackItem>
                        <PStackItem>
                            <PLink>Edit</PLink>
                        </PStackItem>
                    </PStack>
                </PStackItem>
                <PStackItem>
                    <PStack distribution="equalSpacing">
                        <PStackItem>
                            City: <b>{{address.city}}</b>
                        </PStackItem>
                        <PStackItem>
                            Country: <b>{{address.country}}</b>
                        </PStackItem>
                        <PStackItem>
                            Pin Code: <b>{{address.postal_code}}</b>
                        </PStackItem>
                        <PStackItem>
                            <PLink>Make Default</PLink>
                        </PStackItem>
                    </PStack>
                </PStackItem>
                <PStackItem>
                    <PStack distribution="equalSpacing">
                        <PStackItem>
                            Address : <b>{{address.address1}},{{address.address2}}</b>
                        </PStackItem>
                    </PStack>
                </PStackItem>
                <PStackItem>
                    <PHorizontalDivider/>
                </PStackItem>
                <br>
            </PStack>
        </PCard>
        <PModal
            sectioned
            :title="modelTitle"
            :primaryAction="{content: 'Save', onAction: createAddress}"
            :secondaryActions="[{content:'Close', onAction: () => {openAddressModel = false}}]"
            :open="openAddressModel" @close="openAddressModel = !openAddressModel"
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
    import {mapActions} from 'vuex';

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
                openAddressModel: true,
                modelTitle: "Add New Address",
                isDisableEmail: false,
                isEdit: false,
            }
        },
        async created() {
            const response = await this.loadUser(this.$route.params.id);
            this.user = {...response.data};
            this.pageTitle = "User - " + this.user.first_name + ' ' + this.user.last_name;
        },

        methods: {
            ...mapActions('users', [
                'loadUser',
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
                this.form.address1= '';
                this.form.address2='';
                this.form.city= '';
                this.form.country= '';
                this.form.postal_code= '';
                this.form.is_primary= 1

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
