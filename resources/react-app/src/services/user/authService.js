import apiRequester from '../apiRequester';
import {API_PATH} from '../../constants/API_PATH';

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
    isLogged(){
        const token = localStorage.getItem('token');
        return !!token;

    }
};

export default authService;
