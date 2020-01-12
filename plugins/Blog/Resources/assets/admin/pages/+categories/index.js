import Categories from './Categories'
import CategoryManager from './CategoryManager'

export default [
    {
        name: 'categories.index',
        path: '/categories',
        component: Categories,
        meta: {
            requiresAuth: true,
            menu: true,
            permission: 'view_category'
        },

    },
    {
        name: 'categories.create',
        path: '/categories/create',
        component: CategoryManager,
        meta: {requiresAuth: true, permission: 'create_category'},
    },
    {
        name: 'categories.edit',
        path: '/categories/:category/edit',
        component: CategoryManager,
        meta: {requiresAuth: true, permission: 'update_category'},
    },


]
