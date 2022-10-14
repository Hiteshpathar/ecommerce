<template>
    <PPage :primaryAction="{}" narrowWidth style="margin-top:5%;text-align: center">
        <PImage :source="logo_path" alt="Login" height="170" width="170"/>
        <br>
        <br>
        <PCard :actions="[]" sectioned title="LOGIN">
            <PFormLayout>
                <PStack vertical>
                    <PStackItem>
                        <PTextField :ref="`email`" @keyup.enter.native="login" id="email" label="Email" placeholder="Email"
                                    v-model="form.email">
                            <PIcon slot="prefix" source="EmailMajor"/>
                        </PTextField>
                    </PStackItem>
                    <PStackItem>
                        <PTextField @keyup.enter.native="login" id="password" label="Password" placeholder="Password"
                                    type="password" v-model="form.password">
                            <PIcon slot="prefix" source="LockMinor"/>
                        </PTextField>
                    </PStackItem>
                    <PStackItem>
                        <PStack alignment="center">
                            <PStackItem>
                                <PButton :disabled="btn_login" @click="login" primary>Login</PButton>
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
            ...mapActions('adminAuth', [
                'setAdmin'
            ]),
            async login() {
                try {
                    this.btn_login = true;
                    await axios.post('auth', this.form);
                    this.btn_login = false;
                    await this.setAdmin();
                    this.$router.push({name: "users"});

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
