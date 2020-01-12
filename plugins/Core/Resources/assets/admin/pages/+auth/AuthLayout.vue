<template>
    <v-layout row wrap class="auth-wrapper" :style="{'height': height+'px', 'padding-top': (height/10)+'px'}">
        <v-flex lg4 md3 offset-lg2 class="pa-5">
            <img src="/images/logo.png" class="img-responsive logo"
                 @click.prevent="() => $router.push({name: 'auth.login'})">
        </v-flex>
        <v-flex lg4 md6>
           <div class="auth-box" :style="{
                     'border': '2px solid '+$store.state.configs['admin.theme.primary'],
                     'background-color': hexToRgb($store.state.configs['admin.theme.primary'])
                 }">
               <slot></slot>
           </div>
        </v-flex>
    </v-layout>
</template>

<script>
    import Vue from "vue";
    import Component from "vue-class-component";

    @Component
    export default class AuthLayout extends Vue {

        get height() {
            return window.innerHeight - 100;
        }

        hexToRgb(hex) {
            let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ?  `rgba(${parseInt(result[1], 16)}, ${parseInt(result[2], 16)}, ${parseInt(result[3], 16)}, 0.1)` : "rgba(156, 39, 176, 0.1)";
        }
    }

</script>

<style scoped>
    .auth-wrapper {
        /* Center and scale the image nicely */
        background: url("/images/login-bg.png") no-repeat center;
        background-size: cover;
    }

    .auth-box {
        padding: 15px;
        border-radius: 10px;
    }
</style>