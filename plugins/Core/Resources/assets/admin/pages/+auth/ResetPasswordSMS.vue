<template>
    <auth-layout>
        <form @submit.prevent="submit()" class="text-xs-center">
            <v-alert v-if="message" color="success" icon="check_circle" value="true">
                {{ message }}
            </v-alert>
            <div v-else>
                <v-text-field
                        name="mobile_number"
                        label="Mobile Number"
                        v-model="user.mobile_number"
                        append-icon="phone_iphone"
                        :rules="messages.validation.message"
                        required
                ></v-text-field>

                <v-btn block color="primary" type="submit" :loading="$store.state.fetching">
                    Send Pin Code
                </v-btn>
                <v-btn block color="default" :to="{name: 'auth.password.forgot'}">
                    Reset Via Email
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
    export default class ResetPasswordSMS extends Vue {
        user = {mobile_number: ''};
        message = false;

        submit() {
            this.$http.post('forgot-password-sms', this.user)
                .then(res => {
                    this.$router.push({name: 'auth.password.reset_sms', params: {id: this.user.mobile_number}});
                });
        }
    }
</script>
