import Component from 'vue-class-component';
import Vue from "vue";

@Component({
    props: {
        value: {
            type: [Array, String]
        },
        accept: {
            type: String,
            default: "*"
        },
        label: {
            type: String,
            default: "Please choose..."
        },
        icon: {
            type: String,
            default: 'attach_file'
        },
        required: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },
        multiple: {
            type: Boolean, // not yet possible because of data
            default: false
        }
    }
})
export default class FileUpload extends Vue {
    filename = null;


    render(h) {
        return (
            <div>
                <v-text-field prepend-icon={this.icon} single-line
                              value={this.filename} onInput={(filename) => this.filename = filename}
                              label={this.label}
                              required={this.required}
                              disabled={this.disabled}
                              onFocus={(e) => this.onFocus(e)}
                              outline
                              ref={'fileTextField'}></v-text-field>
                <input type="file"
                       style={{'display': 'none'}}
                       accept={this.accept}
                       multiple={this.multiple}
                       disabled={this.disabled}
                       ref={'fileInput'}
                       onChange={(e) => this.onFileChange(e)}/>
            </div>
        );

    }


    mounted() {
        this.filename = this.value;
        this.$watch('value', v => this.filename = v);
    }

    getFormData(files) {
        const data = new FormData();
        [...files].forEach(file => {
            data.append('data', file, file.name); // currently only one file at a time
        });
        return data;
    }

    onFocus($event) {
        if (!this.disabled) {
            this.$refs.fileInput.click();
        }
    }

    onFileChange($event) {
        const files = $event.target.files || $event.dataTransfer.files;
        if (files) {
            if (files.length > 0) {
                this.filename = [...files].map(file => file.name).join(', ');
            } else {
                this.filename = null;
            }
        } else {
            this.filename = $event.target.value.split('\\').pop();
        }
        this.$emit('input', $event.target.files);
    }
}
