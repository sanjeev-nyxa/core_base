<template>
    <v-card flat>
        <v-card-text>
            <form @submit.prevent="save()">
                <v-layout wrap row>
                    <v-flex sm5 class="pt-2">
                        <h3 class="pb-2">System Languages :</h3>

                        <v-select
                                :items="supported_languages"
                                name="locale_language"
                                :label="$t('table.locale_language')"
                                v-model="config['app.locale']"
                                outline
                                item-text="name"
                                item-value="key"
                        ></v-select>
                        <v-select
                                :items="supported_languages"
                                name="fallback_locale_language"
                                :label="$t('table.fallback_locale_language')"
                                v-model="config['app.fallback_locale']"
                                outline
                                item-text="name"
                                item-value="key"
                        ></v-select>

                        <v-select
                                :items="supported_languages"
                                name="supported_languages"
                                :label="$t('table.supported_languages')"
                                v-model="config['app.supported_languages']"
                                outline
                                multiple
                                chips
                                deletable-chips
                                item-text="name"
                                item-value="key"
                        ></v-select>


                    </v-flex>

                    <v-flex sm2></v-flex>
                    <v-flex sm5>
                        <v-btn color="primary" router :to="{name: 'settings.translations.index'}">Edit Translations
                        </v-btn>
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

    @Component({
        computed: mapState(['messages']),
    })
    export default class Trans extends Vue {
        config = {};

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
            this.$http.post('admin/configs?group=app', this.getConfigs()).then(response => this.setConfigs(response.data.data));
        }

        setConfigs(data) {
            let configs = {};
            data.map(config => {
                let cf = config.value.split(',');
                configs[config.key] = (cf.length > 1) ? cf : config.value;
            });
            this.config = configs;
        }

        getConfigs() {
            let configs = [];
            Object.keys(this.config).map((key, index) => {
                configs.push({
                    group: 'app',
                    key: key,
                    value: Array.isArray(this.config[key]) ? this.config[key].join(',') : this.config[key]
                });
            });

            return {configs};
        }

    }
</script>
