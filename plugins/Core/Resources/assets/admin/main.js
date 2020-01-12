import Vue from 'vue';
import App from './App';
import {sync} from 'vuex-router-sync';

/**
 * This is the Vuex store and it is
 * avaible to all your components
 */
import store from './store';

/**
 * This is the Router
 */
import router from './router';

/**
 * $http plugin based on axios
 */
import httpPlugin from './plugins/http';
import echoPlugin from './plugins/echo';
/**
 * $upload plugin based on Dropzone
 */
import uploadPlugin from './plugins/upload';
/**
 * Make $http avaible to all components
 * Send store and router to httpPlugin (injection)
 */
Vue.use(httpPlugin, {store, router});
Vue.use(echoPlugin);
Vue.use(uploadPlugin);
/**
 * Dynamic lang loader
 */
import i18n from './lang'

// Effortlessly keep vue-router and vuex store in sync.
sync(store, router); // https://github.com/vuejs/vuex-router-sync/tree/next


Vue.config.productionTip = false;
/* eslint-disable no-new */
new Vue({
    el: '#zix-admin',
    router,
    store,
    i18n,
    render: h => h(App)
});