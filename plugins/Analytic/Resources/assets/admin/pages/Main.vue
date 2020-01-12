<template>
    <h2>Analytic Main Component</h2>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';

    @Component
    export default class Analytic extends Vue {

        mounted() {
            /*
             * Set Page BreadCrumb
             */
            this.$store.dispatch('setBreadCrumbs', [
                'analytic.index',
            ]);
        }
    }

</script>
