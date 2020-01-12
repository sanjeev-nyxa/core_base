<template>
    <form @submit.prevent="save()">
        <v-card class="mb-3">
            <v-card-title>
                <span>
                    To pluck select click on the permissions type*
                </span>
                <v-spacer></v-spacer>
                <v-text-field
                        append-icon="search"
                        :label="$t('table.search')"
                        single-line
                        hide-details
                        v-model="search"
                ></v-text-field>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="permissions"
                    :search="search"
                    :pagination.sync="pagination"
                    :custom-filter="searchPermissions"
            >
                <template slot="items" slot-scope="props">
                    <td @click="toggleSelect(props.item)">{{props.item.toUpperCase()}}</td>
                    <td class="text-xs-right" v-for="action in actions">
                        <v-switch v-model="user_permissions[action + '_' + props.item]"
                                  color="primary"></v-switch>
                    </td>
                </template>
            </v-data-table>
        </v-card>


        <v-btn color="primary" :loading="$store.state.fetching" type="submit">
            <i v-if="$store.state.fetching" class="fa fa-spinner fa-pulse"></i>
            {{ edit ? $t('form.edit') : $t('form.create') }}
        </v-btn>
        <v-btn type="reset" router :to="{name: 'accounts.roles.index'}">
            {{ $t('form.cancel') }}
        </v-btn>
    </form>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component'
    import {mapState} from 'vuex'

    @Component({
        computed: {
            ...mapState(['messages'])
        }
    })
    export default class Permissions extends Vue {
        pagination = {
            rowsPerPage: 10
        };
        search = '';
        role = {};
        user_permissions = {};
        guards = [];
        actions = ["view", "create", "update", "delete"];
        permissions = [];
        headers = [
            {
                text: 'Type',
                align: 'left',
                value: ''
            },
            {text: 'View', value: 'view', align: 'left', sortable: false},
            {text: 'Create', value: 'create', align: 'left', sortable: false},
            {text: 'Update', value: 'update', align: 'left', sortable: false},
            {text: 'Delete', value: 'delete', align: 'left', sortable: false}
        ];

        mounted() {
            /*
             * Set Page BreadCrumb
             */
            this.$store.dispatch('setBreadCrumbs', [
                'accounts.roles.index',
                'accounts.roles.' + (this.edit ? 'edit' : 'add'),
                'accounts.roles.permissions',
            ]);

            this.$http.get('admin/permissions')
                .then(response => {
                    let guards = [];
                    let permissions = [];

                    response.data.data.map(permission => {
                        guards.push(permission.guard_name);
                        permissions.push(permission.name.split('_')[1]);
                    });


                    this.guards = guards.filter((guard_name, index, self) => {
                        return self.indexOf(guard_name) === index;
                    });


                    this.permissions = permissions.filter((name, index, self) => {
                        return self.indexOf(name) === index;
                    });
                })
                .then(response => this.$http.get('admin/roles/' + this.$route.params.id)
                    .then(response => {
                        let role = response.data.data;
                        let user_permissions = {};
                        if (role.permissions.length) {
                            role.permissions.map(permission => {
                                user_permissions[permission.name] = true;
                            });
                        }
                        this.user_permissions = user_permissions;
                    }));
        }

        get edit() {
            return !!this.$route.params.id;
        }

        save() {
            this.$http.post('admin/roles/' + this.$route.params.id + '/permissions', this.user_permissions)
                .then(res => {
                    this.$events.$emit('notify', {
                        type: 'info',
                        title: 'Success !',
                        message: this.$t('notifications.data.updated_successfully')
                    });
                    this.$router.push({name: 'accounts.roles.index'})
                });
        }

        searchPermissions(items, search, filter, headers) {
            return items.filter(item => item.includes(search))
        }

        toggleSelect(permission) {
            let user_permissions = this.user_permissions;

            this.actions.map(action => {
                user_permissions[action + '_' + permission] = true;
            });
            this.$nextTick(() => {
                this.user_permissions = user_permissions;
                this.$forceUpdate();
            });
        }
    }
</script>
