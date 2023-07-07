<template>
    <div class="clearfix">
        <a-upload
            v-model:file-list="fileList"
            :action="API_URL+'medias'"
            list-type="picture-card"
            @preview="handlePreview"
            :onChange="handleOnchange"

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
</template>

<script setup>
import {PlusOutlined} from '@ant-design/icons-vue';
import {ref} from 'vue';
import {API_URL} from "../../configs";

const props = defineProps(['files','modelValue'])
const emit = defineEmits([]);


const previewVisible = ref(false);
const previewImage = ref('');
const previewTitle = ref('');
const fileList = ref(props.files || []);
// console.log(fileList ,5555)
function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
}

const handleCancel = () => {
    previewVisible.value = false;
    previewTitle.value = '';
};

const handlePreview = async file => {
    if (!file.url && !file.preview) {
        file.preview = await getBase64(file.originFileObj);
    }

    previewImage.value = file.url || file.preview;
    previewVisible.value = true;
    previewTitle.value = file.name || file.url.substring(file.url.lastIndexOf('/') + 1);
};

const handleOnchange = (res) => {
    const {status, response} = res.file;
    if (status === 'done') {
        console.log(res.fileList);
        // emit('update:modelValue', res.fileList)
        emit('upload-success', res.fileList)
    } else if (status === 'error') {
        // Handle upload error
        console.log('Upload error:', res.file.error);
    }

}


</script>
