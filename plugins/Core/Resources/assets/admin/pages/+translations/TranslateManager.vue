<template>
    <form @submit.prevent="save()">
        <v-card class="mb-3">
            <v-card-text>
                <v-text-field
                        name="group"
                        :label="$t('table.group')"
                        v-model="translate.group"
                        :rules="messages.validation.group"
                        required
                ></v-text-field>
                <v-text-field
                        name="key"
                        :label="$t('table.key')"
                        v-model="translate.key"
                        :rules="messages.validation.key"
                        required
                ></v-text-field>
                <v-text-field
                        v-for="lang of $store.state.lang.supported_languages"
                        :key="lang"
                        name="text"
                        :label="`${$t('table.text')} (${lang})`"
                        v-model="translate.text[lang]"
                        :rules="messages.validation.text"
                ></v-text-field>


            </v-card-text>
        </v-card>

        <v-btn color="primary" :loading="$store.state.fetching" type="submit">
            <i v-if="$store.state.fetching" class="fa fa-spinner fa-pulse"></i>
            {{ edit ? $t('form.edit') : $t('form.create') }}
        </v-btn>
        <v-btn color="default" router :to="{name: 'settings.translations.index'}" type="reset">
            {{ $t('form.cancel') }}
        </v-btn>
    </form>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import {mapState} from 'vuex';

    @Component({
        computed: mapState(['messages'])
    })
    export default class TranslateManager extends Vue {
        translate = {text:{}};

        mounted() {
            /*
             * Set Page BreadCrumb
             */
            this.$store.dispatch('setBreadCrumbs', [
                'settings.index',
                'settings.translations.index',
                'settings.translations.' + (this.edit ? 'edit' : 'add')
            ]);
            if (this.edit) {
                this.$http.get('admin/translations/' + this.$route.params.translate).then(response => this.translate = response.data.data);
            }

        }

        get edit() {
            return !!this.$route.params.translate;
        }

        save() {
            // if form for create
            return this.edit ? this.update() : this.create();
        }

        create() {
            this.$http.post(`admin/translations`, this.translate)
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'info',
                        title: 'Success !',
                        message: this.$t('notifications.data.created_successfully')
                    });
                    this.$router.push({name: 'settings.translations.index'});
                });
        }

        update() {
            this.$http.put(`admin/translations/${this.$route.params.translate}`, this.translate)
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'info',
                        title: 'Success !',
                        message: this.$t('notifications.data.updated_successfully')
                    });
                    this.$router.push({name: 'settings.translations.index'});
                });
        }


    }
</script>
