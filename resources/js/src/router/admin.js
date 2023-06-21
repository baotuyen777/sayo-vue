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
    component: () => import("../components/layouts/admin.vue"),
    children: [
        ...renderModuleRouter('users'),
        ...renderModuleRouter('settings'),
        ...renderModuleRouter('roles'),
        ...renderModuleRouter('categories'),

    ]
};

const routes = [
    {
        path: '/',
        component: () => import("../components/layouts/admin.vue"),
    },
    adminRoutes
];


export default routes;
