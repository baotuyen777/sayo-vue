import './bootstrap';
import {createApp} from 'vue'
import router from "./src/router/index.js";
import {createPinia} from "pinia";
import {
    Menu,
    Drawer,
    List,
    Button,
    message
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
app.use(Button)
app.use(Drawer)
app.use(List)
app.use(Menu)

app.mount('#app');

app.config.globalProperties.$message = message
