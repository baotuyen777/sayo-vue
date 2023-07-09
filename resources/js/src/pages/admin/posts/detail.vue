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
                    <!--                    <Upload @upload-success="handleUploadSuccess"  v-model:files="gallery"/>-->
                    <!--                    <Upload @upload-success="handleUploadSuccess"  v-model="gallery"/>-->
                    <div class="clearfix">
                        <a-upload
                            v-model:file-list="gallery"
                            :action="API_URL+'medias'"
                            list-type="picture-card"
                            @preview="handlePreview"
                            :onChange="handleUploadSuccess"

                        >
                            <div>
                                <plus-outlined/>
                                <div style="margin-top: 8px">Upload</div>
                            </div>
                        </a-upload>
                        <a-modal :visible="previewVisible" :title="previewTitle" :footer="null" @cancel="handleCancel">
                            <img alt="example" style="width: 100%" :src="previewImage"/>
                        </a-modal>
                    </div>
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
// import {API_URL} from "../../../configs";

const API_URL = window.configValues.API_URL
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
    gallery: [],
    previewImage: '',
    previewVisible: false,
    previewTitle: '',
})

const errors = ref({})

const handleUploadSuccess = (files) => {
    console.log(files, 33322)
    const newFiles = files.fileList.map((file) => {
        return file?.response?.result || file
    })
    state.files = newFiles;
    console.log(newFiles, 8888);
}

const getDetail = async () => {
    try {
        const res = await axios.get(endpointDetail);
        if (res.data.result) {
            Object.keys(state).forEach(field => {
                state[field] = res.data.result[field]
            })
            const gallery = res.data.result.gallery.map(media => ({
                ...media,
                id: media.response?.result?.id || media.id,
                url: `${window.configValues.MEDIA_URL}storage/uploads/${media.url}`
            }));
            // state.gallery = gallery;
            console.log(state, 333)
        } else {
            console.log(res)
        }
    } catch (err) {
        console.log(err)
    }
}
const handleUpdate = async () => {
    try {
        let res;
        if (route.params.id) {
            res = await axios.put(endpointUpdate, state);
        } else {
            res = await axios.post(endpointUpdate, state);
        }
        await router.push({name: `admin-${module}`})
        message.success('Thành công')
        console.log(res, 222);
    } catch (err) {
        console.log(err)
        errors.value = err.response.data.errors;
    }
}

getDetail();
const {name, code, value, status, gallery, previewImage, previewVisible, previewTitle} = {...toRefs(state)};

function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
}

const handleCancel = () => {
    state.previewVisible = false;
};

const handlePreview = async file => {
    if (!file.url && !file.preview) {
        file.preview = await getBase64(file.originFileObj);
    }

    state.previewImage = file.url || file.preview;
    state.previewVisible = true;
    state.previewTitle = file.name || file.url.substring(file.url.lastIndexOf('/') + 1);
};

</script>
