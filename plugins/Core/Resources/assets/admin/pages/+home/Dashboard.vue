<template>
    <v-layout row wrap>
        <v-flex md12 class="pull-right text-xs-right">

            <v-spacer></v-spacer>
            <v-btn
                    slot="activator"
                    fab
                    flat
                    @click="() => date_range_dialog = true"
            >
                <v-icon>date_range</v-icon>
            </v-btn>
        </v-flex>
        <v-flex xl3 lg4 md6>
            <analytic-data-charts
                    title="Users Reports"
                    chart-label="Register"
                    chart-color="#607D8B"
                    model="App\User"
            ></analytic-data-charts>
        </v-flex>

        <v-flex xl3 lg4 md6>
            <analytic-data-charts
                    title="Blogs Reports"
                    chart-label="News"
                    chart-color="#607D8B"
                    model="Labs\Blog\Entities\Blog"
            ></analytic-data-charts>
        </v-flex>



        <v-dialog
                v-model="date_range_dialog"
                width="80%"
        >
            <v-card>
                <v-card-title primary-title class="headline">
                   Analytic Chart Date Range Picker
                </v-card-title>

                <v-card-text>
                    <analytic-date-range-picker></analytic-date-range-picker>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';

    @Component({
        components: {}
    })
    export default class Dashboard extends Vue {
        date_range_dialog = false;

        mounted() {
            this.$store.dispatch('setBreadCrumbs', []);


        }

    }
</script>

