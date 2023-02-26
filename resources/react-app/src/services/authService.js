import apiRequester from './apiRequester';

const authService = {
    async register(userData) {
        return apiRequester.post(`${API_PATH.REGISTER}`,userData);
    },
    async login(userData) {
        return apiRequester.post(`${API_PATH.LOGIN}`, userData);
    },
    async logout(userData) {
        return apiRequester.post(`${API_PATH.LOGOUT}`, userData);
    },
};

export default authService;
