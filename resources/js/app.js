import './bootstrap';
import {createApp} from 'vue'
import {createPinia} from "pinia";
import router from "./router/index.js";
import axios from "axios";
// axios.defaults.baseURL = 'http://localhost:1010/'
// const access_token = localStorage.getItem('access_token')
// const currentUser = JSON.parse(localStorage.getItem('user'));
// window.isLogin = false;
// if (access_token) {
//     axios.defaults.headers.common = {'Authorization': `bearer ${access_token}`}
//     // window.currentUser = currentUser;
//     window.isLogin = true;
// }

window.axios = axios;
import {
    Checkbox,
    Input,
    Select,
    Avatar,
    Menu,
    Drawer,
    List,
    Button,
    message,
    Card,
    Table,
    Pagination,
    Skeleton,
    Upload,
    Modal,
    Image,
    Form,
    FormItem,
    Dropdown
} from "ant-design-vue";

import App from './App.vue'

import './static/fontawesome/css/all.css';

import 'ant-design-vue/dist/antd.css'
import 'bootstrap/dist/css/bootstrap-grid.css'
import 'bootstrap/dist/css/bootstrap-utilities.css'
import {useAuth} from "./store/use-auth.js";


const app = createApp(App)

// app.component('font-awesome-icon', FontAwesomeIcon)
app.use(createPinia())
app.use(router);
app.use(Checkbox);
app.use(Input);
app.use(Select);
app.use(Avatar);
app.use(Button)
app.use(Drawer)
app.use(List)
app.use(Menu)
app.use(Card)
app.use(Table)
app.use(Pagination)
app.use(Skeleton)
app.use(Upload)
app.use(Modal)
app.use(Image)
app.use(Form)
app.use(FormItem)
app.use(Dropdown)

app.mount('#app');

app.config.globalProperties.$message = message
useAuth().onCheckLogin();
