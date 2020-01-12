<template>
    <v-toolbar class="l-header__top primary" app dark fixed :clipped-left="sidebar.clipped">
        <v-toolbar-side-icon @click="() => $store.dispatch('toggleSidebar')"></v-toolbar-side-icon>
        <v-toolbar-title>{{app_name}}</v-toolbar-title>
        <v-spacer></v-spacer>

        <v-toolbar-items>
            <v-btn flat @click="$router.push('profile')">
                Profile Settings
            </v-btn>
            <v-btn flat @click="() => {dialog = true}">
                Logout
            </v-btn>
        </v-toolbar-items>

        <v-dialog v-model="dialog" max-width="290">
            <v-card class="text-center">
                <v-card-text>
                    <v-icon x-large color="primary">exit_to_app</v-icon>
                    <h2>
                        Are you sure you want to logout {{app_name}}
                    </h2>
                </v-card-text>
                <v-card-actions>
                    <v-btn block color="primary" @click="logout()" class="text-uppercase">
                        Yes, Logout
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-toolbar>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapGetters} from 'vuex';

    @Component({
        computed: mapGetters(['sidebar', 'app_name']),
    })
    export default class Notifications extends Vue {
        dialog = false;

        mounted() {
            this.updateWindowScreen();
        }

        updateWindowScreen() {
            console.info('Window Resized')
            let width = window.innerWidth;
            if (width > 1450 && !this.sidebar.show) {
                this.$store.dispatch('toggleSidebar');
            }
            if (width < 1450 && this.sidebar.show) {
                this.$store.dispatch('toggleSidebar');
            }
        }

        logout() {
            this.$store.dispatch('logout');
            this.dialog = false;
            this.$router.push({name: 'auth.login'});
        }
    }
</script>
