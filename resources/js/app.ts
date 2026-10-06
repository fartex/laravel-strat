// ** External Imports
import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from 'vue-router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import axios from 'axios';

// ** Local Imports
import App from './Layout/System.vue';
import routes from './routes';
import i18n from '@shared/App/i18n';
import head from '@shared/App/head';
import '@shared/App/types/fontawesome';
import '../css/app.css';

axios.defaults.baseURL =
    document.querySelector('meta[name="strat-base-path"]')?.getAttribute('content') ?? '';

// Send the session's CSRF token so state-changing (POST) routes pass VerifyCsrfToken.
// Only for the app's own (relative) routes: third-party APIs such as GitHub reject the
// header on CORS preflight, and the token must not leak outside the app anyway.
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

axios.interceptors.request.use((config) => {
    if (!/^https?:\/\//i.test(config.url ?? '')) {
        config.headers['X-CSRF-TOKEN'] = csrfToken;
    }

    return config;
});

const router = createRouter({
    routes,
    history: createWebHashHistory(),
});

createApp(App)
    .use(router)
    .use(i18n)
    .use(head)
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount('#app');
