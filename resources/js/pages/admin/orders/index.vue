<template>
    <ListView :module="module" :columns="columns" title="Danh mục"/>
</template>

<script setup>
import {useMenu} from "../../../store/use-menu.js";
import ListView from "../../../components/list/ListView.vue";

const module = 'orders';
useMenu().onSelectedKeys([`admin-${module}`]);

const columns = [
    {title: "#", key: 'index'},
    {title: "Khách hàng", dataIndex: 'user_id', key: 'user_id'},
    {title: "Trạng thái", dataIndex: 'state', key: 'state'},
    {title: "Hành động", key: 'action', fixed: 'right'},
];

</script>
