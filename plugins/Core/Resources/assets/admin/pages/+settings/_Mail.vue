<template>
    <v-card flat>
        <v-card-text>
            <form @submit.prevent="save()">
                <v-layout wrap row>
                    <v-flex sm5 class="pt-2">
                        <h3 class="pb-2">Mail Provider :</h3>
                        <v-text-field
                                name="MAIL_DRIVER"
                                :label="$t('table.MAIL_DRIVER')"
                                v-model="config['mail.driver']"
                                outline
                                hint="smtp"
                        ></v-text-field>

                        <v-text-field
                                name="MAIL_HOST"
                                :label="$t('table.MAIL_HOST')"
                                v-model="config['mail.host']"
                                outline
                                hint="smtp.mailgun.org"
                        ></v-text-field>

                        <v-text-field
                                name="MAIL_PORT"
                                :label="$t('table.MAIL_PORT')"
                                v-model="config['mail.port']"
                                outline
                                hint="587"
                        ></v-text-field>

                        <v-text-field
                                name="MAIL_USERNAME"
                                :label="$t('table.MAIL_USERNAME')"
                                v-model="config['mail.username']"
                                outline
                                hint="dev@webnyxa.com"
                        ></v-text-field>

                        <v-text-field
                                type="password"
                                name="MAIL_PASSWORD"
                                :label="$t('table.MAIL_PASSWORD')"
                                v-model="config['mail.password']"
                                outline
                        ></v-text-field>

                        <v-text-field
                                name="MAIL_ENCRYPTION"
                                :label="$t('table.MAIL_ENCRYPTION')"
                                v-model="config['mail.encryption']"
                                outline
                                hint="tls"
                        ></v-text-field>


                    </v-flex>

                    <v-flex sm2></v-flex>
                    <v-flex sm5>
                        <h3 class="pb-2">Mail Sender :</h3>
                        <v-text-field
                                name="from_address"
                                :label="$t('table.from_address')"
                                v-model="config['mail.from.address']"
                                outline
                        ></v-text-field>
                        <v-text-field
                                name="from_name"
                                :label="$t('table.from_name')"
                                v-model="config['mail.from.name']"
                                outline
                        ></v-text-field>
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
    export default class Mail extends Vue {
        config = {};

        mounted() {
            this.$http.get('admin/configs?group=mail').then(response => this.setConfigs(response.data.data));
        }

        save() {
            this.$http.post('admin/configs?group=mail', this.getConfigs()).then(response => this.setConfigs(response.data.data));
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
                    group: 'mail',
                    key: key,
                    value: this.config[key]
                });
            });

            return {configs};
        }
    }
</script>
