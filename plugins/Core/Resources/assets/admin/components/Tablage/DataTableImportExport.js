import Component from 'vue-class-component';
import Vue from "vue";
import FileUpload from "../FileUpload";


@Component({
    props: ['name']
})
export default class DataTableImportExport extends Vue {
    import_data_dialog = false;
    form = {file: null};

    render(h) {
        return h('div', {class: 'mb-3'}, [
            h('v-spacer'),
            h('v-btn', {
                props: {color: 'green', dark: true},
                on: {click: () => this.exportData()}
            }, 'Export Data'),
            h('v-btn', {
                props: {color: 'blue', dark: true},
                on: {click: () => this.import_data_dialog = true}
            }, 'Import Data'),
            this.renderImportDataDialog(h)
        ])
    }

    /**
     * Render Import Data Dialog Box
     * @param {CreateElement} h
     * @returns {VNode}
     */
    renderImportDataDialog(h) {
        return h('v-dialog', {
            attrs: {
                value: this.import_data_dialog,
                maxWidth: '400',
            },
            on: {
                input: (input) => this.import_data_dialog = input
            }
        }, [
            h('v-card', {class: 'text-center'}, [
                h('v-card-text', {}, [
                    h('h2', {}, `Import New Data For ${this.name.toUpperCase()}`),
                    h(FileUpload, {
                        name: 'video',
                        attrs: {label: 'Please Select New CSV File'},
                        on: {input: files => this.form.file = files[0]}
                    }),
                    h('v-btn', {
                        props: {color: 'primary', loading: this.$store.state.fetching},
                        on: {click: () => this.importData()}
                    }, 'Import')
                ])
            ])
        ])
    }

    exportData() {
        let win = window.open(this.getExportUrl(this.name), '_blank');
        win.focus();
    }

    importData() {

        this.$http.post(`admin/${this.name}/import`, this.getFormData()).then(res => {
            this.import_data_dialog = false;
            this.$events.$emit('notify', {
                type: 'success',
                title: 'Success !',
                message: this.$t('notifications.data.updated_successfully')
            });
            this.$events.$emit('table.reload-data');
        })
    }

    /**
     * @param name
     * @returns {string}
     */
    getExportUrl(name) {
        return `api/data-export/${name}?token=${this.$store.state.user.id}`;
    }

    /**
     * @returns {FormData}
     */
    getFormData() {
        let form_data = new FormData();
        for (let key in this.form) {
            form_data.append(key, this.form[key]);
        }
        return form_data
    }
}