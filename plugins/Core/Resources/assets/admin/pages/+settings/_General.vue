<template>
    <v-card flat>
        <v-card-text>
            <form @submit.prevent="save()">
                <v-layout wrap row>
                    <v-flex sm5 class="pt-2">
                        <v-switch
                                name="debug"
                                :label="$t('table.debug')"
                                v-model="config['app.debug']"
                                value="1"
                        ></v-switch>
                        <v-text-field
                                name="app_name"
                                :label="$t('table.app_name')"
                                v-model="config['app.name']"
                                outline
                        ></v-text-field>

                        <v-text-field
                                name="api_url"
                                :label="$t('table.api_url')"
                                v-model="config['app.api_url']"
                                outline
                        ></v-text-field>
                        <v-text-field
                                name="site_url"
                                :label="$t('table.site_url')"
                                v-model="config['app.url']"
                                outline
                        ></v-text-field>

                        <v-text-field
                                name="timezone"
                                :label="$t('table.timezone')"
                                v-model="config['app.timezone']"
                                outline
                        ></v-text-field>
                    </v-flex>
                    <v-flex sm7>
                        <v-layout row wrap>
                            <v-flex sm5 class="text-sm-center">
                                <v-avatar
                                          size="100"
                                          color="grey lighten-4"
                                >
                                    <img :src="images.site_logo ? images.site_logo : '/images/logo.png'" alt="Site Logo">
                                </v-avatar>
                            </v-flex>
                            <v-flex sm7 class="pt-3">
                                <file-upload @input="setSiteLogo" :label="$t('table.logo')"
                                             icon="image"></file-upload>
                            </v-flex>
                        </v-layout>

                        <v-layout row wrap class="pt-2">
                            <v-flex sm5 class="text-sm-center">
                                <v-avatar
                                          size="100"
                                          color="grey lighten-4"
                                >
                                    <img :src="images.site_fav_icon ? images.site_fav_icon : '/favicon.ico'" alt="Site Logo">
                                </v-avatar>
                            </v-flex>
                            <v-flex sm7 class="pt-3">
                                <file-upload @input="setSiteFavIcon" :label="$t('table.fav_icon')"
                                             icon="photo_size_select_large"></file-upload>
                            </v-flex>
                        </v-layout>

                        <v-layout row wrap class="pt-2">
                            <v-flex sm5 class="text-sm-center">
                                <v-avatar
                                          size="100"
                                          color="grey lighten-4"
                                >
                                    <img :src="images.site_login_bg ? images.site_login_bg : '/images/login-bg.png'" alt="Site Logo">
                                </v-avatar>
                            </v-flex>
                            <v-flex sm7 class="pt-3">
                                <file-upload @input="setSiteLoginBg" :label="$t('table.login_bg')"
                                             icon="photo_size_select_large"></file-upload>
                            </v-flex>
                        </v-layout>
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
    import FileUpload from '@labs-core/admin/libraries/FileUpload';

    @Component({
        computed: mapState(['messages']),
        components: {
            FileUpload
        }
    })
    export default class General extends Vue {
        config = {};
        images = {
            site_logo: null,
            site_fav_icon: null,
            site_login_bg: null,
        };

        supported_languages = [
            {
                name: 'Arabic',
                key: 'ar'
            },
            {
                name: 'English',
                key: 'en'
            },
            {
                name: 'French',
                key: 'fr'
            },
            {
                name: 'Italian',
                key: 'it'
            },
        ];

        mounted() {
            this.$http.get('admin/configs?group=app').then(response => this.setConfigs(response.data.data));
        }

        save() {
            this.$http.post('admin/configs?group=app', this.getConfigs())
                .then(response => this.setConfigs(response.data.data))
                .then(response => this.$store.dispatch('getConfigs', this));
            this.$http.post('admin/configs/images', this.images)
        }

        setConfigs(data) {
            let configs = {};
            data.map(config => {
                configs[config.key] = config.value;
            });
            this.config = configs;
        }

        getConfigs() {
            let configs = [];
            Object.keys(this.config).map((key, index) => {
                configs.push({
                    group: 'app',
                    key: key,
                    value: this.config[key]
                });
            });

            return {configs};
        }

        setSiteLogo(files) {
            let file = files[0];
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.images.site_logo = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        setSiteFavIcon(files) {
            let file = files[0];
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.images.site_fav_icon = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        setSiteLoginBg(files) {
            let file = files[0];
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.images.site_login_bg = e.target.result;
            };
            reader.readAsDataURL(file);
        }

    }
</script>
