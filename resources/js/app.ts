// ** External Imports
import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from 'vue-router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// ** Local Imports
import App from './Layout/System.vue';
import routes from './routes';
import './fontawesome';
import '../css/app.css';

const router = createRouter({
    routes,
    history: createWebHashHistory(),
});

createApp(App).use(router).component('font-awesome-icon', FontAwesomeIcon).mount('#app');
