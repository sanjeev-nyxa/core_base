import Vue from 'vue';
import VueI18n from 'vue-i18n';
import {http} from './../plugins/http'

Vue.use(VueI18n);

const messages = {
    en: {}
};

const LOCAL_LANG = 'en';

const i18n = new VueI18n({
    locale: LOCAL_LANG, // set locale
    silentTranslationWarn: true,
    messages // set locale messages
});

function setI18nLanguage(lang) {
    i18n.locale = lang;
    http.defaults.headers.common['Accept-Language'] = lang;
    document.querySelector('html').setAttribute('lang', lang);
    return lang
}
setI18nLanguage(LOCAL_LANG);
http.get('translations?group=admin').then(res => {
    i18n.setLocaleMessage(LOCAL_LANG, res.data)
});

export default i18n;
