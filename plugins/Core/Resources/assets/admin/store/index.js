import Vue from 'vue';
import Vuex from 'vuex';
import state from './state';
import actions from './actions';
import mutations from './mutations';
import getters from './getters';
Vue.use(Vuex);

export default new Vuex.Store({
    state,
    mutations,
    actions,
    //modules,
    //plugins,
    getters,
    strict: process.env.NODE_ENV !== 'production'
});
