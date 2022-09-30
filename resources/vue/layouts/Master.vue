<template>
    <div>
        <PFrame>
            <PTopBar
                slot="topBar"
                :showNavigationToggle=false
                :logo=logo
                :userMenu=userMenu
                :secondaryMenu='{"id":"Polaris-Menu","open":false,"actions":[{"items":[{"content":"Community forums"}]}],"icon":"QuestionMarkMajor"}'
                :searchField='{"value":"","placeholder":"Search","showFocusBorder":true}'
                :searchResult='{"items":[{"content":"Shopify help center"},{"content":"Community forums"}]}'
            />
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
                userMenu: {
                    "id": "Polaris-UserMenu",
                    "actions": [
                        {"items": [{"content": "Back to Shopify", "icon": "ArrowLeftMinor"}]},
                        {"items": [{"content": "Community forums"}]}
                    ],
                    "name": "Dharma",
                    "detail": "Hulkapps",
                    "initials": "D",
                    "open": false,
                    "message": {
                        "title": "Shopify Production",
                        "description": "New message",
                        "action": {"content": "Action"},
                        "link": {"to": "javascript:void(0);", "content": "Link", "external": true},
                        "badge": {"content": "Badge", "status": "warning"}
                    }
                },
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
                            },
                        ],
                    },
                ]
            }
        }
    }
</script>
