<template>
    <a-menu
        v-model:openKeys="openKeys"
        v-model:selectedKeys="selectedKeys"
        mode="inline"
    >
        <a-menu-item key="admin-users">
            <router-link :to="{name:'admin-users'}">
                <span>Tài khoản </span>
            </router-link>
        </a-menu-item>
        <a-menu-item key="admin-roles">
            <router-link :to="{name:'admin-roles'}">
                <span>Vai trò </span>
            </router-link>
        </a-menu-item>
        <a-menu-item key="admin-settings">
            <router-link :to="{name:'admin-settings'}">
                <span>Cài đặt</span>
            </router-link>
        </a-menu-item>
    </a-menu>
</template>

<script>
import {defineComponent, reactive, toRefs} from 'vue';

export default defineComponent({
    setup() {
        const state = reactive({
            selectedKeys: ['admin-roles'],
            openKeys: [],
        });

        return {...toRefs(state)};
    },
});
</script>
