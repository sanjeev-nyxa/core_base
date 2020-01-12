<template>
    <v-dialog v-model="dialog" fullscreen transition="v-dialog-bottom-transition" :overlay=false>
        <v-btn flat primary light slot="activator">
            <v-icon dark>settings</v-icon>
        </v-btn>
        <v-card>
            <v-toolbar>
                <v-btn icon="icon" block @click.native="dialog = false" light>
                    <v-icon>close</v-icon>
                </v-btn>
                <v-toolbar-title><span class="capitalize-text">{{ name }}</span> Table Settings</v-toolbar-title>
                <v-btn light flat @click.native="save()">Save</v-btn>
            </v-toolbar>

            <v-card-text>
                <v-list three-line subheader>
                    <v-subheader>Columns</v-subheader>
                    <div class="dd">
                        <ol class="dd-list">
                            <li v-for="(column, key) in columns" :key="key" class="dd-item"
                                :data-searchable="column.searchable"
                                :data-sortable="column.sortable"
                                :data-left="column.left"
                                :data-value="column.value"
                                :data-text="column.text"
                            >
                                <div class="dd-handle">
                                    <v-layout>
                                        <v-flex sm6>
                                            {{ column.text }}
                                        </v-flex>
                                        <v-flex sm6>
                                            <div class="dd-nodrag">
                                                <v-switch label="Sortable" v-model="column.sortable"></v-switch>
                                                <v-switch label="Searchable" v-model="column.searchable"></v-switch>
                                                <v-switch label="Left" v-model="column.left"></v-switch>
                                            </div>
                                        </v-flex>
                                    </v-layout>
                                </div>
                            </li>
                        </ol>
                    </div>
                </v-list>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component'

    @Component({
        props: {
            name: {
                required: true,
                type: String
            },
            columns: {
                required: true,
                type: Array
            }
        }
    })
    export default class TableSettings extends Vue {
        dialog = false;

        mounted() {
            // $('.dd').nestable();
        }

        save() {
            // this.dialog = false;
            // let columns = $('.dd').nestable('serialize');
            // this.$events.$emit('update-table-headers', columns);
            // columns = JSON.stringify(columns);
            // this.$http.put(`user/config`, {
            //     key: 'tables.' + this.name,
            //     data: columns
            // });
        }

    }
</script>