import Component from 'vue-class-component';
import DataTable from '@labs-core/admin/components/Tablage/table';
import Vue from "vue";

@Component
export default class Categories extends Vue {

    render(h) {
        return h('div', {}, [
            h(DataTable, {
                props: {
                    apiRoute: 'admin/categories',
                    route: 'categories',
                    actions: [
                        {
                            text: 'categories.edit',
                            color: 'primary',
                            fab: true,
                            icon: 'edit',
                            callback: (item) => this.$router.push({name: 'categories.edit', params: {category: item.id}})
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
                            text: this.$t('table.total_blogs'),
                            value: 'title',
                            callback: category => category.blogs.length,
                            align: 'left',
                            searchable: false,
                            sortable: false,
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
            'categories.index'
        ]);
    }
}