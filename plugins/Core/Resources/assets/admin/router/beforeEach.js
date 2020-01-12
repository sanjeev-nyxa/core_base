import store from "../store";
import {isEmpty} from "lodash";
import {localStorageGetItem} from "../plugins/local";

const needAuth = (auth, token) => auth !== undefined && auth && isEmpty(token);
const needGuest = (auth, token) => !auth && !isEmpty(token);

const beforeEach = (to, from, next) => {
    /**
     * Clears all global feedback message
     * that might be visible
     */
    store.dispatch('resetMessages');


    /**
     * If there's no token stored in the state
     * then check localStorage:
     */
    if (isEmpty(token)) {
        const localStoredToken = localStorageGetItem('token');
        const localStoredUser = localStorageGetItem('user');

        /**
         * Do we have token and user local stored?
         * If so then use it!
         */
        if (localStoredToken !== undefined &&
            localStoredToken !== null
        ) {
            store.dispatch('setToken', localStoredToken);
        }
    }

    let token = store.state.token;
    const auth = to.meta.requiresAuth;

    /**
     * If route doesn't require authentication
     * OR we have a token then let the route
     * be normally accessed.
     */
    if (!needAuth(auth, token)) {
        if(to.meta && to.meta.permission && store.getters.permissions.length) {
            if(!store.getters.permissions.filter(permission => permission.name == to.meta.permission).length) {
                next({name: 'dashboard.index'})
            }
        }
        next()
    }

    /**
     * If route doesn't require authentication
     * OR we have a token then let the route
     * be normally accessed.
     */
    if (auth === false && !isEmpty(token)) {
        next({name: 'dashboard.index'})
    }

    /**
     * Otherwise  if authentication is required
     * AND the token is empty, then redirect to
     * login.
     */
    if (needAuth(auth, token)) {
        next({name: 'auth.login'})
    }
};

export default beforeEach
