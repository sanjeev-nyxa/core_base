import Vue from 'vue'
import Vuetify from 'vuetify'
import VueEvents from 'vue-events';
import VueChatScroll from "vue-chat-scroll";
import VueScrollTo from "vue-scrollto";
import MavonEditor from 'mavon-editor';
import 'mavon-editor/dist/css/index.css';
import moment from 'moment-timezone';

/**
 * Vuetify UI
 */
Vue.use(Vuetify, {
    theme: Zexus.configs.admin.theme
});
Vue.use(VueEvents);
Vue.use(VueChatScroll);
Vue.use(VueScrollTo);
Vue.use(MavonEditor);

moment.tz.setDefault(Zexus.configs.timezone);