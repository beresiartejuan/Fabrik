import axios from "axios";

const client = axios.create({
    baseURL: import.meta.env.DEV ? "http://localhost:8000/api" : "",
    withCredentials: true
});

client.interceptors.request.use((request) => {
    if (window) {
        const auth_key = window.localStorage.getItem("auth_key");

        if (auth_key) request.headers.Authorization = "Bearer " + auth_key;
    }

    return request;
});

client.interceptors.response.use(response => {
    return {
        ...response,
        ok: response.status >= 200 && response.status < 300
    };
});

export default client;