<template>
    <v-footer color="primary" class="l-footer elevation-1 pa-4" dark :fixed="sidebar.clipped" app>
        <v-btn flat href="/api/documentation" target="_blank">
            <v-icon>book</v-icon> &nbsp; &nbsp;
           API Documentation
        </v-btn>
        <v-btn flat href="https://webnyxa.com" target="_blank">
            <v-icon>info</v-icon> &nbsp; &nbsp;
            Capabilities
        </v-btn>
        <v-btn flat href="https://webnyxa.com" target="_blank">
            <v-icon>people</v-icon> &nbsp; &nbsp;
            Team
        </v-btn>
        <v-spacer></v-spacer>
        Copyright &copy; 2016-{{year}} Webnyxa CMS &nbsp;
        <v-spacer></v-spacer>&nbsp; Developed by
        <v-btn flat href="http://webnyxa.com" target="_blank">webnyxa.com</v-btn>
    </v-footer>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapGetters} from 'vuex';

    @Component({
        computed: mapGetters(['sidebar', 'app_name']),
    })
    export default class Footer extends Vue {

        mounted() {


        }

        get year() {
            let d = new Date();
            return d.getFullYear();
        }

    }
</script>
