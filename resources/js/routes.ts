// ** Local Imports
import dashboard from './Pages/Dashboard.vue';

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
];
