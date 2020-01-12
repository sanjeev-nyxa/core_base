import Upload from './upload'
// https://github.com/websanova/vue-upload
// https://vuejs.org/v2/guide/plugins.html
export default function install(Vue, options) {
    // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperty
    let upload = new Upload(Vue, options),
        _new = upload.new,
        _reset = upload.reset;
    Object.defineProperty(Vue.prototype, '$upload', {
        get() {
            upload.new = _new.bind(this);
            upload.reset = _reset.bind(this);

            return upload;
        }
    })
}
