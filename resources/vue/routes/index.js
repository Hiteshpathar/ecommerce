import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store';

Vue.use(VueRouter);


//Master Layout
import master from './../layouts/Master.vue';
import Home from '../pages/admin/home/Index'
import Orders from '../pages/admin/orders/Index'
import Users from "../pages/admin/users/Index";
import Products from "../pages/admin/products/Index";
import ViewUser from "../pages/admin/users/Show";

let routes = [
    {
        path: '/admin',
        component: master,
        children: [
            {
                path: '',
                component: Home,
                name: 'home',
                meta: {
                    title: 'Home',
                }
            },{
                path: 'orders',
                component: Orders,
                name: 'orders',
                meta: {
                    title: 'Orders',
                }
            },{
                path: 'products',
                component: Products,
                name: 'products',
                meta: {
                    title: 'Products',
                }
            },{
                path: 'users',
                component: Users,
                name: 'users',
                meta: {
                    title: 'Users',
                }
            },
            {
                path: 'view-user/:id',
                component: ViewUser,
                name: 'view-user',
                meta: {
                    title: 'View User',
                }
            },
        ]
    }
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

export default router;
