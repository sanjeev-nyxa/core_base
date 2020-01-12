const APP_CONFIGS = {

    timezone: 'America/Toronto',
    echo: {
        enabled: false,
        broadcaster: 'socket.io',
        host: window.location.hostname + ':8080',
    },
    admin: {
        app_name: 'webnyxa',
        base_api_url: '/api/',
        theme: {
            primary: '#8FD337',
            secondary: '#8FD337',
            accent: '#82B1FF',
            error: '#FF5252',
            info: '#2196F3',
            success: '#4CAF50',
            warning: '#FFC107'
        },
        lang: {
            supported_languages: ['en', 'fr', 'ar'],
            default_lang: 'en',
            fallback_lang: 'en'
        },

    },

};


window.Zexus = {
    routes: [],
    configs: APP_CONFIGS
};