const renderModuleRouter = (module) => {
    return [
        {
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

const admin = [
    {
        path: '/',
        component: () => import("../components/layouts/admin.vue"),
    },
    {
        path: '/admin',
        component: () => import("../components/layouts/admin.vue"),
        children: [
            ...renderModuleRouter('users'),
            ...renderModuleRouter('settings'),
            ...renderModuleRouter('roles'),

        ]
    }
];



export default admin;
