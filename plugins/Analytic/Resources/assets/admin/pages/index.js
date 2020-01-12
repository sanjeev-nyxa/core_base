import Analytic from './Main.vue'
// ROUTE__IMPORTS
const Routes = [
    {
        name: 'analytic.index',
        path: '/analytic',
        component: Analytic,
        meta: {
            order: 3,
            requiresAuth: true,
            icon: 'fiber_new',
            menu: true,
            permission: 'view_analytic'
        },
        children: [
            // ROUTE__CHILDREN
        ]
    }
];

Routes.map(route => {
    Zexus.routes.push(route)
});