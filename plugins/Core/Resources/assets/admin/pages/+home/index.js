import Dashboard from './Dashboard'
export default [{
    name: 'dashboard.index',
    path: '/',
    component: Dashboard,
    meta: {
        order: 1,
        requiresAuth: true,
        icon: 'dashboard',
        menu: true,
        permission: 'view_admin@dashboard'
    }
}]
