<template>
    <a-card :title="title" style="width: 100%">
        <HeaderList module="users" @getList="getList" :objs="objs"/>
        <div class="">
            <a-skeleton v-if="isLoading"/>
            <a-table :columns="columns"
                     :data-source="objs.data" :scroll="{x:576}"
                     :pagination="{current:currentPage,total:6,pageSize:5}"
                     @change="onChange"
                     v-if="!isLoading"
            >
                <template #bodyCell="{column, index, record}">
                    <template v-if="column.key === 'index'">
                        <span>{{ index + 1 }}</span>
                    </template>

                    <template v-if="column.key === 'status_id'">
                        <span v-if="record.status_id===1" class="text-primary">Hoạt động</span>
                        <span v-if="record.status_id!=1" class="text-primary">Tạm khóa</span>
                    </template>

                    <template v-if="column.key === 'action'">
                        <router-link :to="{name:'admin-'+module+'-edit', params:{id:record.id}}">
                            <a-button type="primary">
                                <font-awesome-icon :icon="['fas', 'pen-to-square']"/>
                            </a-button>
                        </router-link>
                    </template>

                </template>
            </a-table>
        </div>
    </a-card>
</template>

<script>
import {defineComponent, ref} from "vue";
import HeaderList from "./HeaderList.vue";

export default defineComponent({
    props: ['module', 'title', 'columns'],
    components: {HeaderList},
    setup(props) {
        const objs = ref({});
        const currentPage = ref(1)
        const isLoading = ref(false);
        const getList = (params) => {
            // console.log(params, 111122)
            isLoading.value = true;
            axios.get(`http://localhost:8000/api/${props.module}`, {params})
                .then((response) => {
                    objs.value = response.data;
                    currentPage.value = response.data.current_page
                    isLoading.value = false
                    console.log(currentPage)
                })
                .catch(error => {
                        console.log(error)
                        isLoading.value = false
                    }
                )
        }

        const onChange = (pagination) => {
            console.log(pagination, 111)
            // currentPage.value = pagination.current;
            getList({page: pagination.current})
        }


        // const getUsers = async () => {
        //     try {
        //         const response = await axios.get('http://localhost:8000/api/users');
        //         console.log(response);
        //     } catch (error) {
        //         console.log(error)
        //     }
        // }

        getList();
        return {objs, getList, onChange, isLoading, currentPage}
    }
})
</script>
