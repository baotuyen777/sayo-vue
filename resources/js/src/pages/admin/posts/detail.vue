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
                <div class="col-md-6">
                    <Upload v-model="avatar" :show-upload-list="true"/>
                </div>
                <div class="col-md-6">
                    <Upload v-model="gallery" :show-upload-list="true"/>
                </div>

            </div>
        </a-card>
    </form>
</template>

<script setup>
import {ref, reactive, toRefs} from "vue";
import {useMenu} from "../../../store/use-menu.js";
import {useRouter, useRoute} from "vue-router";
import {getEndpoint} from "../../../configs";
import {message} from "ant-design-vue";
import HeaderForm from "../../../components/form/HeaderForm.vue";
import Input from "../../../components/form/Input.vue";
import Select from "../../../components/form/Select.vue";
import Upload from "../../../components/form/Upload.vue";

const module = 'posts';
useMenu().onSelectedKeys([`admin-${module}`]);
const router = useRouter()
const route = useRoute()

const endpointDetail = getEndpoint(module, 'edit', route.params.id);
const endpointUpdate = getEndpoint(module, null, route.params.id);

const state = reactive({
    name: "",
    code: "",
    status: 1,
    previewImage: '',
    previewVisible: false,
    previewTitle: '',
    gallery: [],
    media_ids: [],
    avatar: [],
    avatar_id: [],
})

const errors = ref({})

const getDetail = async () => {
    try {
        const res = await axios.get(endpointDetail);
        const result = res.data.result
        if (result) {
            Object.keys(state).forEach(field => {
                state[field] = res.data.result[field]
            })

            state.avatar = result.avatar ? [result.avatar] : []
            state.gallery = result.gallery
            console.log(state,444)
        } else {
            console.log(res)
        }
    } catch (err) {
        console.log(err)
    }
}

const handleUpdate = async () => {
    try {
        const formData = {...state}
        if (state.gallery) {
            formData.media_ids = state.gallery.map((file) => {
                return file?.response?.result?.id || file?.id
            })

            delete formData.gallery;
        }

        if (state.avatar) {
            const avatar = state.avatar[state.avatar.length - 1]
            formData.avatar_id = avatar?.response?.result?.id || avatar?.id

            delete formData.avatar;
        }
        if (route.params.id) {
            await axios.put(endpointUpdate, formData);
        } else {
            await axios.post(endpointUpdate, formData);
        }
        // await router.push({name: `admin-${module}`})
        message.success('Thành công')
    } catch (err) {
        console.log(err)
        errors.value = err.response.data.errors;
    }
}

getDetail();

const {name, code, value, status, gallery, avatar} = {...toRefs(state)};

</script>
