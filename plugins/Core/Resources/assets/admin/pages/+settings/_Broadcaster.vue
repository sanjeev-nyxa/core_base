<template>
    <v-card flat>
        <v-card-text>
            <form @submit.prevent="save()">
                <v-layout wrap row>
                    <v-flex sm5 class="pt-2">
                        <h3 class="pb-2">Broadcasting Provider :</h3>
                        <v-switch
                                name="enabled"
                                :label="$t('table.enabled')"
                                v-model="config['broadcasting.enabled']"
                        ></v-switch>



                       <div v-if="config['broadcasting.enabled']">
                           <v-select
                                   :items="['pusher', 'redis', 'log']"
                                   name="default"
                                   :label="$t('table.default')"
                                   v-model="config['broadcasting.default']"
                                   outline
                           ></v-select>

                           <div v-if="config['broadcasting.default'] === 'pusher'">
                               <v-text-field
                                       name="driver"
                                       :label="$t('table.driver')"
                                       v-model="config['broadcasting.connections.pusher.driver']"
                                       outline
                               ></v-text-field>
                               <v-text-field
                                       name="key"
                                       :label="$t('table.key')"
                                       v-model="config['broadcasting.connections.pusher.key']"
                                       outline
                               ></v-text-field>
                               <v-text-field
                                       name="secret"
                                       :label="$t('table.secret')"
                                       v-model="config['broadcasting.connections.pusher.secret']"
                                       outline
                               ></v-text-field>
                               <v-text-field
                                       name="app_id"
                                       :label="$t('table.app_id')"
                                       v-model="config['broadcasting.connections.pusher.app_id']"
                                       outline
                               ></v-text-field>
                           </div>

                           <div v-if="config['broadcasting.default'] === 'redis'">
                               <v-text-field
                                       name="driver"
                                       :label="$t('table.driver')"
                                       v-model="config['broadcasting.connections.redis.driver']"
                                       outline
                               ></v-text-field>
                               <v-text-field
                                       name="connection"
                                       :label="$t('table.connection')"
                                       v-model="config['broadcasting.connections.redis.connection']"
                                       outline
                               ></v-text-field>
                           </div>
                           <div v-if="config['broadcasting.default'] === 'log'">
                               <v-text-field
                                       name="driver"
                                       :label="$t('table.driver')"
                                       v-model="config['broadcasting.connections.log.driver']"
                                       outline
                               ></v-text-field>
                           </div>

                       </div>

                    </v-flex>

                    <v-flex sm2></v-flex>
                    <v-flex sm5>

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
    export default class Broadcaster extends Vue {
        config = {};

        mounted() {
            this.$http.get('admin/configs?group=broadcasting').then(response => this.setConfigs(response.data.data));
        }

        save() {
            this.$http.post('admin/configs?group=broadcasting', this.getConfigs()).then(response => this.setConfigs(response.data.data));
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
                    group: 'broadcasting',
                    key: key,
                    value: this.config[key]
                });
            });

            return {configs};
        }

    }
</script>
