<template>
    <h2>Backup Main Component</h2>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';

    @Component
    export default class Backup extends Vue {

        mounted() {
            /*
             * Set Page BreadCrumb
             */
            this.$store.dispatch('setBreadCrumbs', [
                'backup.index',
            ]);
        }
    }

</script>
