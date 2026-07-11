// ** Local Imports
import dashboard from './Pages/Dashboard.vue';
import setting from './Pages/Setting.vue';

export default [
    {
        path: '/',
        redirect: '/dashboard',
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: dashboard,
    },
    {
        name: 'settings',
        path: '/settings',
        component: setting,
    },
];
