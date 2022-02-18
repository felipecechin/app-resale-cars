import axios from 'axios';
import {baseApiUrl, userKey} from "@/global";


export const getToken = () => {
    const json = localStorage.getItem(userKey)
    const userData = JSON.parse(json)
    if (!userData) {
        return false
    } else {
        if (userData.access_token) {
            return userData.access_token
        } else {
            return false
        }
    }
}

const api = axios.create({
    baseURL: baseApiUrl
});

// JWT interceptor
api.interceptors.request.use(config => {
    const token = getToken();
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default api;
