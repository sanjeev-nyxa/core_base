// https://vuex.vuejs.org/en/state.html
export default {
    token: null,
    user: {},
    permissions: [],
    messages: {
        success: '',
        error: [],
        warning: '',
        validation: {}
    },
    fetching: false,
    sidebar: {
        show: true,
        clipped: true,
        mini_variant: false
    },
    app_name: Zexus.configs.admin.app_name,

    configs: {},

    lang: Zexus.configs.admin.lang,

    breadcrumbs: ['dashboard.index']
};
