import BackupsTable from './+backups/BackupsTable'
import backups from './+backups'
const Routes = [
    {
        name: 'backup.index',
        path: '/backup',
        component: BackupsTable,
        meta: {
            order: 99,
            requiresAuth: true,
            icon: 'backup',
            menu: true,
            // permission: 'view_backup'
        },
    }
];

Routes.map(route => {
    Zexus.routes.push(route)
});