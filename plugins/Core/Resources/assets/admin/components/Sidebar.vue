<template>
    <v-navigation-drawer class="l-sidebar" fixed app
                         :mini-variant="sidebar.mini_variant"
                         :clipped="sidebar.clipped"
                         :value="sidebar.show"
    >
        <v-list dense>
            <div v-for="route of valid(router)" :key="route.name">
                <v-list-group v-if="route.children && route.children.length" no-action>
                    <v-list-tile ripple slot="activator">
                        <v-list-tile-action>
                            <v-icon>{{route.meta.icon}}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>{{$t(route.name)}}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

                    <v-list-tile v-for="child of valid(route.children)" ripple router :to="{name: child.name}"
                                 :key="child.name">
                        <v-list-tile-action v-if="child.meta.icon">
                            <v-icon>{{child.meta.icon}}</v-icon>
                        </v-list-tile-action>

                        <v-list-tile-content>
                            <v-list-tile-title>{{$t(child.name)}}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list-group>

                <v-list-tile v-else ripple exact router :to="{name: route.name}" :key="route.name">
                    <v-list-tile-action v-if="route.meta.icon">
                        <v-icon>{{route.meta.icon}}</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>{{$t(route.name)}}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </div>
        </v-list>
    </v-navigation-drawer>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapGetters} from 'vuex';

    @Component({
        computed: mapGetters(['sidebar', 'permissions'])
    })
    export default class Sidebar extends Vue {

        get router() {
            return this.valid(Zexus.routes);
        }

        valid(routes) {
            return collect(routes).sortBy(route => route.meta.order).filter(route => route.meta.menu).toArray();
        }

        can(permission) {
            return permission ? collect(this.permissions).pluck('name').search(permission) : true;
        }

    }
</script>
