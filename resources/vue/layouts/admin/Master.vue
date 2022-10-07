<template>
    <div>
        <PFrame
            :topBar="{

            logo: this.logo,
            userMenu: {
                id: 'Polaris-UserMenu',
                actions: [
                    {
                    items: [
                        {
                            content: ' Logout',
                            onAction:this.logout,
                            icon: 'CircleLeftMajor',
                        }
                    ],
                },
            ],
            name:'Admin',
            open: isOpen,
            onToggle:()=>{
                this.isOpen =! this.isOpen
            }
        },
    }">
            <PNavigation
                slot="navigation"
                location="/"
                :logo=this.logo
                :items=this.items
            />
            <router-view/>
        </PFrame>
    </div>
</template>

<script>
    export default {
        name: "Master",
        data() {
            return {
                isOpen: false,
                logo: {
                    width: 124,
                    topBarSource: "https://cdn.shopify.com/s/files/1/1564/7647/files/hulk-apps-darken_c0448e92-587f-47a8-9473-5ea0023b5ffd.svg?v=1583731462",
                    url: "javascript:void(0)",
                    accessibilityLabel: "Jaded Pixel"
                },
                items: [
                    {
                        items: [
                            {
                                to: {name: "home"},
                                label: "Home",
                                icon: "HomeMajor"
                            }, {
                                to: {name: "orders"},
                                label: "Orders",
                                icon: "OrdersMajor"
                            }, {
                                to: {name: 'products'},
                                label: "Products",
                                icon: "ProductsMajor"
                            }, {
                                to: {name: "users"},
                                label: "Users",
                                icon: "CustomersMajor"
                            },{
                                to: {name: "analytics"},
                                label: "Analytics",
                                icon: "AnalyticsMajor"
                            },
                        ],
                    },
                ]
            }
        },
        methods: {
            async logout() {
                await this.$store.dispatch('unsetAdmin');
                this.isOpen=false;
                // this.$router.push({name: "login"});
            },
        }
    }
</script>
