<template>
    <form @submit.prevent="save()">
        <v-card class="mb-3">
            <v-card-text>
                <v-text-field
                        name="name"
                        :label="$t('table.title')"
                        v-model="blog.title"
                        :rules="messages.validation.title"
                        minlength="3"
                        maxlength="255"
                        required
                ></v-text-field>

                <v-select
                        :items="categories"
                        v-model="blog.category_id"
                        :label="$t('table.category')"
                        class="input-group--focused"
                        :item-text="`title`"
                        item-value="id"
                        chips
                        deletable-chips>
                </v-select>

                <v-text-field
                        name="description"
                        :label="$t('table.description')"
                        v-model="blog.description"
                        :rules="messages.validation.description"
                        minlength="3"
                        maxlength="255"
                        required
                ></v-text-field>

                <mavon-editor
                        :placeholder="$t('table.content')"
                        language="en"
                        v-model="blog.content"
                        required
                ></mavon-editor>

            </v-card-text>
        </v-card>

        <v-btn color="primary" :loading="$store.state.fetching" type="submit">
            <i v-if="$store.state.fetching" class="fa fa-spinner fa-pulse"></i>
            {{ edit ? $t('form.edit') : $t('form.create') }}
        </v-btn>
        <v-btn color="default" router :to="{name: 'blogs.index'}" type="reset">
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
    export default class BlogManager extends Vue {
        blog = {};
        categories = [];

        mounted() {
            /*
             * Set Page BreadCrumb
             */
            this.$store.dispatch('setBreadCrumbs', [
                'blogs.index',
                'blogs.' + (this.edit ? 'edit' : 'add')
            ]);

            this.$http.get('admin/categories').then(response => this.categories = response.data.data);

            if (this.edit) {
                this.$http.get('admin/blogs/' + this.$route.params.blog).then(response => this.blog = response.data.data);
            }

        }

        get edit() {
            return !!this.$route.params.blog;
        }

        save() {
            // if form for create
            return this.edit ? this.update() : this.create();
        }

        create() {
            this.$http.post(`admin/blogs`, this.blog)
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'info',
                        title: 'Success !',
                        message: this.$t('notifications.data.created_successfully')
                    });
                    this.$router.push({name: 'blogs.index'});
                });
        }

        update() {
            this.$http.put(`admin/blogs/${this.$route.params.blog}`, this.blog)
                .then(response => {
                    this.$events.$emit('notify', {
                        type: 'info',
                        title: 'Success !',
                        message: this.$t('notifications.data.updated_successfully')
                    });
                    this.$router.push({name: 'blogs.index'});
                });
        }


    }
</script>
