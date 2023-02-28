import apiRequester from '../../shared/services/apiRequester';
import {USER_API_PATHS} from "../constants/userApiPath";

const authService = {
    async register(userData) {
        return apiRequester.post(`${USER_API_PATHS.REGISTER}`,userData);
    },
    async login(userData) {
        return apiRequester.post(`${USER_API_PATHS.LOGIN}`, userData);
    },
    async logout(userData) {
        return apiRequester.post(`${USER_API_PATHS.LOGOUT}`, userData);
    }
};

export default authService;
