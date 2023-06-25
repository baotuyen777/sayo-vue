<template>
    <ListView :module="module" :columns="columns" title="Danh mục"/>
</template>

<script setup>
import {useMenu} from "../../../store/use-menu.js";
import ListView from "../../../components/list/ListView.vue";

const module = 'medias';
useMenu().onSelectedKeys([`admin-${module}`]);

const columns = [
    {title: "#", key: 'index'},
    {title: "Tên", dataIndex: 'name', key: 'name'},
    {title: "code", dataIndex: 'code', key: 'code'},
    {title: "avatar", dataIndex: 'avatar', key: 'avatar'},
    {title: "category_id", dataIndex: 'category_id', key: 'category_id'},
    {title: "category_name", dataIndex: 'category_name', key: 'category_name'},
    {title: "Trạng thái", dataIndex: 'status_label', key: 'status'},
    {title: "Hành động", key: 'action', fixed: 'right'},
];

</script>
