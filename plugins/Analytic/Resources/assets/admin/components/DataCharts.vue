<template>
    <v-card class="ma-2">
        <v-card-title>
            <h2> {{title}}</h2>
            <v-spacer></v-spacer>
            <b>Total :</b> {{charts.total}}
        </v-card-title>
        <v-card-text>
            <canvas ref="charts"></canvas>
        </v-card-text>

    </v-card>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import moment from 'moment';
    import Chart from 'chart.js';
    @Component({
        props: {
            model: {
                required: true,
                type: String
            },
            title: {
                required: true,
                type: String
            },
            chartLabel: {
                required: true,
                type: String
            },
            chartColor: {
                required: false,
                default: '#FF9800',
                type: String
            },
            start_at: {
                required: false,
                default: moment().subtract(30, 'days').format('YYYY-M-D'),
                type: String
            },
            end_at: {
                required: false,
                default: moment().format('YYYY-M-D'),
                type: String
            }
        },
    })
    export default class DataCharts extends Vue {
        charts = {
            total: 0
        };

        mounted() {
            this.$events.$on('analyser:reload-data', event => {
                this.session = {};
                this.loadData(event.start_at, event.end_at);
            });
            this.loadData(this.start_at, this.end_at);
        }

        loadData(start_at, end_at) {
            this.charts = {};
            this.$forceUpdate();
            this.$http.get(`analytics?model=${this.model}&&start=${start_at}&&end=${end_at}`).then(response => {
                this.charts = response.data;
                this.$nextTick(() => {
                    this.initChart();
                })
            });
        }

        initChart() {
            new Chart(this.$refs.charts, {
                type: 'line',
                data: {
                    labels: this.charts.labels,
                    datasets: [
                        {
                            data: this.charts.data,
                            borderColor: this.chartColor,
                            fill: false,
                            label: this.chartLabel,
                            type: 'line'
                        },
                    ]
                },

            });
        }
    }
</script>
