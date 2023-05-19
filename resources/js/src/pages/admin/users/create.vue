<template>
    <form @submit.prevent="createUsers()">
        <a-card title="Tạo mới tài khoản" style="width: 100%">
            <div class="row mb-3"></div>
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mb-3">
                            <a-avatar shape="square" :size="200">
                                <template #icon>
                                    <!--                    <UserOutlined />-->
                                    <img src="../../../assets/user.jpg"/>
                                </template>
                            </a-avatar>
                        </div>

                        <div class="col-12 d-flex justify-content-center me-2">
                            <a-button type="primary">
                                <font-awesome-icon :icon="['fas', 'plus']"/>
                                <span>Chọn ảnh</span>
                            </a-button>
                        </div>

                    </div>


                </div>
                <div class="col-12 col-sm-8">
                    <div class="row">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{'text-danger':errors?.status_id}">Tình trạng</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-select
                                show-search
                                placeholder="Tình trạng"
                                style="width: 100%"
                                :options="users_status"
                                :filter-option="filterOption"
                                v-model:value="status_id"
                                :class="{'select-danger': errors?.status_id}"
                            ></a-select>
                            <div class="w-100"></div>
                            <small v-if="errors?.status_id" class="text-danger">{{ errors?.status_id[0] }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{'text-danger': errors?.username}">Tên đăng nhập</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Tên đăng nhập" allow-clear v-model:value="username"
                                     :class="{'input-danger':errors?.username}"/>
                            <small v-if="errors?.username" class="text-danger">{{ errors?.username[0] }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Họ và tên</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Họ và tên" allow-clear v-model:value="name"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Email</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Email" allow-clear v-model:value="email"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Phòng ban</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-select
                                show-search
                                placeholder="Phòng ban"
                                style="width: 100%"
                                :options="departments"
                                :filter-option="filterOption"
                                v-model:value="departments_id"
                            ></a-select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Mật khẩu</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password placeholder="Mật khẩu" allow-clear autocomplete="password"
                                              v-model:value="password"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Xác nhận mật khẩu</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password placeholder="Xác nhận mật khẩu" allow-clear autocomplete="new-password"
                                              v-model:value="password_confirmation"/>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12 d-grid mx-auto d-sm-flex justify-content-sm-end">
                    <a-button class="me-0 me-sm-2 mb-3 mb-sm-0">
                        <router-link :to="{name:'admin-users'}">Hủy</router-link>
                    </a-button>
                    <a-button type="primary" html-type="submit">Lưu</a-button>
                </div>
            </div>
        </a-card>
    </form>
</template>

<script>
import {defineComponent, ref, reactive, toRefs} from "vue";
import {useMenu} from "@/src/store/use-menu.js";
import {useRouter} from "vue-router";
import {message} from "ant-design-vue";

export default defineComponent({
    setup() {
        useMenu().onSelectedKeys(['admin-users']);
const router = useRouter()
        const users_status = ref([])
        const departments = ref([]);

        const users = reactive({
            username: "",
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            departments_id: 1,
            status_id: 1,
        })

        const errors = ref({})
        const getUsersCreate = () => {
            axios.get('http://localhost:8000/api/users/create')
                .then((res) => {
                    users_status.value = res.data.users_status;
                    departments.value = res.data.departments

                }).catch((err) => console.log(err));
        }

        const filterOption = (input, option) => {
            return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
        }

        const createUsers = () => {
            axios.post('http://localhost:8000/api/users', users).then(res => {
                if(res){
                    message.success('Thành công')
                    router.push({name:'admin-users'})
                }
            }).catch(err => {
                errors.value = err.response.data.errors;
            })
        }

        getUsersCreate();

        return {
            users_status,
            departments,
            ...toRefs(users),
            errors,
            filterOption,
            createUsers
        }
    }
})
</script>
<style>
.select-danger, .input-danger {
    border: 1px solid red;
}
</style>
