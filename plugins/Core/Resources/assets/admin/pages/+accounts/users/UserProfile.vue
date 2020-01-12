<template>
    <form @submit.prevent="save()">
        <v-card class="mb-3">
            <v-card-text>
                <v-text-field
                        name="first_name"
                        :label="$t('table.first_name')"
                        v-model="user.first_name"
                        :rules="messages.validation.first_name"
                        required
                        minlength="3"
                        maxlength="255"
                ></v-text-field>
                <v-text-field
                        name="last_name"
                        :label="$t('table.last_name')"
                        v-model="user.last_name"
                        :rules="messages.validation.last_name"
                        required
                        minlength="3"
                        maxlength="255"
                ></v-text-field>

                <v-text-field
                        name="mobile_number"
                        :label="$t('table.mobile_number')"
                        v-model="user.mobile_number"
                        :rules="messages.validation.mobile_number"
                        prepend-icon="phone"
                        minlength="3"
                        maxlength="255"
                ></v-text-field>


            </v-card-text>
        </v-card>

        <v-btn color="primary" :loading="$store.state.fetching" type="submit">
            <i v-if="$store.state.fetching" class="fa fa-spinner fa-pulse"></i>
            {{ edit ? $t('form.edit') : $t('form.create') }}
        </v-btn>
        <v-btn color="default" router :to="{name: 'accounts.users.index'}" type="reset">
            {{ $t('form.cancel') }}
        </v-btn>
    </form>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapState, mapActions} from 'vuex';

    @Component({
        computed: mapState(['messages'])
    })
    export default class UserProfile extends Vue {
        user = {};

        mounted() {
            /*
             * Set Page BreadCrumb
             */
            this.$store.dispatch('setBreadCrumbs', [
                'accounts.users.index',
                'accounts.users.' + (this.edit ? 'edit' : 'add'),
                'accounts.users.profile'
            ]);
            if (this.edit) {
                this.$http.get('admin/users/' + this.$route.params.id).then(response => this.user = response.data.data);
            } else {
                this.$router.push({name: 'accounts.users.index'});
            }

        }

        get edit() {
            return !!this.$route.params.id;
        }

        save() {
            // if form for create
            return this.edit ? this.update() : this.create();
        }

        update() {
            this.$http.put(`admin/users/${this.$route.params.id}/profile`, this.user)
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'info',
                        title: 'Success !',
                        message: this.$t('notifications.data.updated_successfully')
                    });
                    this.$router.push({name: 'accounts.users.index'});
                });
        }


    }
</script>
