<template>
    <div>
        <v-card class="mb-4">
            <v-card-title>
                <v-btn @click.prevent="backup()"
                       :loading="$store.state.fetching"
                       flat color="primary">
                    Create New Backup
                </v-btn>

                <v-spacer></v-spacer>
                <v-btn @click="dialog = true"
                       :loading="$store.state.fetching"
                       flat color="primary">
                    Upload New Backup
                </v-btn>
            </v-card-title>
        </v-card>
        <v-dialog
                v-model="dialog"
                width="500"
        >
            <multiple-file-uploader
                    headerMessage="Add Files"
                    postURL="api/admin/backups/upload"
                    successMessagePath="Files been uploaded successfully"
                    errorMessagePath="Oops Something went wrong"
                    :postHeader="postHeader"
                    @uploaded="fileUploaded"
            ></multiple-file-uploader>
        </v-dialog>
        <data-table
                api-route="admin/backups"
                route="logs"
                :bulk-actions="false"
                :actions="actions"
                :headers="headers"
        ></data-table>


    </div>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapState} from 'vuex';
    import DataTable from '@labs-core/admin/components/Tablage/table';
    import MultipleFileUploader from '@labs-core/admin/libraries/MultipleFileUploader'
    import {localStorageGetItem, localStorageSetItem} from "@labs-core/admin/plugins/local";

    @Component({
        computed: mapState(['messages']),
        components: {
            DataTable,
            MultipleFileUploader
        }
    })
    export default class BackupsTable extends Vue {
        dialog = false;
        _backup = {};

        postHeader = {
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': `Bearer ${localStorageGetItem('token')}`
        };


        get actions() {
            return [
                {
                    text: 'backups.restore',
                    color: 'blue',
                    fab: true,
                    dark: true,
                    icon: 'restore',
                    callback: (item) => {
                        this.$http.post('admin/backups/restore', {path: item.file_path}).then(response => {
                            console.info('Restored Response ::', response);
                            location.reload();
                        })
                    }
                },
                {
                    text: 'backups.edit',
                    color: 'primary',
                    fab: true,
                    icon: 'cloud_download',
                    callback: (item) => this.$http.download('admin/backups/download', item.file_path, item.name)
                },
                {
                    text: 'backups.delete',
                    color: 'red',
                    dark: true,
                    fab: true,
                    icon: 'delete',
                    callback: (item) => this.$events.$emit('table.delete-data', item.name)
                },
            ];
        }

        get headers() {
            return [
                {
                    text: 'name',
                    value: 'name',
                    align: 'left',
                    searchable: false,
                    sortable: false,
                },
                {
                    text: 'newest',
                    value: 'newest',
                    align: 'left',
                    searchable: false,
                    sortable: false,
                },
                {
                    text: 'size',
                    value: 'size',
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
                'backups.index'
            ]);
        }

        backup() {
            this.$http.post('admin/backups/create-new', {}).then(response => {
                this.$events.$emit('table.reload-data')
            })
        }

        fileUploaded(response) {
            this.$events.$emit('table.reload-data');
            this.dialog = false;
            this.$forceUpdate();
        }
    }
</script>
<style scoped>
    .stack-holder {
        max-width: 100%;
        overflow: scroll;
    }
</style>