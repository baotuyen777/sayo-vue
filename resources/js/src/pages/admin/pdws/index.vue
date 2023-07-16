<template>
    <ListView module="pdws" :columns="columns" title="Tỉnh huyện xã"/>
</template>

<script>
import {useMenu} from "../../../store/use-menu.js";
import {defineComponent} from "vue";
import HeaderList from "../../../components/list/HeaderList.vue";
import ListView from "../../../components/list/ListView.vue";

export default defineComponent({
    components: {ListView, HeaderList},
    setup() {
        useMenu().onSelectedKeys(['admin-settings']);
        const columns = [
            {title: "#", key: 'index'},
            {title: "Tên", dataIndex: 'name', key: 'name'},
            {title: "code", dataIndex: 'code', key: 'code'},
            {title: "value", dataIndex: 'value', key: 'value'},
            {title: "Trạng thái", dataIndex: 'status_label', key: 'status'},
            {title: "Hành động", key: 'action', fixed: 'right'},
        ];

        return {columns}
    }
})
</script>
