<template>

    <v-layout row wrap>
        <v-flex xl6 lg6 md6>
            <v-card class="ma-3">
                <v-card-title>
                    <h2> Profile Settings</h2>
                </v-card-title>
                <v-card-text>
                    <form @submit.prevent="updateProfile()">
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
                                name="email"
                                type="email"
                                :label="$t('table.email')"
                                v-model="user.email"
                                :rules="messages.validation.email"
                                required
                                minlength="3"
                                maxlength="255"
                        ></v-text-field>
                        <v-text-field
                                name="phone_number"
                                :label="$t('table.phone_number')"
                                v-model="user.phone_number"
                                :rules="messages.validation.phone_number"
                                required
                                minlength="3"
                                maxlength="255"
                        ></v-text-field>
                        <v-select
                                :items="genders"
                                v-model="user.gender"
                                :label="$t('table.gender')"
                                class="input-group--focused"></v-select>
                        <v-select
                                :items="langs"
                                v-model="user.lang"
                                :label="$t('table.lang')"
                                class="input-group--focused"></v-select>
                        <v-btn color="primary" :loading="$store.state.fetching" type="submit">
                            Update
                        </v-btn>
                        <v-btn color="default" router :to="{name: 'accounts.users.index'}" type="reset">
                            {{ $t('form.cancel') }}
                        </v-btn>
                        <br><br><br>
                    </form>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-flex xl6 lg6 md6>
            <v-layout row wrap>
                <v-flex xl6 lg6 md6>
                    <v-card class="ma-3">
                        <v-card-title>
                            <h2>Change Avatar</h2>
                        </v-card-title>
                        <v-card-text>
                            <form @submit.prevent="uploadUserAvatar()">
                                <file-upload @input="setUserAvatar"></file-upload>
                                <v-btn color="primary" :loading="$store.state.fetching" type="submit">
                                    Change Avatar
                                </v-btn>
                            </form>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex xl6 lg6 md6>
                    <v-avatar v-if="user.avatar"
                              size="240"
                              color="grey lighten-4"
                    >
                        <img :src="user.avatar" alt="avatar">
                    </v-avatar>
                </v-flex>
                <v-flex xl12 lg12 md12>
                    <v-card class="ma-3">
                        <v-card-title>
                            <h2>Change Password</h2>
                        </v-card-title>
                        <v-card-text>
                            <form @submit.prevent="updatePassword()">
                                <v-text-field
                                        name="old_password"
                                        type="password"
                                        :label="$t('table.old_password')"
                                        v-model="password.old_password"
                                        :rules="messages.validation.old_password"
                                        required
                                        minlength="3"
                                        maxlength="255"
                                ></v-text-field>
                                <v-text-field
                                        name="password"
                                        type="password"
                                        :label="$t('table.password')"
                                        v-model="password.password"
                                        :rules="messages.validation.password"
                                        required
                                        minlength="3"
                                        maxlength="255"
                                ></v-text-field>
                                <v-text-field
                                        name="password_confirmation"
                                        type="password"
                                        :label="$t('table.password_confirmation')"
                                        v-model="password.password_confirmation"
                                        :rules="messages.validation.password_confirmation"
                                        required
                                        minlength="3"
                                        maxlength="255"
                                ></v-text-field>
                                <v-btn color="primary" :loading="$store.state.fetching" type="submit">
                                    Change Password
                                </v-btn>
                            </form>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>


        </v-flex>
    </v-layout>


</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapState} from 'vuex';
    import FileUpload from '@labs-core/admin/libraries/FileUpload';

    @Component({
        computed: mapState(['messages']),
        components: {
            FileUpload
        }
    })
    export default class UserManager extends Vue {
        avatar_form = {};
        user = {};
        password = {};
        roles = [];
        genders = ['Men', 'Women'];
        langs = ['en', 'fr'];
        image = null;

        mounted() {
            /*
             * Set Page BreadCrumb
             */
            this.$store.dispatch('setBreadCrumbs', [
                'accounts.users.index',
                'accounts.profile'
            ]);
            this.$http.get('user').then(response => this.user = response.data.data);

        }

        updatePassword() {
            this.$http.post('user/update-password', this.password)
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'success',
                        title: 'Success !',
                        message: "Your password was update successfully"
                    });
                    this.password = {};
                });
        }

        updateProfile() {
            this.$http.post('user', this.user)
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'success',
                        title: 'Success !',
                        message: "Your profile was update successfully"
                    });
                });
        }

        setUserAvatar(files) {
            let file = files[0];
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.user.avatar = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        uploadUserAvatar() {
            this.$http.put('user/update-avatar', {avatar: this.user.avatar})
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'success',
                        title: 'Success !',
                        message: "Your Avatar was updated successfully"
                    });
                });
        }


    }
</script>
