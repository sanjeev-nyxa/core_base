<template>
    <auth-layout>
        <form @submit.prevent="submit()" class="text-xs-center">
            <v-text-field
                    outline
                    name="first_name"
                    label="First Name"
                    type="text"
                    v-model="user.first_name"
                    append-icon="person"
                    :rules="messages.validation.first_name"
                    required
            ></v-text-field>
            <v-text-field
                    outline
                    name="last_name"
                    label="Last Name"
                    type="text"
                    v-model="user.last_name"
                    append-icon="person"
                    :rules="messages.validation.last_name"
                    required
            ></v-text-field>
            <v-text-field
                    outline
                    name="email"
                    label="Email address"
                    type="email"
                    v-model="user.email"
                    append-icon="email"
                    :rules="messages.validation.email"
                    required
            ></v-text-field>
            <v-text-field
                    outline
                    name="password"
                    label="Password"
                    type="password"
                    append-icon="lock"
                    v-model="user.password"
                    :rules="messages.validation.password"
                    required
            ></v-text-field>
            <v-text-field
                    outline
                    name="password_confirmation"
                    label="Password Confirmation"
                    type="password"
                    append-icon="lock"
                    v-model="user.password_confirmation"
                    required
            ></v-text-field>
            <v-checkbox
                    outline
                    label="Accept Terms"
                    v-model="user.accept_terms"
                    primary
                    :rules="messages.validation.accept_terms"
            ></v-checkbox>
            <v-btn block color="primary" type="submit" v-bind:loading="$store.state.fetching">
                Sign Up
            </v-btn>
            <v-btn block router :to="{name: 'auth.login'}">
                Already have an account ?
            </v-btn>
        </form>
    </auth-layout>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapState} from 'vuex';
    import AuthLayout from './AuthLayout';

    @Component({
        components: {AuthLayout},
        computed: mapState(['messages'])
    })
    export default class Register extends Vue {
        user = {email: '', password: '', accept_terms: false};

        mounted() {
            this.user.email = this.$route.query.email;
        }

        submit() {
            this.$http.post('register', this.user)
                .then(res => {
                    this.$store.dispatch('setToken', res.data.token);
                    this.$store.dispatch('getUser');
                    if (this.$route.query.redirectTo) {
                        return this.$router.push(this.$route.query.redirectTo);
                    }
                    this.$router.push({name: 'dashboard.index'});
                });

        }
    }
</script>

<style type="text/sass" scoped>
    .l-auth__user-icon {
        font-size: 8rem; }
</style>
