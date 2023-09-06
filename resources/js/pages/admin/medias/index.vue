<template>
    <ListView :module="module" :columns="columns" title="Danh mục"/>
</template>

<script setup>
import {useMenu} from "../../../store/use-menu.js";
import ListView from "../../../components/list/ListView.vue";

const module = 'files';
useMenu().onSelectedKeys([`admin-${module}`]);

const columns = [
    {title: "#", key: 'index'},
    {title: "Tên", dataIndex: 'name', key: 'name'},
    {title: "Avatar", dataIndex: 'url', key: 'media'},
    {title: "Trạng thái", dataIndex: 'status_label', key: 'status'},
    {title: "Hành động", key: 'action', fixed: 'right'},
];

</script>
