const renderModuleRouter = (module) => {
    return [
        {
            label: module,
            path: module,
            name: `admin-${module}`,
            component: () => import(`../pages/admin/${module}/index.vue`)
        },
        {
            path: `${module}/create`,
            name: `admin-${module}-create`,
            component: () => import(`../pages/admin/${module}/detail.vue`)
        },
        {
            path: `${module}/:id/edit`,
            name: `admin-${module}-edit`,
            component: () => import(`../pages/admin/${module}/detail.vue`)
        },

    ];
}

export const adminRoutes = {
    path: '/admin',
    component: () => import("../components/layouts/Admin.vue"),
    children: [
        ...renderModuleRouter('users'),
        ...renderModuleRouter('settings'),
        ...renderModuleRouter('categories'),
        ...renderModuleRouter('products'),
        ...renderModuleRouter('orders'),
        ...renderModuleRouter('posts'),
        ...renderModuleRouter('medias'),
        ...renderModuleRouter('pdws'),

        {
            label: 'login',
            path: 'login',
            name: `admin-user-login`,
            component: () => import('../pages/admin/users/login.vue')
        },
        {
            label: 'profile',
            path: 'profile',
            name: `admin-user-profile`,
            component: () => import('../pages/admin/users/profile.vue')
        },

    ]
};

const routes = [
    {
        path: '/',
        component: () => import("../components/layouts/Admin.vue"),
    },
    adminRoutes
];


export default routes;
