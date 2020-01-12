import Component from 'vue-class-component';
import DataTable from '@labs-core/admin/components/Tablage/table';
import DataTableImportExport from '@labs-core/admin/components/Tablage/DataTableImportExport';
import Vue from "vue";

@Component
export default class Translations extends Vue {

    render(h) {
        return h('div', {}, [
            h(DataTableImportExport, {
                props: {
                    name: 'translations'
                }
            }),
            h(DataTable, {
                props: {
                    apiRoute: 'admin/translations',
                    route: 'settings.translations',
                    actions: [
                        {
                            text: 'settings.translations.edit',
                            color: 'primary',
                            fab: true,
                            icon: 'edit',
                            callback: (item) => this.$router.push({
                                name: 'settings.translations.edit',
                                params: {translate: item.id}
                            })
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
                            text: this.$t('table.group'),
                            value: 'group',
                            align: 'right',
                            searchable: true,
                            sortable: true,
                        },
                        {
                            text: this.$t('table.key'),
                            value: 'key',
                            align: 'right',
                            searchable: true,
                            sortable: true,
                        },
                        {
                            text: this.$t('table.text'),
                            value: `text->${this.$store.state.lang.default_lang}`,
                            align: 'right',
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
            'settings.index',
            'settings.translations.index'
        ]);
    }
}