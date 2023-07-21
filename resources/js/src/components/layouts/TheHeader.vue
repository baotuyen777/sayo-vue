<template>
    <div class="container-fluid">
        <div class="row text-white" style="background-color: green; padding: 1rem">
            <div class="col-1 d-flex d-sm-none align-items-center justify-content-center">
                <span @click="showDrawer"><i class="fa-solid fa-align-justify"></i></span>
            </div>

            <div class="col-10 col-sm-9 d-flex align-items-center justify-content-center justify-content-sm-start">
                <img src="../../assets/logo.png" alt="logo" height="32" width="34" class="ms-3 me-3">
                <span class="d-none d-sm-flex">Quan tri</span>
            </div>

            <div class="col-sm-3 d-none d-sm-flex align-items-center justify-content-sm-end">
                <a-dropdown :trigger="['click']">
                    <a class="ant-dropdown-link" @click.prevent>
                        Admin
                        <DownOutlined/>
                    </a>
                    <template #overlay>
                        <a-menu>
                            <a-menu-item key="0">
                                <a href="http://www.alipay.com/">Thông tin cá nhân</a>
                            </a-menu-item>
                            <a-menu-item key="1">
                                <a href="#" :onclick="logout">logout</a>
                            </a-menu-item>
                            <a-menu-divider/>
                            <a-menu-item key="3">3rd menu item</a-menu-item>
                        </a-menu>
                    </template>
                </a-dropdown>
                <a class="ant-dropdown-link" :onClick="gotoLogin">
                    Login
                </a>
            </div>

            <div class="col-1 d-flex d-sm-none align-items-center justify-content-center">
                <span @click="showDrawerUser"><i class="fa-solid fa-user"></i></span>
            </div>
        </div>
    </div>

    <a-drawer
        v-model:visible="visible"
        title="Danh mục"
        placement="left"
    >
        <TheMenu/>
    </a-drawer>

    <a-drawer
        v-model:visible="visible_user"
        title="Admin"
        placement="right"
    >
        <p>Some contents...</p>
        <p>Some contents...</p>
        <p>Some contents...</p>
    </a-drawer>
</template>

<script setup>
import TheMenu from "./TheMenu.vue";
import {ref} from 'vue';
import {message} from "ant-design-vue";
import {useRouter} from "vue-router";

const router = useRouter()
const visible = ref(false);
const visible_user = ref(false);

const showDrawer = () => {
    visible.value = true;
};

const showDrawerUser = () => {
    visible_user.value = true;
};

const logout = async () => {

    const endpointUpdate = window.configValues.API_URL + 'logout';
    const res = await axios.get(endpointUpdate);

    if (res.data.status_code === 200) {
        localStorage.removeItem('access_token');
        await router.push({name: `admin-user-login`})
        message.success('Đăng xuất thành công')
    }

}

const gotoLogin= () =>{
    router.push({name: `admin-user-login`})
}

</script>
