<template>
    <form @submit.prevent="save()">
        <v-card class="mb-3">
            <v-card-text>

                <v-text-field
                        name="role_name"
                        :label="$t('table.name')"
                        v-model="role.name"
                        :rules="messages.validation.name"
                        autofocus
                        required
                ></v-text-field>

            </v-card-text>
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
    export default class RoleManager extends Vue {
        role = {guard_name: 'api'};

        mounted() {
            /*
             * Set Page BreadCrumb
             */
            this.$store.dispatch('setBreadCrumbs', [
                'accounts.roles.index',
                'accounts.roles.' + (this.edit ? 'edit' : 'add')
            ]);

            if (this.edit) {
                this.$http.get('admin/roles/' + this.$route.params.id).then(response => this.role = response.data.data);
            }
        }

        save() {
            return this.edit ? this.update() : this.create();
        }

        get edit() {
            return !!this.$route.params.id;
        }

        update() {
            return this.$http.put('admin/roles/' + this.$route.params.id, this.role).then(response => {
                this.$events.$emit('notify', {
                    type: 'info',
                    title: 'Success !',
                    message: this.$t('notifications.data.updated_successfully')
                });
                this.$router.push({name: 'accounts.roles.index'});
            });
        }

        create() {
            return this.$http.post('admin/roles', this.role).then(response => {
                this.$events.$emit('notify', {
                    type: 'success',
                    title: 'Success !',
                    message: this.$t('notifications.data.created_successfully')
                });
                this.$router.push({name: 'accounts.roles.index'});
            });
        }

    }
</script>
