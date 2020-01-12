<template>
    <form @submit.prevent="save()">
        <v-card class="mb-3">
            <v-card-text>
                <v-text-field
                        name="name"
                        :label="$t('table.title')"
                        v-model="category.title"
                        :rules="messages.validation.title"
                        minlength="3"
                        maxlength="255"
                        required
                ></v-text-field>

                <v-text-field
                        name="description"
                        :label="$t('table.description')"
                        v-model="category.description"
                        :rules="messages.validation.description"
                        minlength="3"
                        maxlength="255"
                        required
                ></v-text-field>



            </v-card-text>
        </v-card>

        <v-btn color="primary" :loading="$store.state.fetching" type="submit">
            <i v-if="$store.state.fetching" class="fa fa-spinner fa-pulse"></i>
            {{ edit ? $t('form.edit') : $t('form.create') }}
        </v-btn>
        <v-btn color="default" router :to="{name: 'categories.index'}" type="reset">
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
    export default class CategoryManager extends Vue {
        category = {};

        mounted() {
            /*
             * Set Page BreadCrumb
             */
            this.$store.dispatch('setBreadCrumbs', [
                'categories.index',
                'categories.' + (this.edit ? 'edit' : 'add')
            ]);
            if (this.edit) {
                this.$http.get('admin/categories/' + this.$route.params.category).then(response => this.category = response.data.data);
            }

        }

        get edit() {
            return !!this.$route.params.category;
        }

        save() {
            // if form for create
            return this.edit ? this.update() : this.create();
        }

        create() {
            this.$http.post(`admin/categories`, this.category)
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'info',
                        title: 'Success !',
                        message: this.$t('notifications.data.created_successfully')
                    });
                    this.$router.push({name: 'categories.index'});
                });
        }

        update() {
            this.$http.put(`admin/categories/${this.$route.params.category}`, this.category)
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'info',
                        title: 'Success !',
                        message: this.$t('notifications.data.updated_successfully')
                    });
                    this.$router.push({name: 'categories.index'});
                });
        }


    }
</script>
