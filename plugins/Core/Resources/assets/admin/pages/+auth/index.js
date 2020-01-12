import Register from './Register';
import Login from './Login';
import ResetPassword from './ResetPassword';
import ResetPasswordSMS from './ResetPasswordSMS';
import EmailPassword from './EmailPassword';
import ConfirmPinPassword from './ConfirmPinPassword';


export default [
    {
        name: 'auth.register',
        path: '/register',
        component: Register,
        meta: {requiresAuth: false}
    },
    {
        name: 'auth.login',
        path: '/login',
        component: Login,
        meta: {requiresAuth: false}
    },
    {
        name: 'auth.password.forgot',
        path: '/password/forgot',
        component: ResetPassword,
        meta: {requiresAuth: false}
    },
    {
        name: 'auth.password.forgot_sms',
        path: '/password/forgot-sms',
        component: ResetPasswordSMS,
        meta: {requiresAuth: false}
    },
    {
        name: 'auth.password.reset',
        path: '/password/reset/:id',
        component: EmailPassword,
        meta: {requiresAuth: false}
    },
    {
        name: 'auth.password.reset_sms',
        path: '/password/reset-sms/:id',
        component: ConfirmPinPassword,
        meta: {requiresAuth: false}
    }
]
