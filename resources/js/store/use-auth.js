import {defineStore} from 'pinia'
import axios from "axios";

export const useAuth = defineStore('auth', {
    state: () => ({
        isLogin: false,
        auth:{}
    }),

    actions: {
        onCheckLogin(auth=null) {

            const access_token = localStorage.getItem('access_token')
            const currentUser = JSON.parse(localStorage.getItem('user'));
            if (access_token) {
                // axios.defaults.headers.common = {'Authorization': `bearer ${access_token}`}
                window.currentUser = currentUser;
                this.isLogin = true;
            } else {
                this.isLogin = false;
            }
            console.log( this.isLogin,99988)
        },

    }
})
