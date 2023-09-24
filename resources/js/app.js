import './bootstrap';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import {createApp} from "vue";

import app from "../components/app.vue";
import HeaderTemplate from "../components/HeaderTemplate.vue";

import router from "../router";

import Swal from 'sweetalert2/dist/sweetalert2.js'

import 'sweetalert2/src/sweetalert2.scss'
window.Swal = Swal;

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
})

window.toast = toast

createApp(app)
    .use(router)
    .component('HeaderTemplate', HeaderTemplate)
    .mount('#app');
