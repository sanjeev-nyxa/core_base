import LogsTable from './LogsTable'

export default [
    {
        name: 'logs.index',
        path: '/logs',
        component: LogsTable,
        meta: {
            requiresAuth: true,
            menu: true,
            permission: 'view_logs'
        },

    }
]
