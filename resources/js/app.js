import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import menu from './components/Menusidebar.vue';
import router from './router';
import Pagination from './components/Pagination.vue'

import { createPinia } from 'pinia';
const pinia = createPinia();

const app = createApp(App)
app.component('menusidebar', menu);
app.component('Pagination', Pagination);
app.use(router);
app.use(pinia)

app.mount('#app-vue');
