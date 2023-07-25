<template>
    <form @submit.prevent="handleSubmit()" class="login-page">
        <a-card title="Login">
            <Input label="Email" v-model="email" icon="user" status="error" class-wrapper="mb-3 mt-3 col-md-12"/>
            <Input label="Mật khẩu" v-model="password" type="password" icon="lock" class-wrapper="mb-3 mt-3 col-md-12"/>
            <a-form-item>
                <a-form-item name="remember" no-style>
                    <a-checkbox v-model:checked="remember">Remember me</a-checkbox>
                </a-form-item>
                <a class="login-form-forgot" href="">Forgot password</a>
            </a-form-item>

            <a-form-item>
                <a-button :disabled="disabled" type="primary" html-type="submit" class="login-form-button">
                    Log in
                </a-button>
                Or
                <a href="">register now!</a>
            </a-form-item>
        </a-card>
    </form>
</template>
<script setup>
import {reactive, computed, toRefs} from 'vue';
import Input from "../../../components/form/Input.vue";
import {message} from "ant-design-vue";
import {useRouter} from "vue-router";
import {useAuth} from "../../../store/use-auth.js";

const router = useRouter()

const state = reactive({
    email: 'admin@gmail.com',
    password: '123456',
    remember: true,
});

const handleSubmit = async () => {
    const endpointUpdate = window.configValues.API_URL + 'login';
    try {
        const res = await axios.post(endpointUpdate, state);
        if (res.data.status_code === 200) {
            localStorage.setItem('access_token', res.data.access_token);
            localStorage.setItem('user', JSON.stringify(res.data.user));
            useAuth().onCheckLogin({isLogin: true});
            // await router.push('users')
            window.location.href='/admin/users'
            message.success('Thành công')
        }

    } catch (err) {
        console.log(err.response.data.errors, 1111)
        errors.value = err.response.data.errors;
    }
}

const disabled = computed(() => {
    return !(state?.email && state.password);
});

const {email, password, remember} = {...toRefs(state)};
</script>

