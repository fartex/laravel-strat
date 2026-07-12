// ** External Imports
import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from 'vue-router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// ** Local Imports
import App from './Layout/System.vue';
import routes from './routes';
import i18n from '@shared/App/i18n';
import '@shared/App/types/fontawesome';
import '../css/app.css';

const router = createRouter({
    routes,
    history: createWebHashHistory(),
});

createApp(App).use(router).use(i18n).component('font-awesome-icon', FontAwesomeIcon).mount('#app');
