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
