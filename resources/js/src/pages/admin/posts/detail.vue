<template>
    <form @submit.prevent="handleUpdate()">
        <a-card title="Tạo mới tài khoản" style="width: 100%">
            <HeaderForm :module="module" @handleReload="getDetail"/>
            <div class="row">
                <Input label="Tiêu đề" :error_mes="errors?.name" v-model="name"/>
                <Input label="Mã" :error_mes="errors?.code" v-model="code"/>
                <Input label="Giá bán" :error_mes="errors?.price" v-model="price"/>
                <Select label="Tình trạng" v-model="status" :error_mes="errors?.status"/>
                <Select label="Danh mục" v-model="category_id" :error_mes="errors?.categories"
                        :options="categories"/>
                <Input label="Tỉnh/Thành phố" v-model="province_id" :error_mes="errors?.province_id"
                       :options="provinces"/>
                <Input label="Địa chỉ" v-model="address" :error_mes="errors?.address"/>
                <TextArea label="Mô tả chi tiết" v-model="category_id" :error_mes="errors?.category_id"/>
                <Upload label="Avatar" v-model="avatar" :show-upload-list="true" :error_mes="errors?.avatar"/>
                <Upload label="Bộ sưu tập" v-model="gallery"/>

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
import TextArea from "../../../components/form/TextArea.vue";

const module = 'posts';
useMenu().onSelectedKeys([`admin-${module}`]);
const router = useRouter()
const route = useRoute()

const endpointDetail = getEndpoint(module, 'edit', route.params.id);
const endpointUpdate = getEndpoint(module, null, route.params.id);

const isLoading = ref(false);

const state = reactive({
    name: "",
    code: "",
    status: 1,
    price: 0,
    category_id: null,
    gallery: [],
    media_ids: [],
    avatar: [],
    avatar_id: [],
    province_id: null,
    district_id: null,
    ward_id: null,
    address: '',
})
const expand = reactive({
    categories: [],
    provinces: []
})


const errors = ref({})

const getDetail = async () => {
    isLoading.value = true;
    try {
        const res = await axios.get(endpointDetail);
        const result = res.data.result
        if (result) {
            Object.keys(state).forEach(field => {
                state[field] = res.data.result[field]
            })

            state.avatar = result.avatar ? [result.avatar] : []
            state.gallery = result.gallery

            expand.categories = res.data.expand.categories;
        } else {
            console.log(res)
        }
    } catch (err) {
        console.log(err)
    }

    isLoading.value = false;
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

const {
    name,
    code,
    value,
    status,
    gallery,
    avatar,
    category_id,
    price,
    province_id,
    district_id,
    ward_id,
    address
} = {...toRefs(state)};
const {categories, provinces} = {...toRefs(expand)}

</script>
