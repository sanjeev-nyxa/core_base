<template>
    <auth-layout>
        <form @submit.prevent="submit()" class="text-xs-center">
            <v-text-field
                    v-if="!user.token"
                    name="mobile_number_code"
                    label="Enter the 4 digit code to reset your password"
                    v-model="user.mobile_number_code"
                    append-icon="phone"
                    :rules="messages.validation.mobile_number_code"
                    required
                    mask="#-#-#-#"
            ></v-text-field>
            <v-text-field
                    v-if="user.token"
                    name="password"
                    label="Password"
                    type="password"
                    append-icon="lock"
                    v-model="user.password"
                    :rules="messages.validation.password"
                    required
            ></v-text-field>
            <v-text-field
                    v-if="user.token"
                    name="password_confirmation"
                    label="Password Confirmation"
                    type="password"
                    append-icon="lock"
                    v-model="user.password_confirmation"
                    required
            ></v-text-field>

            <v-btn block color="primary" type="submit" v-bind:loading="$store.state.fetching">
                {{!user.token ? 'Confirm Pin Code': 'Reset Password'}}
            </v-btn>
        </form>
    </auth-layout>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapState} from "vuex";
    import AuthLayout from './AuthLayout';

    @Component({
        components: {AuthLayout},
        computed: mapState(['messages'])
    })
    export default class ConfirmPinPassword extends Vue {
        user = {mobile_number_code: '', mobile_number: '', token: null, email: null};

        submit() {
            this.user.mobile_number = this.$route.params.id;
            this.user.token ? this.resetPassword() : this.confirmPin();
        }

        resetPassword() {
            this.$http.post('reset-password-sms', this.user)
                .then(res => {
                    this.$store.dispatch('setToken', res.data.data.token);
                    this.$store.dispatch('getUser');
                    this.$events.$emit('notify', {
                        type: 'success',
                        title: 'success !',
                        message: 'Your password has been updated successfully'
                    });
                    this.$router.push({name: 'dashboard.index'});
                });
        }

        confirmPin() {
            this.$http.post('reset-password/confirm-pin', this.user)
                .then(res => {
                    this.user.token = res.data.token;
                    this.user.email = res.data.email;
                });
        }
    }
</script>
