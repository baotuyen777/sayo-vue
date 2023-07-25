<template>
    <div>
        <a-button class="me-0 me-sm-2 mb-3 mb-sm-0">
            <router-link :to="{name:`admin-${module}`}">
                <i class="fa-solid fa-reply"></i> Quay lại
            </router-link>
        </a-button>
        <a-button type="primary" html-type="submit" class=" me-1">
            <i class="fa-solid fa-floppy-disk me-1"></i> Lưu
        </a-button>
        <a-button type="warning" @click="handleOnReload" class=" me-1">
            <i class="fa-solid fa-rotate"></i>
        </a-button>
    </div>
</template>

<script setup>

const props = defineProps(['module'])
const emit = defineEmits([])
const module = props.module

const handleOnReload = () => {
    emit('handleReload');
}
</script>
