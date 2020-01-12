import Settings from './Settings';
import logs from '../+logs'
export default [{
    name: 'settings.index',
    path: '/settings',
    component: Settings,
    meta: {
        order: 100,
        requiresAuth: true,
        icon: 'settings',
        menu: true,
        permission: 'view_admin@dashboard'
    },
    children: [
        {
            name: 'settings.general.index',
            path: '/settings',
            component: Settings,
            meta: {
                requiresAuth: true,
                menu: true,
                permission: 'view_admin@dashboard'
            },
        },
        ...logs
    ]
}]
