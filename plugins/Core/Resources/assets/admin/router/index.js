import Vue from 'vue';
import Router from 'vue-router';
//import beforeEach from './beforeEach'
import  '../pages';
import beforeEach from "./beforeEach";

Vue.use(Router);
// https://developer.mozilla.org/pt-BR/docs/Web/JavaScript/Reference/Operators/Spread_operator

function createRoutesFromMenu(routes) {
    let newRoutes = [];
    routes.filter(route => {
        return route.children;
    }).map(route => {
        return route.children;
    }).map(_routes => {
        _routes.map(item => {
            newRoutes.push(item);
        })
    });

    routes.filter(route => {
        return !route.children;
    }).map(route => {
        newRoutes.push(route);
    });

    return newRoutes;
}

const router = new Router({
    routes: [...createRoutesFromMenu(Zexus.routes)],
    linkActiveClass: 'active',
    //mode: 'history' // do not use /#/.
});

/**
 * Before a route is resolved we check for
 * the token if the route is marked as
 * requireAuth.
 */
router.beforeEach(beforeEach);

export default router
