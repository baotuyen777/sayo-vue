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
} from "ant-design-vue";

import App from './App.vue'

// import './src/static/fontawesome/css/all.css';

import {library} from '@fortawesome/fontawesome-svg-core'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import {fas} from '@fortawesome/free-solid-svg-icons'
import {fab} from '@fortawesome/free-brands-svg-icons'
import {far} from '@fortawesome/free-regular-svg-icons'

library.add(fas, fab, far)

import 'ant-design-vue/dist/antd.css'
import 'bootstrap/dist/css/bootstrap-grid.css'
import 'bootstrap/dist/css/bootstrap-utilities.css'

const app = createApp(App)

app.component('font-awesome-icon', FontAwesomeIcon)
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

app.mount('#app');

app.config.globalProperties.$message = message
