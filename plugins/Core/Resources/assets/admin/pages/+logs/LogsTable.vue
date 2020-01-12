<template>
    <div>
        <data-table
                api-route="admin/logs"
                route="logs"
                :bulk-actions="false"
                :actions="actions"
                :headers="headers"
        ></data-table>

        <v-dialog
                v-model="dialog"
                full-width
        >
            <v-card>
                <v-card-title
                        class="headline grey lighten-2"
                        primary-title
                >
                    <span :class="level_class">
                        <i :class="level_img"></i> {{log.level}} ({{log.date}})
                    </span>
                </v-card-title>

                <v-card-text>
                    {{log.text}}
                </v-card-text>

                <v-divider></v-divider>

                <v-card-text>
                    <pre class="stack-holder">
                        {{log.stack}}
                    </pre>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            color="primary"
                            flat
                            @click="dialog = false"
                    >
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapState} from 'vuex';
    import DataTable from '@labs-core/admin/components/Tablage/table';

    @Component({
        computed: mapState(['messages']),
        components: {
            DataTable
        }
    })
    export default class LogsTable extends Vue {
        dialog = false;
        log = {};

        get level_class() {
            let level_class = {};
            level_class[this.log.level_class + '--text'] = true;
            return level_class;
        }

        get level_img() {
            let level_img = {};
            level_img['fa fa-' + this.log.level_img] = true;
            return level_img;
        }

        get actions() {
            return [
                {
                    text: 'logs.edit',
                    color: 'primary',
                    fab: true,
                    icon: 'pageview',
                    callback: (item) => {
                        this.dialog = true;
                        this.log = item;
                        console.info("Page view", item)
                    }
                },
            ];
        }

        get headers() {
            return [
                {
                    text: 'level',
                    value: 'level',
                    callback: log => {
                        return `<span class="${log.level_class}--text"><i class="fa fa-${log.level_img}"></i> ${log.level}</span> `;
                    },
                    align: 'left',
                    searchable: false,
                    sortable: false,
                },
                {
                    text: 'date',
                    value: 'date',
                    align: 'left',
                    searchable: false,
                    sortable: false,
                },
                {
                    text: 'text',
                    value: 'text',
                    callback: log => log.text.substring(0, 100) + '...',
                    align: 'left',
                    searchable: false,
                    sortable: false,
                },
                {
                    text: this.$t('table.actions'),
                    value: 'actions',
                    align: 'right',
                }
            ]
        }

        mounted() {
            this.$store.dispatch('setBreadCrumbs', [
                'logs.index'
            ]);
        }
    }
</script>
<style scoped>
    .stack-holder {
        max-width: 100%;
        overflow: scroll;
    }
</style>