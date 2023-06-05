<template>
    <div class="row mb-3">
        <div class="col-4 d-flex  gap-2">
            <a-button type="primary" class="mr-10">
                <router-link :to="{name:`admin-${module}-create`}">
                    <font-awesome-icon :icon="['fas', 'plus']"/>
                </router-link>
            </a-button>
            <a-button type="primary">
                <router-link :to="{name:`admin-${module}-create`}">
                    <font-awesome-icon :icon="['fas', 'file-excel']"/>
                </router-link>
            </a-button>

            <!--            <a-button type="primary">-->
            <!--                <router-link :to="{name:'admin-users-create'}">-->
            <!--                    <font-awesome-icon :icon="['fas', 'filter']"/>-->
            <!--                </router-link>-->
            <!--            </a-button>-->
            <a-button type="primary" @click="handleSearch">
                <!--                <router-link :to="{name:'admin-users-create'}">-->
                <font-awesome-icon :icon="['fas', 'rotate']"/>
                <!--                </router-link>-->
            </a-button>
        </div>

        <div class="col-8 d-flex justify-content-end">
            <span class="d-inline-block mt-1 me-3">Tổng: {{objs.to}}/{{objs.total}}</span>
            <a-input-search
                placeholder="input search text"
                style="width: 200px"
                @change="handleSearch"
                v-model:value="value"
            />
        </div>
    </div>
</template>

<script>
import {defineComponent, ref} from "vue";

export default defineComponent({
    props: ['module', 'getList', 'objs'],
    setup(props) {
        console.log(props)

        return {}
    },
    methods: {
        handleSearch(searchValue) {
            this.$emit('getList', {s: this.value});
        }
    }
})
</script>
