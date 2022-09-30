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
                primaryAction:{
                    content: 'Add New',
                    onAction: this.openCreateAddressModel,
                }
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
        }
    }
</script>
