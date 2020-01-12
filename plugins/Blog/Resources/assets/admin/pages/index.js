import categories from "./+categories";
import blogs from "./+blogs";
import Blogs from "./+blogs/Blogs";

const Routes = [
    {
        name: 'blogs.index',
        path: '/blogs',
        component: Blogs,
        meta: {
            order: 3,
            requiresAuth: true,
            icon: 'book',
            menu: true,
            permission: 'view_blogs'
        },
        children: [
            ...categories,
            ...blogs
        ]
    }
];

Routes.map(route => {
    Zexus.routes.push(route)
});