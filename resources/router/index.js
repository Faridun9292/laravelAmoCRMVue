import {createRouter, createWebHistory} from "vue-router";

import LeadsTemplate from "../components/views/LeadsTemplate.vue";
import ContactsTemplate from "../components/views/ContactsTemplate.vue";
import History from "../components/views/HistoryTemplate.vue";
import notFound from "../components/notFound.vue";

const routes = [
    {
        path: '/',
        name: 'leads',
        component:   LeadsTemplate,
    },
    {
        path: '/contacts',
        name: 'contacts',
        component:   ContactsTemplate,
    },
    {
        path: '/history',
        name: 'history',
        component:   History,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'notFound',
        component: notFound,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router
