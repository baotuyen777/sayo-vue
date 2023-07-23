<template>
    <a-menu
        v-model:openKeys="openKeys"
        v-model:selectedKeys="selectedKeys"
        mode="inline"
    >
        <template v-for="item in adminRoutes.children">
            <a-menu-item v-if="item?.label" :key="item.name">
                <router-link :to="{name:item.name}">
                    <span><i class="fa-solid fa-user"></i>  {{ item.label }} </span>
                </router-link>
            </a-menu-item>
        </template>

    </a-menu>
</template>

<script setup>

import {storeToRefs} from "pinia";
import {useMenu} from "../../store/use-menu.js";
import {adminRoutes} from "../../router/admin.js"

const {openKeys, selectedKeys} = storeToRefs(useMenu())
</script>
