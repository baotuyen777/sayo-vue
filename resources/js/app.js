import './bootstrap';
import {createApp} from 'vue'
import router from "./src/router/index.js";
import {
    Menu,
    Drawer,
    List,
    Button,
    message} from "ant-design-vue";

import App from './App.vue'

import 'ant-design-vue/dist/antd.css'
import 'bootstrap/dist/css/bootstrap-grid.css'
import 'bootstrap/dist/css/bootstrap-utilities.css'

const app = createApp(App)
app.use(router);
app.use(Button)
app.use(Drawer)
app.use(List)
app.use(Menu)

app.mount('#app');

app.config.globalProperties.$message =message
