<template>
    <a-menu
        v-model:openKeys="openKeys"
        v-model:selectedKeys="selectedKeys"
        mode="inline"
    >
        <template v-for="item in adminRoutes.children">
            <a-menu-item v-if="item?.label" :key="item.name">
                <router-link :to="{name:item.name}">
                    <span><UserOutlined class="me-1"/>  {{ item.label }} </span>
                </router-link>
            </a-menu-item>
        </template>

    </a-menu>
</template>

<script>
import {UserOutlined, TagOutlined, SettingOutlined} from '@ant-design/icons-vue';
import {defineComponent} from 'vue';
import {storeToRefs} from "pinia";
import {useMenu} from "@/src/store/use-menu.js";
import admin, {adminRoutes} from "../../router/admin"

export default defineComponent({
    components: {
        UserOutlined, TagOutlined, SettingOutlined
    },
    setup() {
        const store = useMenu();
        console.log(adminRoutes.children);
        return {...storeToRefs(store), admin, adminRoutes}
    },
});
</script>
