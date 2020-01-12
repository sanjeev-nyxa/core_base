import Translations from './Translations'
import TranslateManager from './TranslateManager'

export default [
    {
        name: 'settings.translations.index',
        path: '/settings/translations',
        component: Translations,
        meta: {requiresAuth: true, permission: 'view_translations'},

    },
    {
        name: 'settings.translations.create',
        path: '/settings/translations/create',
        component: TranslateManager,
        meta: {requiresAuth: true, permission: 'create_translations'},
    },
    {
        name: 'settings.translations.edit',
        path: '/settings/translations/:translate/edit',
        component: TranslateManager,
        meta: {requiresAuth: true, permission: 'update_translations'},
    },
]
