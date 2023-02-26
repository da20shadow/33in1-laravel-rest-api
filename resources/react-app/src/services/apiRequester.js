const apiRequester = {
    baseUrl: 'http://localhost:8000/api',
    async get(path) {
        const response = await fetch(`${this.baseUrl}/${path}`, {
            method: 'GET',
            headers: this.getHeaders(),
        });
        return this.handleResponse(response);
    },
    async post(path, body) {
        const response = await fetch(`${this.baseUrl}/${path}`, {
            method: 'POST',
            headers: this.getHeaders(),
            body: JSON.stringify(body),
        });
        return this.handleResponse(response);
    },
    getHeaders() {
        const headers = {
            'Content-Type': 'application/json',
        };
        const token = localStorage.getItem('token');
        if (token) {
            headers.Authorization = `Bearer ${token}`;
        }
        return headers;
    },
    async handleResponse(response) {
        const data = await response.json();
        if (response.ok) {
            return data;
        } else {
            throw new Error(data.message || 'Something went wrong');
        }
    },
};

export default apiRequester;
