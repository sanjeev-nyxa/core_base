import axios from 'axios'
import interceptors from './interceptors'
import downloaders from './downloaders'

// allow use http client without Vue instance
export const http = axios.create({
    baseURL: Zexus.configs.admin.base_api_url
});

/**
 * Helper method to set the header with the token
 */
http.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// receive store and data by options
// https://vuejs.org/v2/guide/plugins.html
export default function install(Vue, {store, router}) {
    interceptors(http, store, router);
    downloaders(http, store, router);

    // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperty
    Object.defineProperty(Vue.prototype, '$http', {
        get() {
            store.dispatch('setFetching', {fetching: true});
            store.dispatch('resetMessages');
            return http
        }
    })
}
