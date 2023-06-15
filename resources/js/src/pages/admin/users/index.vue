<template>
    <ListView module="users" :columns="columns" title="Tài khoản"/>
</template>

<script>
import {useMenu} from "../../../store/use-menu.js";
import {defineComponent} from "vue";
import HeaderList from "../../../components/list/HeaderList.vue";
import ListView from "../../../components/list/ListView.vue";

export default defineComponent({
    components: {ListView, HeaderList},
    setup() {
        useMenu().onSelectedKeys(['admin-users']);
        const columns = [
            {title: "#", key: 'index'},
            {title: "Tên", dataIndex: 'name', key: 'name'},
            {title: "Tài khoản", dataIndex: 'username', key: 'username'},
            {title: "Phòng ban", dataIndex: 'departments_name', key: 'departments_name', responsive: ['sm']},
            {title: "Vai trò", dataIndex: 'roles_name', key: 'roles_name'},
            {title: "Email", dataIndex: 'email', key: 'email'},
            {title: "Trạng thái", dataIndex: 'status_id', key: 'status_id'},
            {title: "Hành động", key: 'action', fixed: 'right'},
        ];

        return {columns}
    }
})
</script>
