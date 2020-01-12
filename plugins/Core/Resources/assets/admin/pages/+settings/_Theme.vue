<template>
    <v-card flat>
        <v-card-text>
            <form @submit.prevent="save()">
                <h2>Theme Colors :</h2>
                <v-layout wrap row class="pb-5">
                    <v-flex sm3 class="pt-2">
                        <h3 class="pb-2">{{$t('table.primary_color')}} :</h3>
                        <swatches-picker
                                v-model="config['admin.theme.primary']"
                                name="primary_color"
                                :label="$t('table.primary_color')"
                        ></swatches-picker>
                    </v-flex>

                    <v-flex sm3 class="pt-2">
                        <h3 class="pb-2">{{$t('table.secondary_color')}} :</h3>
                        <swatches-picker
                                v-model="config['admin.theme.secondary']"
                                name="secondary_color"
                                :label="$t('table.secondary_color')"
                        ></swatches-picker>
                    </v-flex>

                    <v-flex sm3 class="pt-2">
                        <h3 class="pb-2">{{$t('table.accent_color')}} :</h3>
                        <swatches-picker
                                v-model="config['admin.theme.accent']"
                                name="accent_color"
                                :label="$t('table.accent_color')"
                        ></swatches-picker>
                    </v-flex>


                </v-layout>
                <hr class="mb-3">
                <h2>Notification Colors :</h2>
                <v-layout wrap row class="pb-5">
                    <v-flex sm3 class="pt-2">
                        <h3 class="pb-2">{{$t('table.warning_color')}} :</h3>
                        <swatches-picker
                                v-model="config['admin.theme.warning']"
                                name="warning_color"
                                :label="$t('table.warning_color')"
                        ></swatches-picker>
                    </v-flex>

                    <v-flex sm3 class="pt-2">
                        <h3 class="pb-2">{{$t('table.info_color')}} :</h3>
                        <swatches-picker
                                v-model="config['admin.theme.info']"
                                name="info_color"
                                :label="$t('table.info_color')"
                        ></swatches-picker>
                    </v-flex>

                    <v-flex sm3 class="pt-2">
                        <h3 class="pb-2">{{$t('table.success_color')}} :</h3>
                        <swatches-picker
                                v-model="config['admin.theme.success']"
                                name="success_color"
                                :label="$t('table.success_color')"
                        ></swatches-picker>
                    </v-flex>

                    <v-flex sm3 class="pt-2">
                        <h3 class="pb-2">{{$t('table.error_color')}} :</h3>
                        <swatches-picker
                                v-model="config['admin.theme.error']"
                                name="error_color"
                                :label="$t('table.error_color')"
                        ></swatches-picker>
                    </v-flex>

                </v-layout>


                <v-btn color="primary" :loading="$store.state.fetching" type="submit">
                    Update Config
                </v-btn>
                <v-btn color="default" router :to="{name: 'accounts.users.index'}" type="reset">
                    {{ $t('form.cancel') }}
                </v-btn>
            </form>
        </v-card-text>
    </v-card>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapState} from 'vuex';
    import {Swatches} from 'vue-color';

    @Component({
        computed: mapState(['messages']),
        components: {
            'swatches-picker': Swatches
        }
    })
    export default class Theme extends Vue {
        config = {
            'admin.theme.primary': {hex: '#8FD337'},
            'admin.theme.secondary': {hex: '#8FD337'},
            'admin.theme.accent': {hex: '#82B1FF'},
            'admin.theme.error': {hex: '#FF5252'},
            'admin.theme.info': {hex: '#2196F3'},
            'admin.theme.success': {hex: '#4CAF50'},
            'admin.theme.warning': {hex: '#FFC107'},
        };
        old_config = {
            admin: {
                theme: {
                    primary: {hex: '#8FD337'},
                    secondary: {hex: '#8FD337'},
                    accent: {hex: '#82B1FF'},
                    error: {hex: '#FF5252'},
                    info: {hex: '#2196F3'},
                    success: {hex: '#4CAF50'},
                    warning: {hex: '#FFC107'},
                }
            }
        };

        mounted() {

            this.$watch('config', config => {
                let theme = {};
                Object.keys(config).map(function (key, index) {
                    // console.info('==>', key.split('.theme.')[1], config[key].hex)
                    theme[key.split('.theme.')[1]] = config[key].hex;
                });
                this.$vuetify.theme = theme;
                // console.info('Config ::', config)
            }, {deep: true});

            this.$http.get('admin/configs?group=admin_theme').then(response => this.setConfigs(response.data.data));
        }


        save() {
            this.$http.post('admin/configs?group=admin_theme', this.getConfigs()).then(response => this.setConfigs(response.data.data));
        }

        setConfigs(data) {
            let configs = {};
            data.map(config => {
                configs[config.key] = {hex: config.value};
            });
            // this.$forceUpdate();
            console.warn('Theme Configs :: ', configs)
            this.config = configs;
        }

        getConfigs() {
            let configs = [];
            Object.keys(this.config).map((key, index) => {
                configs.push({
                    group: 'admin_theme',
                    key: key,
                    value: this.config[key].hex
                });
            });

            return {configs};
        }

    }
</script>
