<template>
    <HeaderTemplate></HeaderTemplate>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive table-height mb-3">
                <table class="table table-rows">
                    <thead>
                    <tr>
                        <th class="text-muted">Дата и время</th>
                        <th class="text-muted">Действие</th>
                        <th class="text-muted indent">Результат</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(history, index) in logs.value" :key="index">
                        <td class="indent">{{ formatCreatedAt(history.created_at) }}</td>
                        <td class="indent">{{ history.type }}</td>
                        <td class="indent" >{{history.error ? 'Ошибка' : 'Успешно' }}</td>
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

const logs = reactive([]);

const fetchHistory= async () => {
    try {
        const response = await axios.get('/api/history');
        logs.value = response.data;
    } catch (error) {
        console.error('Error fetching leads:', error);
    }
};

const formatCreatedAt = (timestamp) => {
    return formatCreatedAtHelper(timestamp);
};

onMounted(() => {
    fetchHistory();
});


</script>
