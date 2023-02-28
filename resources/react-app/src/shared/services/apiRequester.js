//'http://127.0.0.1:8000/api'
import baseUrl from '../../utils/http';
const apiRequester = {
    baseUrl: baseUrl(),
    async get(path) {
        const response = await fetch(`${this.baseUrl}/${path}`, {
            method: 'GET',
            headers: this.getHeaders(),
            credentials: 'include'
        });
        return this.handleResponse(response);
    },
    async post(path, body) {
        const response = await fetch(`${this.baseUrl}/${path}`, {
            method: 'POST',
            headers: this.getHeaders(),
            body: JSON.stringify(body),
            credentials: 'include'

        });
        return this.handleResponse(response);
    },
    async patch(path, body) {
        const response = await fetch(`${this.baseUrl}/${path}`, {
            method: 'PATCH',
            headers: this.getHeaders(),
            body: JSON.stringify(body),
            credentials: 'include'
        });
        return this.handleResponse(response);
    },
    async remove(path) {
        const response = await fetch(`${this.baseUrl}/${path}`, {
            method: 'DELETE',
            headers: this.getHeaders(),
            credentials: 'include'
        });
        return this.handleResponse(response);
    },
    getHeaders() {

        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        };

        let token = localStorage.getItem('user');
        if (token) {
            token = JSON.parse(token);
            headers.Authorization = `Bearer ${token}`;
        }
        return headers;
    },
    async handleResponse(response) {
        const data = await response.json();
        if (response.ok) {
            return data;
        } else {
            if (response.status === 401) {
                localStorage.clear();
            }
            throw new Error(data.message || 'Something went wrong');
        }
    },
};

export default apiRequester;
