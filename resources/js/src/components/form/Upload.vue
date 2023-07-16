<template>
    <div :class="classWrapper || 'mb-3 mt-3 col-md-6'">
        <div class="form-item">
            <label>
                <span class="text-danger me-1">*</span>
                <span :class="{'text-danger': error_mes}">{{ label }}</span>
            </label>

            <div class="form-control">
                <a-upload
                    :action="UploadUrl"
                    list-type="picture-card"
                    @preview="handlePreview"
                    :file-list="modelValue"
                    @change="handleChange"
                    :show-upload-list="showUploadList"
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
</template>

<script setup>
import {PlusOutlined} from '@ant-design/icons-vue';
import {ref} from 'vue';

const props = defineProps(['modelValue', 'showUploadList', 'label', 'error_mes', 'classWrapper'])
console.log(props.label, 333)
const emit = defineEmits([]);

const UploadUrl = window.configValues.API_URL + 'medias';

const previewVisible = ref(false);
const previewImage = ref('');
const previewTitle = ref('');

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

const handleChange = (res) => {
    emit("update:modelValue", res.fileList)
}

</script>
