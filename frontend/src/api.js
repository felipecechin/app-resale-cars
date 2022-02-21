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

async function refreshToken(error) {
    return new Promise((resolve, reject) => {
        try {
            const token = getToken();
            if (!token) {
                return reject(error);
            }
            const header = {
                Authorization: `Bearer ${token}`,
            };
            const parameters = {
                headers: header,
            };
            axios
                .post(
                    baseApiUrl + "/auth/refresh",
                    null,
                    parameters
                )
                .then(async (res) => {
                    localStorage.setItem(userKey, JSON.stringify(res.data))
                    // Fazer algo caso seja feito o refresh token
                    return resolve(res);
                })
                .catch((err) => {
                    // Fazer algo caso não seja feito o refresh token=
                    return reject(error);
                });
        } catch (err) {
            return reject(err);
        }
    });
}

api.interceptors.response.use(
    (response) => {
        return response;
    },
    function (error) {
        const originalRequest = error.config;
        const access_token = getToken();
        if (error.response.status === 401 && access_token) {
            return refreshToken(error).then((res) => {
                return api.request(originalRequest)
            }).catch(() => {
                localStorage.removeItem(userKey)
                window.location.href = '/auth'
            })
        }
        return Promise.reject(error);
    }
);


export default api;
