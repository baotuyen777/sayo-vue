<template>
    <a-card :title="title" style="width: 100%">
        <HeaderList :module="module" @getList="getList" :objs="objs"/>
        <div class="listview">
            <a-skeleton v-if="isLoading"/>
            <a-table :columns="columns"
                     :data-source="objs.data" :scroll="{x:576}"
                     :pagination="pagination"
                     @change="onChange"
                     v-if="!isLoading"
            >
                <template #bodyCell="{column, index, record}">
                    <template v-if="column.key === 'index'">
                        <span>{{ index + 1 }}</span>
                    </template>

                    <template v-if="column.key === 'status'">
                        <span  :class="record?.status ? 'text-success' :'text-warning' ">{{record?.status_label}}</span>
                    </template>

                    <template v-if="column.key === 'media'">
                        <a-image :width="100" :src="MEDIA_URL+record.url"/>
                    </template>
                    <template v-if="column.key === 'avatar'">
                        <a-image :width="100" :src="record?.avatar?.url"/>
                    </template>

                    <template v-if="column.key === 'action'">
                        <div class="action-column">
                            <router-link :to="{name:'admin-'+module+'-edit', params:{id:record.id}}">
                                <a-button type="primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a-button>
                            </router-link>
                            <a-button type="primary" danger :onclick="()=>handleDelele(record.id)">
                                <i class="fa-solid fa-trash"></i>
                            </a-button>
                        </div>

                    </template>

                </template>
            </a-table>
        </div>
    </a-card>
</template>

<script setup>
import {reactive, ref} from "vue";
import HeaderList from "./HeaderList.vue";
import {hanldeErrorApi} from "../../utils";

const props = defineProps(['module', 'title', 'columns']);

const objs = ref({});
const isLoading = ref(false);
const MEDIA_URL = window.configValues.MEDIA_URL
const pagination = reactive({current: 1, total: 0, pageSize: 5})

const getList = async (params) => {
    isLoading.value = true;
    try {
        const res = await axios.get(`${window.configValues.API_URL}${props.module}`, {params}, )
        objs.value = res.data;

        pagination.current = res.data.current_page
        pagination.total = res.data.total
        pagination.pageSize = res.data.per_page
    } catch (err) {
        hanldeErrorApi(err)
    }

    isLoading.value = false
}

const handleDelele = async (id) => {
    const res = await axios.delete(`${window.configValues.API_URL}${props.module}/${id}`);
    console.log(res);
    await getList()
}

const onChange = (pagination) => {
    console.log(pagination, 33);
    getList(pagination)
}

getList();

</script>
