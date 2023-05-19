<template>

    <a-card title="Tài khoản" style="width: 100%">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <a-button type="primary">
                    <router-link :to="{name:'admin-users-create'}">
                        <font-awesome-icon :icon="['fas', 'plus']"/>
                    </router-link>

                </a-button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a-table :columns="columns" :data-source="users" :scroll="{x:576}">
                    <template #bodyCell="{column, index, record}">
                        <template v-if="column.key === 'index'">
                            <span>{{ index + 1 }}</span>
                        </template>

                        <template v-if="column.key === 'status_id'">
                            <span v-if="record.status_id===1" class="text-primary">Hoạt động</span>
                            <span v-if="record.status_id!=1" class="text-primary">Tạm khóa</span>
                        </template>

                        <template v-if="column.key === 'action'">
                            <router-link :to="{name:'admin-users-edit', params:{id:record.id}}">
                                <a-button type="primary">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']"/>
                                </a-button>
                            </router-link>
                        </template>

                    </template>
                </a-table>
            </div>
        </div>
    </a-card>
</template>

<script>
import {useMenu} from "@/src/store/use-menu.js";
import {defineComponent, ref} from "vue";

export default defineComponent({
    setup() {
        useMenu().onSelectedKeys(['admin-users']);

        const users = ref([]);

        const columns = [
            {title: "#", key: 'index'},
            {title: "Tên", dataIndex: 'username', key: 'username'},
            {title: "Phòng ban", dataIndex: 'department_name', key: 'department_name', responsive: ['sm']},
            {title: "Vai trò", dataIndex: 'roles_name', key: 'roles_name'},
            {title: "Trạng thái", dataIndex: 'status_id', key: 'status_id'},
            {title: "Hành động", key: 'action', fixed: 'right'},
        ];
        const getUsers = () => {
            axios.get("http://localhost:8000/api/users")
                .then((response) => {
                    users.value = response.data.data;
                })
                .catch(error => console.log(error))
        }

        // const getUsers = async () => {
        //     try {
        //         const response = await axios.get('http://localhost:8000/api/users');
        //         console.log(response);
        //     } catch (error) {
        //         console.log(error)
        //     }
        // }

        getUsers();
        return {users, columns}
    }
})
</script>
