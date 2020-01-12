import Blogs from './Blogs'
import BlogManager from './BlogManager'

export default [
    {
        name: 'blogs.index',
        path: '/blogs',
        component: Blogs,
        meta: {
            requiresAuth: true,
            menu: true,
            permission: 'view_blog'
        },

    },
    {
        name: 'blogs.create',
        path: '/blogs/create',
        component: BlogManager,
        meta: {requiresAuth: true, permission: 'create_blog'},
    },
    {
        name: 'blogs.edit',
        path: '/blogs/:blog/edit',
        component: BlogManager,
        meta: {requiresAuth: true, permission: 'update_blog'},
    },


]
