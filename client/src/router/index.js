import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    scrollBehavior () {
        return { x: 0, y: 0 }
    },
    routes: [

        {
            path: '',
            component: () => import('../layouts/Main.vue'),
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import('../views/Dashboard.vue'),
                },
                {
                    path: '/account',
                    name: 'account',
                    component: () => import('../views/account/Account.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', to: '/' },
                            { title: 'label.account', active: true },
                        ],
                        pageTitle: 'profile',
                    }
                },
                {
                    path: '/support',
                    name: 'support',
                    component: () => import("../views/support/Support.vue"),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', to: '/' },
                            { title: 'support', active: true },
                        ],
                        pageTitle: 'support',
                    }
                },
                {
                    path: '/faq',
                    name: 'faq',
                    component: () => import("../views/support/FAQ.vue"),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', to: '/' },
                            { title: 'faq', active: true },
                        ],
                        pageTitle: 'faq',
                    }
                },
            ],
        },
        {
            path: '',
            component: () => import('../layouts/Auth.vue'),
            children: [
                {
                    path: '/register',
                    name: 'register',
                    component: () => import('../views/auth/Register.vue'),
                    meta: {
                        withoutAuth: true,
                    },
                },
                {
                    path: '/login',
                    name: 'login',
                    component: () => import('../views/auth/Login.vue'),
                    meta: {
                        withoutAuth: true,
                    },
                },
                {
                    path: '/logout',
                    name: 'logout',
                    component: () => import('../views/auth/Logout.vue'),
                    meta: {
                        withoutAuth: false,
                    },
                },
                {
                    path: '/error-404',
                    name: 'error-404',
                    component: () => import('../views/errors/Error404.vue'),
                    meta: {
                        withoutAuth: true,
                    },
                },
            ]
        },
        {
            path: '*',
            redirect: '/error-404',
            meta: {
                withoutAuth: true,
            }
        },
    ],
});

// router.beforeEach((to, from, next) => {
//
// });

export default router
