import apiRequester from "../apiRequester";
import {API_PATH} from '../../constants/API_PATH';
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
    async getAllTestOne() {
        return apiRequester.get(`${API_PATH.TESTS}`);
    },
};

export default waterService;
