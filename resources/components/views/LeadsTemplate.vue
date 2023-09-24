<template>
    <HeaderTemplate></HeaderTemplate>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive table-height mb-3">
                <table class="table table-rows">
                    <thead>
                    <tr>
                        <th class="text-muted">ID</th>
                        <th class="text-muted">Название сделки</th>
                        <th class="text-muted indent">Контракт</th>
                        <th class="text-muted indent">Дата создания</th>
                        <th class="text-muted indent">Контакт</th>
                        <th class="text-muted indent">Действие</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(lead, index) in sortedLeads.value" :key="index">
                        <td class="indent">{{ lead.id }}</td>
                        <td class="indent">{{ lead.name }}</td>
                        <td class="indent">{{ lead.price }} P</td>
                        <td class="indent">{{ formatCreatedAt(lead.created_at) }}</td>
                        <td class="indent" >{{lead.contacts ? 'Да' : 'Нет' }}</td>
                        <td class="indent" >
                            <router-link
                                :to="'/contacts?lead='+lead.id"
                                class="btn btn-success"
                                :class="{ 'disabled-link': lead.contacts }">
                                Привязать контакт
                            </router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, reactive } from "vue";
import {formatCreatedAtHelper} from "../../helpers/helpers";
import _ from "lodash";

const leads = reactive([]);
const sortedLeads = reactive([]);

const fetchLeads = async () => {
    try {
        const response = await axios.get('/api/leads');
        leads.value = response.data;
        sortLeadsByCreatedAt();
    } catch (error) {
        console.error('Error fetching leads:', error);
    }
};

const sortLeadsByCreatedAt = () => {
    sortedLeads.value = _.orderBy(leads.value, ['created_at'], ['desc']);
};

const formatCreatedAt = (timestamp) => {
    return formatCreatedAtHelper(timestamp);
};

onMounted(() => {
    fetchLeads();
});
</script>

<style>
.disabled-link {
    pointer-events: none;
    opacity: 0.6;
    cursor: not-allowed;
    text-decoration: none;
}
</style>
