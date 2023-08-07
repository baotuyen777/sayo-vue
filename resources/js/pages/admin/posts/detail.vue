<template>
    <form @submit.prevent="handleUpdate()">
        <a-card title="Tạo mới tài khoản" style="width: 100%">
            <HeaderForm :module="module" @handleReload="getDetail"/>
            <a-skeleton v-if="isLoading"/>
            <div class="row" v-if="!isLoading">
                <Input label="Tiêu đề" :error_mes="errors?.name" v-model="name"/>
                <Input label="Giá bán" :error_mes="errors?.price" v-model="price"/>
                <Select label="Tình trạng" v-model="status" :error_mes="errors?.status"/>
                <Select label="Danh mục" v-model="category_id" :error_mes="errors?.categories"
                        :options="categories"/>
                <Select label="Tỉnh/Thành phố" v-model="province_id" :error_mes="errors?.province_id"
                        :options="provinces"/>
                <Select label="Quận/Huyện" v-model="district_id" :error_mes="errors?.district_id"
                        :options="districts"/>
                <Select label="Phường/Xã" v-model="ward_id" :error_mes="errors?.pdws_id"
                        :options="wards"/>
                <Input label="Địa chỉ" v-model="address" :error_mes="errors?.address"/>
                <TextArea label="Mô tả chi tiết" v-model="content" :error_mes="errors?.content"/>
                <Upload label="Avatar" v-model="avatar" :show-upload-list="true" :error_mes="errors?.avatar_id"/>
                <Upload label="Bộ sưu tập" v-model="gallery" :error_mes="errors?.media_ids"/>

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
    content: "",
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
    provinces: [],
    districts: [],
    wards: [],
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

            Object.keys(res.data.expand).forEach(field => {
                expand[field] = res.data.expand[field]
            })
        } else {
            console.log(res)
        }
    } catch (err) {
        console.log(err)
    }

    isLoading.value = false;
}

getDetail();

const handleUpdate = async () => {
    errors.value = {}
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
        errors.value = err.response.data.errors;
    }
}

const {
    name,
    content,
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
const {categories, provinces, districts, wards} = {...toRefs(expand)}

</script>
