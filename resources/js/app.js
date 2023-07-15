import './bootstrap';
import {createApp} from 'vue'
import {createPinia} from "pinia";
import router from "./src/router/index.js";
import axios from "axios";

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
} from "ant-design-vue";

import App from './App.vue'

import './src/static/fontawesome/css/all.css';

import 'ant-design-vue/dist/antd.css'
import 'bootstrap/dist/css/bootstrap-grid.css'
import 'bootstrap/dist/css/bootstrap-utilities.css'

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

app.mount('#app');

app.config.globalProperties.$message = message
