<template>
    <div>
        <a-button class="me-0 me-sm-2 mb-3 mb-sm-0">
            <router-link :to="{name:`admin-${module}`}">Hủy</router-link>
        </a-button>
        <a-button type="primary" html-type="submit">Lưu</a-button>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props:['module'],
    setup() {
        return {}
    }
})
</script>
