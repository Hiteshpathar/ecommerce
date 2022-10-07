<template>
    <PPage style="margin-top:5%;text-align: center" narrowWidth :primaryAction="{}">
        <PImage :source="logo_path" alt="Login" height="170" width="170"/>
        <br>
        <br>
        <PCard sectioned title="LOGIN" :actions="[]">
            <PFormLayout>
                <PStack vertical>
                    <PStackItem>
                        <PTextField id="email" label="Email" placeholder="Email" v-model="form.email" :ref="`email`"
                                    @keyup.enter.native="login">
                            <PIcon source="EmailMajor" slot="prefix"/>
                        </PTextField>
                    </PStackItem>
                    <PStackItem>
                        <PTextField id="password" type="password" label="Password" placeholder="Password"
                                    v-model="form.password" @keyup.enter.native="login">
                            <PIcon source="LockMinor" slot="prefix"/>
                        </PTextField>
                    </PStackItem>
                    <PStackItem>
                        <PStack alignment="center">
                            <PStackItem>
                                <PButton primary @click="login" :disabled="btn_login">Login</PButton>
                            </PStackItem>
<!--                            <PStackItem>-->
<!--                                <PButton plain :to="{name: 'forgot-password'}">Forgot Password?</PButton>-->
<!--                            </PStackItem>-->
                        </PStack>
                    </PStackItem>
                </PStack>
            </PFormLayout>
        </PCard>
    </PPage>
</template>

<script>
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: ''

                },
                logo_path: '',
                btn_login: false
            }
        },
        created() {
            this.logo_path = process.env.MIX_APP_URL + '/images/repair_center_logo.svg';
        },
        mounted() {
            this.$refs.email.$el.children[1].children[1].focus();
        },
        methods: {
            ...mapActions({
                signIn: 'login'
            }),
            async login() {
                try {
                    this.btn_login = true;
                    await axios.post('auth', this.form);
                    this.btn_login = false;
                    this.signIn()
                    this.$router.push({name:"users"});

                } catch ({response}) {
                    this.btn_login = false;
                    this.$store.dispatch('unsetAdmin');
                    if (response.data.message) {
                        let message = response.data.message;
                        if (response.data.errors != undefined && response.data.errors != 'undefined') {
                            if (response.data.errors.email) {
                                message = response.data.errors.email[0];
                            } else if (response.data.errors.password) {
                                message = response.data.errors.password[0];
                            }
                        }
                        this.$pToast.open({
                            message: message
                        });
                    }
                }
            },
        }
    }
</script>

<style scoped>

</style>
