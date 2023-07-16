<template>
    <div class="row mb-3">
        <div class="col-4 d-flex  gap-2">
            <a-button type="primary" class="mr-10">
                <router-link :to="{name:`admin-${module}-create`}">
                    <i class="fa-solid fa-plus"></i>
                </router-link>
            </a-button>
            <a-button type="primary">
                <router-link :to="{name:`admin-${module}-create`}">
                    <i class="fa-solid fa-file-excel"></i>
                </router-link>
            </a-button>

            <!--            <a-button type="primary">-->
            <!--                <router-link :to="{name:'admin-users-create'}">-->
            <!--                    <font-awesome-icon :icon="['fas', 'filter']"/>-->
            <!--                </router-link>-->
            <!--            </a-button>-->
            <a-button type="primary" @click="handleSearch">
                <i class="fa-solid fa-rotate"></i>
            </a-button>
        </div>

        <div class="col-8 d-flex justify-content-end">
            <span class="d-inline-block mt-1 me-3">Tổng: {{ objs.to }}/{{ objs.total }}</span>
            <a-input-search
                placeholder="input search text"
                style="width: 200px"
                @change="handleSearch"
                v-model:value="value"
            />
        </div>
    </div>
</template>

<script setup>

import {ref} from "vue";

const props = defineProps(['module', 'objs']);
const emit = defineEmits([]);
const value = ref('')
console.log(props)

const handleSearch = () => {
    emit('getList', {s: value.value});
}

</script>
