import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),
    scrollBehavior () {
        return { left: 0, top: 0 }
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
                {
                    path: '/contacts',
                    name: 'contacts',
                    component: () => import("../views/support/Contacts.vue"),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', to: '/' },
                            { title: 'contact', active: true },
                        ],
                        pageTitle: 'Contact',
                    }
                },
                {
                    path: '/article-create',
                    name: 'Create Article',
                    component: () => import('../views/Article/Create.vue'),
                    meta: {
                        premium: true,
                    },
                },
                {
                    path: '/articles',
                    name: 'Articles',
                    component: () => import('../views/Article/Index.vue'),
                },
                {
                    path: '/articles/:article_id',
                    name: 'Article',
                    component: () => import('../views/Article/Show.vue'),
                },
                {
                    path: '/articles/:article_id/edit',
                    name: 'Article Edit',
                    component: () => import('../views/Article/Edit.vue'),
                },
                {
                    path:'/search/:type',
                    name: 'Main Search',
                    component: () => import('../views/Search/Search.vue'),
                },
                {
                    path:'/users/:user_id',
                    name: 'User',
                    component: () => import('../views/User/Show.vue'),
                },
                {
                    path:'/premium',
                    name: 'Premium',
                    component: () => import('../views/premium/Index.vue'),
                },
                {
                    path: '/conferences',
                    name: 'Conferences',
                    component: () => import('../views/Conference/Index.vue'),
                },
                {
                    path: '/conferences/create',
                    name: 'Conferences Create',
                    component: () => import('../views/Conference/Create.vue'),
                },
                {
                    path: '/conferences/:conference_id',
                    name: 'Conference Show',
                    component: () => import('../views/Conference/Show.vue'),
                },
                {
                    path: '/conferences/:conference_id/edit',
                    name: 'Conference Edit',
                    component: () => import('../views/Conference/Edit.vue'),
                },
                {
                    path: '/conferences/:conference_id/add_article',
                    name: 'Conference Add Article',
                    component: () => import('../views/Conference/Article/Add.vue'),
                },
                {
                    path: '/partners/:partner_id',
                    name: 'Partner',
                    component: () => import('../views/partners/Show.vue'),
                },
                {
                    path: '/organizer/:organizer_id',
                    name: 'Organizer',
                    component: () => import('../views/organizers/Show.vue'),
                },
                {
                    path: '/organizations',
                    name: 'organizations',
                    component: () => import('../views/organizations/Index.vue'),
                },
                {
                    path: '/organizations/:organization_id',
                    name: 'organization',
                    component: () => import('../views/organizations/Show.vue'),
                },
                // {
                //     path: '/organizations/:organization_id/edit',
                //     name: 'organization-edit',
                //     component: () => import('../views/organizations/Edit.vue'),
                // },
                {
                    path: '/news',
                    name: 'news',
                    component: () => import('../views/news/Index.vue'),
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
                    path: '/404',
                    name: 'error-404',
                    component: () => import('../views/errors/Error404.vue'),
                    meta: {
                        withoutAuth: true,
                    },
                },
                {
                    path: '/403',
                    name: 'error-403',
                    component: () => import('../views/errors/Error403.vue'),
                    meta: {
                        withoutAuth: true,
                    },
                },
            ]
        },
        {
            path: '/:pathMatch(.*)*',
            redirect: '/404',
            meta: {
                withoutAuth: true,
            }
        },
    ],
});

router.beforeEach((to, from, next) => {
    if (!to.name) {
        next({ name: 'dashboard' });
    } else {
        next();
    }
});



export default router
