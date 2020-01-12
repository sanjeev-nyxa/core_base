import Component from 'vue-class-component';
import DataTable from '@labs-core/admin/components/Tablage/table';
import Vue from "vue";

@Component
export default class Blogs extends Vue {

    render(h) {
        return h('div', {}, [
            h(DataTable, {
                props: {
                    apiRoute: 'admin/blogs',
                    route: 'blogs',
                    actions: [
                        {
                            text: 'blogs.edit',
                            color: 'primary',
                            fab: true,
                            icon: 'edit',
                            callback: (item) => this.$router.push({name: 'blogs.edit', params: {blog: item.id}})
                        },

                        {
                            text: 'table.delete',
                            color: 'red',
                            dark: true,
                            fab: true,
                            icon: 'delete',
                            callback: (item) => this.$events.$emit('table.delete-data', item.id)
                        }
                    ],
                    headers: [
                        {
                            text: this.$t('table.title'),
                            value: 'title',
                            align: 'left',
                            searchable: true,
                            sortable: true,
                        },
                        {
                            text: this.$t('table.category'),
                            value: 'category.title',
                            align: 'left',
                            searchable: true,
                            sortable: true,
                        },
                        {
                            text: this.$t('table.actions'),
                            value: 'actions',
                            align: 'right',
                        }

                    ]
                }
            })
        ])
    }

    mounted() {
        this.$store.dispatch('setBreadCrumbs', [
            'blogs.index'
        ]);
    }
}