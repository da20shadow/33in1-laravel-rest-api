import apiRequester from '../../shared/services/apiRequester';
import {USER_API_PATHS} from "../constants/userApiPath";
const userService = {
    async get() {
        return apiRequester.get(`${USER_API_PATHS.USER_PROFILE}`);
    },
    async update() {
        return apiRequester.patch(`${USER_API_PATHS.UPDATE_USER_PROFILE}`);
    },
    async remove() {
        return apiRequester.remove(`${USER_API_PATHS.DELETE_USER_PROFILE}`);
    },
};

export default userService;
