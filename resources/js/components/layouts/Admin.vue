<template>
    <TheHeader/>
    <div class="container-fluid mt-3">
        <div class="row" v-if="isLogin">
            <div class="col-sm-3">
                <a-card title=" Bảng điều khiển">
                    <TheMenu/>
                </a-card>
<!--                <a-list bordered style="width:100%">-->
<!--                    <template #header>-->
<!--                        Bảng điều khiển-->
<!--                    </template>-->
<!--                    <TheMenu/>-->
<!--                </a-list>-->
            </div>

            <div class="col-12 col-md-9">
                <router-view></router-view>
            </div>
        </div>
        <div v-if="!isLogin">
            <router-view></router-view>
        </div>
    </div>

</template>

<script setup>
import TheHeader from "./TheHeader.vue";
import TheMenu from "./TheMenu.vue";
import {useRouter} from "vue-router";
import {storeToRefs} from "pinia";
import {useAuth} from "../../store/use-auth.js";

const isLogin = storeToRefs(useAuth()).isLogin.value
// const {auth} = storeToRefs(useAuth())
// console.log(auth,9999)

const router = useRouter()
const currentPage = router.currentRoute.value.path;

if (!isLogin && currentPage != '/admin/login') {
    router.push('/admin/login')
}
</script>
