import Vue from 'vue';
import Component from 'vue-class-component';
import {mapGetters} from 'vuex';
import AppHeader from "@labs-core/admin/components/Header";
import AppBreadcrumbs from "@labs-core/admin/components/Breadcrumbs";
import AppNotifications from "@labs-core/admin/components/Notifications";
import AppSideBar from "@labs-core/admin/components/Sidebar";
import AppFooter from "@labs-core/admin/components/Footer";
import {localStorageGetItem} from "./plugins/local";

@Component({
    computed: mapGetters(['isAuth']),
})
export default class App extends Vue {

    render(h) {
        return (
            <v-app light>
                {this.isAuth ? h(AppSideBar) : ''}
                {this.isAuth ? h(AppHeader) : ''}
                <v-content>
                    <v-container fluid class={'l-main'}>
                        {this.isAuth ? h(AppBreadcrumbs) : ''}
                        <transition name="fade" mode="out-in">
                            <router-view></router-view>
                        </transition>
                    </v-container>
                </v-content>
                {h(AppNotifications)}
                {h(AppFooter)}
            </v-app>
        );
    }

    created() {
        if (localStorageGetItem('token')) {
            this.$store.dispatch('getUser');
        }
        this.$store.dispatch('getConfigs', this);

        this.$store.subscribe((mutation, state) => {
            if (mutation.type === 'SET_BREADCRUMBS') {
                document.title = state.app_name + ': ' + mutation.payload.map(item => this.$t(item)).join(' / ');
            }
        })
    }
}