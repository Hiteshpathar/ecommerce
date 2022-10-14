import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store';

Vue.use(VueRouter);


//Master Layout
import master from '../layouts/admin/Master.vue';
import Home from '../pages/admin/home/Index'
import Orders from '../pages/admin/orders/Index'
import Users from "../pages/admin/users/Index";
import Products from "../pages/admin/products/Index";
import ViewUser from "../pages/admin/users/Show";
import AddProduct from "../pages/admin/products/Add";
import Login from "../pages/admin/auth/Login";
import Analytics from "../pages/admin/analytics/Index";

let routes = [
    {
        path: '/admin',
        component: master,
        children: [
            {
                path: '/',
                redirect: 'login'
            }, {
                path: 'login',
                component: Login,
                name: 'login',
                meta: {
                    requiresGuest: true
                }
            }, {
                path: 'home',
                component: Home,
                name: 'home',
                meta: {
                    title: 'Home',
                    isAdminPage: true,
                    requiresAdminAuth: true
                }
            }, {
                path: 'orders',
                component: Orders,
                name: 'orders',
                meta: {
                    title: 'Orders',
                    isAdminPage: true,
                    requiresAdminAuth: true
                }
            }, {
                path: 'products',
                component: Products,
                name: 'products',
                meta: {
                    title: 'Products',
                    isAdminPage: true,
                    requiresAdminAuth: true
                }
            }, {
                path: 'users',
                component: Users,
                name: 'users',
                meta: {
                    title: 'Users',
                    isAdminPage: true,
                    requiresAdminAuth: true
                }
            },{
                path: 'analytics',
                component: Analytics,
                name: 'analytics',
                meta: {
                    title: 'Analytics',
                    isAdminPage: true,
                    requiresAdminAuth: true
                }
            },
            {
                path: 'view-user/:id',
                component: ViewUser,
                name: 'view-user',
                meta: {
                    title: 'View User',
                    isAdminPage: true,
                    requiresAdminAuth: true
                }
            }, {
                path: 'add-product/:id?',
                component: AddProduct,
                name: 'add-product',
                meta: {
                    title: 'Add Product',
                    isAdminPage: true,
                    requiresAdminAuth: true
                }
            },
            {
                path: '*',
                redirect: {name:'users'}
            }
        ]
    },
    {
        path: '/',
        component: require('./../layouts/Auth').default,
        children: [
            {
                path: '/',
                redirect: {name:'user-login'}
            },
            {
                path: 'login',
                component: require('./../pages/user/auth/Login').default,
                name: 'user-login',
            },
            {
                path: '*',
                component: require('./../pages/user/auth/Login').default,
                name: 'user-login',
            },
        ]
    },
];

const router = new VueRouter({
    mode: 'history',
    routes,
    scrollBehavior() {
        return {
            x: 0,
            y: 0,
        };
    },

});

// Verify Auth.

router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAdminAuth) {
        let requiresAuth = await store.dispatch('adminAuth/isLoggedIn');
        if (requiresAuth) {
            return next();
        } else {
            return next({name: 'login'})
        }
    }
    return next();
});

export default router;
