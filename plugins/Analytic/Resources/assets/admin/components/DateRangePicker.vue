<template>
    <form @submit.prevent="reloadData()" class="mb-4">
        <v-layout row wrap>
            <v-flex lg5 md5 sm5 xs12 class="mr-4">
                <v-menu
                        ref="menu"
                        lazy
                        :close-on-content-click="false"
                        v-model="chart_date_menu.start_at"
                        transition="scale-transition"
                        offset-y
                        full-width
                        :nudge-right="40"
                        min-width="290px"
                        :return-value.sync="date"
                >
                    <v-text-field
                            slot="activator"
                            label="Picker start at"
                            v-model="chart_date.start_at"
                            prepend-icon="event"
                            readonly
                    ></v-text-field>
                    <v-date-picker v-model="chart_date.start_at" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                        <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                    </v-date-picker>
                </v-menu>
            </v-flex>
            <v-flex lg5 md5 sm5 xs12 class="ml-4">
                <v-menu
                        ref="menu_end_at"
                        lazy
                        :close-on-content-click="false"
                        v-model="chart_date_menu.end_at"
                        transition="scale-transition"
                        offset-y
                        full-width
                        :nudge-right="40"
                        min-width="290px"
                        :return-value.sync="date"
                >
                    <v-text-field
                            slot="activator"
                            label="Picker end at"
                            v-model="chart_date.end_at"
                            prepend-icon="event"
                            readonly
                    ></v-text-field>
                    <v-date-picker v-model="chart_date.end_at" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                        <v-btn flat color="primary" @click="$refs.menu_end_at.save(date)">OK</v-btn>
                    </v-date-picker>
                </v-menu>
            </v-flex>
            <v-flex lg1 md1 sm1 xs4 class="pull-right text-xs-right">
                <v-btn @click="reloadData()" fab small color="primary" :loading="$store.state.fetching">
                   <v-icon>autorenew</v-icon>
                </v-btn>
            </v-flex>
        </v-layout>
    </form>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapState} from 'vuex';
    import moment from 'moment';

    @Component
    export default class DateRangePicker extends Vue {
        date = "";
        chart_date = {
            start_at: null,
            end_at: null
        };
        chart_date_menu = {
            start_at: false,
            end_at: false
        };

        mounted() {

        }


        reloadData() {
            this.$events.$emit('analyser:reload-data', {
                start_at: this.chart_date.start_at,
                end_at: this.chart_date.end_at
            })
        }
    }
</script>
