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
                    <Input label="Giá trị" :error_mes="errors?.value" v-model="value"/>
                </div>
                <div class="mb-3 mt-3 col-md-6">
                    <Select label="Tình trạng" :options="options" v-model="status" :error_mes="errors?.status"/>
                </div>

            </div>
        </a-card>
    </form>
</template>

<script>
import {defineComponent, ref, reactive, toRefs} from "vue";
import {useMenu} from "@/src/store/use-menu.js";
import {useRouter, useRoute} from "vue-router";
import {message} from "ant-design-vue";
import Input from "../../../components/form/Input.vue";
import HeaderForm from "../../../components/form/HeaderForm.vue";
import Select from "../../../components/form/Select.vue";

export default defineComponent({
    components: {Select, HeaderForm, Input},
    setup() {
        useMenu().onSelectedKeys(['admin-settings']);
        const router = useRouter()
        const route = useRoute()
        const module = 'settings';

        const obj = reactive({
            name: "",
            code: "",
            value: "",
            status: 1,
        })

        const errors = ref({})


        const getDetail = async () => {
            const endpoint = route.params.id ? `http://localhost:8000/api/${module}/${route.params.id}/edit` : `http://localhost:8000/api/users/create`

            try {
                const res = await axios.get(endpoint);
                if (res.data.result) {
                    Object.keys(obj).forEach(field => {
                        obj[field] = res.data.result[field]
                    })
                }
            } catch (err) {
                console.log(err)
            }
        }

        const filterOption = (input, option) => {
            return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
        }

        const handleUpdate = async () => {
            try {
                if (route.params.id) {
                    const res = await axios.put(`http://localhost:8000/api/${module}/${route.params.id}`, obj);
                } else {
                    const res = await axios.post(`http://localhost:8000/api/${module}`, obj);

                }
                // console.log(res,888)
                await router.push({name: `admin-${module}`})
                message.success('Thành công')
            } catch (err) {
                console.log(err)
                errors.value = err.response.data.errors;
            }
        }

        getDetail();
        const options = [
            {value: 1, label: "Hoạt động"},
            {value: 2, label: "Tạm dừng"},
        ];

        return {
            options,
            ...toRefs(obj),
            errors,
            filterOption,
            handleUpdate,
            module
        }
    }
})
</script>
