import Users from './users/Users';
import Profile from './Profile';
import UserManager from './users/UserManager';
import UserProfile from './users/UserProfile';

import Roles from './roles/Roles';
import RoleManager from './roles/RoleManager';
import Permissions from './roles/Permissions';

export default [
    {
        name: 'accounts.index',
        path: '/accounts',
        component: Users,
        meta: {requiresAuth: true, permission: 'view_users', icon: 'person', menu: true, order: 2},
        children: [
            {
                name: 'accounts.profile',
                path: '/profile',
                component: Profile,
                meta: {requiresAuth: true},
            },
            /*
             * Participant Management
             */
            {
                name: 'accounts.users.index',
                path: '/accounts',
                component: Users,
                meta: {requiresAuth: true, permission: 'view_users', menu: true},
            },
            {
                name: 'accounts.users.create',
                path: '/accounts/create',
                component: UserManager,
                meta: {requiresAuth: true, permission: 'create_users'},
            },
            {
                name: 'accounts.users.edit',
                path: '/accounts/:id/edit',
                component: UserManager,
                meta: {requiresAuth: true, permission: 'update_users'},
            },
            {
                name: 'accounts.users.profile',
                path: '/accounts/:id/profile',
                component: UserProfile,
                meta: {requiresAuth: true, permission: 'update_users'},
            },
            /*
             * Roles Managements
             */
            {
                name: 'accounts.roles.index',
                path: '/accounts/roles',
                component: Roles,
                meta: {requiresAuth: true, permission: 'view_roles', menu: true},
            },
            {
                name: 'accounts.roles.create',
                path: '/accounts/roles/create',
                component: RoleManager,
                meta: {requiresAuth: true, permission: 'create_roles'},
            },
            {
                name: 'accounts.roles.edit',
                path: '/accounts/roles/:id/edit',
                component: RoleManager,
                meta: {requiresAuth: true, permission: 'update_roles'},
            },
            {
                name: 'accounts.roles.permissions',
                path: '/accounts/roles/:id/permissions',
                component: Permissions,
                meta: {requiresAuth: true, permission: 'update_roles'},
            },
        ]
    }
];