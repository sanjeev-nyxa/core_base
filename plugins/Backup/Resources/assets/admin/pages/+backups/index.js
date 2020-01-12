import BackupsTable from './BackupsTable'

export default [
    {
        name: 'backups.index',
        path: '/backups',
        component: BackupsTable,
        meta: {
            requiresAuth: true,
            menu: true,
            permission: 'view_backups'
        },

    },
]
