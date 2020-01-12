<template>
    <auth-layout>
        <form @submit.prevent="submit()" class="text-xs-center">
            <v-text-field
                    outline
                    name="email"
                    label="Email address"
                    type="email"
                    v-model="user.email"
                    append-icon="email"
                    required
                    :rules="messages.validation.email"
            ></v-text-field>
            <v-text-field
                    outline
                    name="password"
                    label="Password"
                    type="password"
                    append-icon="lock"
                    v-model="user.password"
                    required
            ></v-text-field>
            <v-btn block color="primary" type="submit" :loading="$store.state.fetching">
                Sign In
            </v-btn>
            <v-btn block router :to="{name: 'auth.password.forgot'}">
                Forgot Password ?
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
    export default class Login extends Vue {
        user = {email: '', password: ''};

        mounted() {
            if (this.$route.query.email) {
                // check if the user email exists
                this.checkAccountExists(this.$route.query.email);
                this.user.email = this.$route.query.email;
            }
        }

        submit() {
            this.$http.post('login', this.user).then(res => {
                this.$store.dispatch('setToken', res.data.data.token);
                this.$store.dispatch('getUser');

                if (this.$route.query.redirectTo) {
                    return this.$router.push(this.$route.query.redirectTo);
                }
                this.$router.push({name: 'dashboard.index'});
            }).catch(error => {
                this.$events.$emit('notify', {
                    type: 'warning',
                    title: 'Warning !',
                    message: 'Oops, please check you input'
                });
            })
        }

        checkAccountExists(email) {
            this.$http.get(`check-user/${email}`).then(res => {
                if (!res.data.id) {
                    this.$router.push({
                        name: 'auth.register',
                        query: {
                            email: this.$route.query.email,
                            redirectTo: this.$route.query.redirectTo
                        }
                    })
                }
            })
        }
    }
</script>
<style type="text/sass" scoped>
    .l-auth__user-icon {
        font-size: 8rem; }
</style>
