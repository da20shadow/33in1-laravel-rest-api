import apiRequester from '../apiRequester';

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
