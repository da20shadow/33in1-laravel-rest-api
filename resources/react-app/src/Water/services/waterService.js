import {WATER_API_PATHS} from "../constants";
import {apiRequester} from "../../shared";
export default {
    async add(waterData) {
        return apiRequester.post(`${WATER_API_PATHS.ADD_WATER}`,waterData);
    },
    async update(waterId,waterData) {
        return apiRequester.patch(`${WATER_API_PATHS.UPDATE_WATER}/${waterId}`,waterData);
    },
    async remove(waterId) {
        return apiRequester.remove(`${WATER_API_PATHS.DELETE_WATER}/${waterId}`);
    },
    async getById(waterId) {
        return apiRequester.get(`${WATER_API_PATHS.WATER_DETAILS}/${waterId}`);
    },
    async getTodays() {
        return apiRequester.get(`${WATER_API_PATHS.WATER_TODAY}`);
    },
    async getAll() {
        return apiRequester.get(`${WATER_API_PATHS.WATER}`);
    },
    async getAllTestOne() {
        return apiRequester.get(`${WATER_API_PATHS.TESTS}`);
    },
};
