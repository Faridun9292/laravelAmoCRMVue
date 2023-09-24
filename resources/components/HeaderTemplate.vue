<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item" :class="{'active': routerName === 'leads'}">
                    <router-link to="/" class="nav-link">Сделки</router-link>
                </li>
                <li class="nav-item" :class="{'active': routerName === 'contacts'}">
                    <router-link to="/contacts" class="nav-link">Контакты</router-link>
                </li>
                <li class="nav-item" :class="{'active': routerName === 'history'}">
                    <router-link to="/history" class="nav-link">История</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const routerName = ref(null);

onMounted(() => {
    routerName.value = router.currentRoute.value.name;
});
</script>
