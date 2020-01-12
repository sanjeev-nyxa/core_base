<template>
    <auth-layout>
        <form @submit.prevent="submit()" class="text-xs-center">
            <v-alert v-if="message" color="success" icon="check_circle" value="true">
                {{ message }}
            </v-alert>
            <div v-else>
                <v-text-field
                        name="email"
                        label="Email address"
                        type="email"
                        v-model="user.email"
                        append-icon="email"
                        :rules="messages.validation.message"
                        required
                ></v-text-field>
                <v-btn block color="primary" type="submit" :loading="$store.state.fetching">
                    Send password reset link
                </v-btn>
            </div>
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
    export default class ResetPassword extends Vue {
        user = {};
        message = false;

        submit() {
            this.$http.post('forgot-password', this.user)
                .then(res => this.message = res.data);
        }
    }
</script>
