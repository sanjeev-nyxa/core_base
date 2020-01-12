<template>
    <auth-layout>
        <form @submit.prevent="submit()" class="text-xs-center">
            <v-text-field
                    name="email"
                    label="Email address"
                    type="email"
                    v-model="user.email"
                    append-icon="email"
                    :rules="messages.validation.email"
                    required
            ></v-text-field>
            <v-text-field
                    name="password"
                    label="Password"
                    type="password"
                    append-icon="lock"
                    v-model="user.password"
                    :rules="messages.validation.password"
                    required
            ></v-text-field>
            <v-text-field
                    name="password_confirmation"
                    label="Password Confirmation"
                    type="password"
                    append-icon="lock"
                    v-model="user.password_confirmation"
                    required
            ></v-text-field>
            <v-btn block color="primary" type="submit" v-bind:loading="$store.state.fetching">
                Reset Password
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
        computed: mapState(['messages']),
    })
    export default class EmailPassword extends Vue {
        user = {token: ''};

        submit() {
            this.user.token = this.$route.params.id;
            this.$http.post('reset-password', this.user)
                .then(res => {
                    this.$store.dispatch('setToken', res.data.data.token);
                    this.$store.dispatch('getUser');
                    // 1. check if the users comes from indent redirect
                    this.$router.push({name: 'dashboard.index'});
                });
        }
    }
</script>
