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
                    <Upload @upload-success="handleUploadSuccess" :files="files"/>
                </div>
            </div>
        </a-card>
    </form>
</template>

<script setup>
import {ref, reactive, toRefs} from "vue";
import {useMenu} from "@/src/store/use-menu.js";
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

const obj = reactive({
    name: "",
    code: "",
    status: 1,
    files:[{
        uid: '-1',
        name: 'image.png',
        status: 'done',
        url: 'https://zos.alipayobjects.com/rmsportal/jkjgkEfvpUPVyRjUImniVslZfWPnJuuZ.png',
    }
    ]
})

const errors = ref({})

const handleUploadSuccess = (files) =>{
    console.log(files,33322)
    const newFiles = files.map((file)=>{
        return file.response.result
    })
    obj.files = newFiles;
    console.log(newFiles);
}

const getDetail = async () => {
    try {
        const res = await axios.get(endpointDetail);
        if (res.data.result) {
            Object.keys(obj).forEach(field => {
                obj[field] = res.data.result[field]
            })
        }else{
            console.log(res)
        }
    } catch (err) {
        console.log(err)
    }
}

const handleUpdate = async () => {
    console.log(obj,888); return;
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
const {name, code, value, status, files} = {...toRefs(obj)};

</script>
