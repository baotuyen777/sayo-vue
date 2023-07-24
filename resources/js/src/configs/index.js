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
        ...renderModuleRouter('roles'),
        ...renderModuleRouter('categories'),
    ]
};

const routes = [
    {
        path: '/',
        component: () => import("../components/layouts/Admin.vue"),
    },
    adminRoutes
];
// const BASE_URL='http://localhost:8000/'
// export const API_URL = BASE_URL+'api/';
// export const MEDIA_URL = BASE_URL+'storage/'
export const getEndpoint = (module, action = '', params = '') => {
    const paramUrl = params ? `/${params}` : '';
    const actionUrl = action ? action : (!params ? 'create': '')
    // return `${window.configValues.API_URL}${module}${paramUrl}/${actionUrl}`;
    return `${window.configValues.API_URL}${module}${paramUrl}`;
}
export default routes;
