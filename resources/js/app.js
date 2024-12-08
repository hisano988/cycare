import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';
import Calender from "./components/Calender.vue";

const app = createApp({
    components: {"Calender": Calender}
});
app.mount('#app');
