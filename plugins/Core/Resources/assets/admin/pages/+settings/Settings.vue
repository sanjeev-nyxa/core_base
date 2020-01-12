<template>
    <v-tabs
            v-model="active"
            color="primary"
            dark
            grow
    >
        <v-tab key="general-settings">
            <v-icon class="mr-2">info</v-icon>
            General
        </v-tab>
        <v-tab key="mail-settings">
            <v-icon class="mr-2">mail</v-icon>
            Mail
        </v-tab>
        <v-tab key="broadcaster-settings">
            <v-icon class="mr-2">hdr_strong</v-icon>
            Broadcaster
        </v-tab>
        <v-tab key="theme-settings">
            <v-icon class="mr-2">computer</v-icon>
            Theme
        </v-tab>
        <v-tab key="translations-settings">
            <v-icon class="mr-2">g_translate</v-icon>
            Translations
        </v-tab>


        <v-tab-item key="general-settings">
            <general-settings></general-settings>
        </v-tab-item>
        <v-tab-item key="mail-settings">
            <mail-settings></mail-settings>
        </v-tab-item>
        <v-tab-item key="broadcaster-settings">
            <broadcaster-settings></broadcaster-settings>
        </v-tab-item>
        <v-tab-item key="theme-settings">
            <theme-settings></theme-settings>
        </v-tab-item>
        <v-tab-item key="trans-settings">
            <trans-settings></trans-settings>
        </v-tab-item>
    </v-tabs>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import GeneralSettings from './_General';
    import MailSettings from './_Mail';
    import BroadcasterSettings from './_Broadcaster';
    import ThemeSettings from './_Theme';
    import TransSettings from './_Trans';

    @Component({
        components: {
            GeneralSettings, MailSettings, BroadcasterSettings, ThemeSettings, TransSettings
        }
    })
    export default class Settings extends Vue {
        active = null;

        mounted() {
            this.$store.dispatch('setBreadCrumbs', [
                'settings.index'
            ]);




        }

    }
</script>

<style scoped type="text/css">
    .card {
        margin: 5px;
    }
</style>
