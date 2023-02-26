import apiRequester from '../apiRequester';
import {API_PATH} from '../../constants/API_PATH';
const userService = {
    async get() {
        return apiRequester.get(`${API_PATH.USER_PROFILE}`);
    },
    async update() {
        return apiRequester.patch(`${API_PATH.UPDATE_USER_PROFILE}`);
    },
    async remove() {
        return apiRequester.remove(`${API_PATH.DELETE_USER_PROFILE}`);
    },
};

export default userService;
