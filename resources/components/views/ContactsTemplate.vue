<template>
    <HeaderTemplate></HeaderTemplate>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Информация о контакте</h5>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="form-label">Имя контакта</label>

                            <input type="text" v-model="form.name" class="form-control"
                                   :class="{ 'is-invalid': errors.value && errors.value.name }"
                                   >
                            <div class="invalid-feedback" v-if="errors.value && errors.value.name">
                                {{ errors.value.name[0] }}
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="form-label">Телефон контакта</label>

                            <input type="text" v-model="form.phone" class="form-control"
                                   :class="{ 'is-invalid': errors.value && errors.value.phone }"
                                   >
                            <div class="invalid-feedback" v-if="errors.value && errors.value.phone">
                                {{ errors.value.phone[0] }}
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="form-label">Комментарии</label>
                            <input type="text" v-model="form.text" class="form-control"
                                   :class="{ 'is-invalid': errors.value && errors.value.comments }"
                                   >
                            <div class="invalid-feedback" v-if="errors.value && errors.value.comments">
                                {{ errors.value.comments[0] }}
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md">
            </div>
            <div class="col-auto">
                <div class="text-md-end">
                    <button class="btn btn-success" @click.prevent="addContact"
                    >Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import {reactive, onMounted} from "vue";
import {useRouter} from "vue-router";

const errors = reactive({});
const form = reactive({
    name: '',
    phone: '',
    text: '',
    leadID: '',
})

const router = useRouter();

const addContact = async () => {

    try {
        const response = await axios.post('/api/contacts', form);
        if (response.data.message === 'success'){
            await router.push('/');
            await toast.fire({
                icon: 'success',
                title: 'Успешно добавлено'
            })
        }
    } catch (e) {
        if (e.response.status === 422){
            errors.value = e.response.data.errors;
        }
    }
}

onMounted(() => {
    if (router.currentRoute.value.query.lead === undefined){
        router.push('/');
        toast.fire({
            icon: 'error',
            title: 'Выберите сделку'
        })
    }
    form.leadID = router.currentRoute.value.query.lead
})
</script>
