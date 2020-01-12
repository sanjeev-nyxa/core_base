import Echo from "laravel-echo";
import {localStorageGetItem} from "../local";

if (Zexus.configs.echo.enabled) {
    const echo = new Echo({
        broadcaster: Zexus.configs.echo.broadcaster,
        host: Zexus.configs.echo.host,
        auth: {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Authorization': 'Bearer ' + localStorageGetItem('token')
            }
        }
    });
} else {
    const echo = {};
}

// export const echo;


// https://vuejs.org/v2/guide/plugins.html
export default function install(Vue) {
    // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperty
    Object.defineProperty(Vue.prototype, '$echo', {
        get() {
            return echo
        }
    })
}
