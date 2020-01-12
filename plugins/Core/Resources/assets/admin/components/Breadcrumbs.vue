<template>
    <v-card class="mb-4">
        <v-breadcrumbs divider="/">
            <v-breadcrumbs-item v-for="breadcrumb of breadcrumbs" exact :key="breadcrumb" :to="{name: breadcrumb}">
                {{$t(breadcrumb)}}
            </v-breadcrumbs-item>
        </v-breadcrumbs>
    </v-card>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapGetters} from 'vuex';


    @Component({
        computed: mapGetters(['breadcrumbs'])
    })
    export default class Breadcrumbs extends Vue {

    }
</script>
