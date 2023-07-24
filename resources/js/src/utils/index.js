import {message} from "ant-design-vue";

export const hanldeErrorApi = (res) => {
    if (res.response.status === 401){
        window.location.href  = '/admin/login';
        return;
    }

    console.log(res,333111);
}

export const logout =  () => {

    const endpointUpdate = window.configValues.API_URL + 'logout';
    const res = axios.get(endpointUpdate);

    localStorage.removeItem('access_token');
    localStorage.removeItem('user');
    // useAuth().onCheckLogin();
    // router.push({name: `admin-user-login`})


    if (res?.data?.status_code === 200) {
        message.success('Đăng xuất thành công')
    }

    window.location.href  = '/admin/login';

}
