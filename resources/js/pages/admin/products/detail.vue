<template>
    <form @submit.prevent="handleUpdate()">
        <a-card title="Tạo mới tài khoản" style="width: 100%">
            <HeaderForm :module="module"/>
            <div class="row">
                <div class="mb-3 mt-3 col-md-6">
                    <Input label="Tên" :error_mes="errors?.name" v-model="name"/>
                </div>
                <div class="mb-3 mt-3 col-md-6">
                    <Input label="Mã" :error_mes="errors?.code" v-model="code"/>
                </div>
                <div class="mb-3 mt-3 col-md-6">
                    <Select label="Tình trạng" v-model="status" :error_mes="errors?.status"/>
                </div>

            </div>
        </a-card>
    </form>
</template>

<script setup>
import {ref, reactive, toRefs} from "vue";
import {useMenu} from "@/store/use-menu.js";
import {useRouter, useRoute} from "vue-router";
import {message} from "ant-design-vue";
import Input from "../../../components/form/Input.vue";
import HeaderForm from "../../../components/form/HeaderForm.vue";
import Select from "../../../components/form/Select.vue";
import {getEndpoint} from "../../../configs/index.js";

const module = 'products';
useMenu().onSelectedKeys([`admin-${module}`]);
const router = useRouter()
const route = useRoute()

const endpointDetail = getEndpoint(module, 'edit', route.params.id);
const endpointUpdate = getEndpoint(module, null, route.params.id);

const state = reactive({
    name: "",
    code: "",
    status: 1,
})

const errors = ref({})

const getDetail = async () => {
    try {
        const res = await axios.get(endpointDetail);
        if (res.data.result) {
            Object.keys(obj).forEach(field => {
                obj[field] = res.data.result[field]
            })

            console.log(res);
        }
    } catch (err) {
        console.log(err)
    }
}

const handleUpdate = async () => {
    try {
        if (route.params.id) {
            const res = await axios.put(endpointUpdate, obj);
        } else {
            const res = await axios.post(endpointUpdate, obj);
        }
        await router.push({name: `admin-${module}`})
        message.success('Thành công')
    } catch (err) {
        console.log(err)
        errors.value = err.response.data.errors;
    }
}

getDetail();
const {name, code, value, status} = {...toRefs(obj)};

</script>
