import apiRequester from "../apiRequester";

const waterService = {
    async add(waterData) {
        return apiRequester.post(`${API_PATH.ADD_WATER}`,waterData);
    },
    async update(waterId,waterData) {
        return apiRequester.patch(`${API_PATH.UPDATE_WATER}/${waterId}`,waterData);
    },
    async remove(waterId) {
        return apiRequester.remove(`${API_PATH.DELETE_WATER}/${waterId}`);
    },
    async getById(waterId) {
        return apiRequester.get(`${API_PATH.WATER_DETAILS}/${waterId}`);
    },
    async getAll() {
        return apiRequester.get(`${API_PATH.WATER}`);
    },
};

export default waterService;
