<template>
    <a-card :title="title" style="width: 100%">
        <HeaderList :module="module" @getList="getList" :objs="objs"/>
        <div class="listview">
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

                    <template v-if="column.key === 'status'">
                        <span v-if="record.status_id===1" class="text-primary">Hoạt động</span>
                        <span v-if="record.status_id!=1" class="text-danger">Tạm khóa</span>
                    </template>

                    <template v-if="column.key === 'media'">
                        <a-image :width="100" :src="MEDIA_URL+record.url"/>
                    </template>

                    <template v-if="column.key === 'action'">
                        <div class="action-column">
                            <router-link :to="{name:'admin-'+module+'-edit', params:{id:record.id}}">
                                <a-button type="primary">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']"/>
                                </a-button>
                            </router-link>
                            <a-button type="primary" danger :onclick="()=>handleDelele(record.id)">
                                <font-awesome-icon :icon="['fas', 'fa-trash']"/>
                            </a-button>
                        </div>

                    </template>

                </template>
            </a-table>
        </div>
    </a-card>
</template>

<script setup>
import {ref} from "vue";
import HeaderList from "./HeaderList.vue";

const props = defineProps(['module', 'title', 'columns']);
const objs = ref({});
const currentPage = ref(1)
const isLoading = ref(false);

const getList = async (params) => {
    isLoading.value = true;
    try {
        const res = await axios.get(`${window.configValues.API_URL}${props.module}`, {params})
        objs.value = res.data;
        currentPage.value = res.data.current_page
        console.log(currentPage)
    } catch (err) {
        console.log(err)
    }

    isLoading.value = false
}

const handleDelele = async (id) => {
    const res = await axios.delete(`${window.configValues.API_URL}${props.module}/${id}`);
    console.log(res);
    await getList()
}

const onChange = (pagination) => {
    getList({page: pagination.current})
}

getList();

</script>
