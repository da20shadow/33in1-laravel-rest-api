import apiRequester from "../../shared/services/apiRequester";
import {API_PATH} from '../../shared/constants/API_PATH';
const mealLogService = {
    async add(mealLogData) {
        return apiRequester.post(`${API_PATH.ADD_MEAL_LOG}`,mealLogData);
    },
    async update(mealLogId,mealLogData) {
        return apiRequester.patch(`${API_PATH.UPDATE_MEAL_LOG}/${mealLogId}`,mealLogData);
    },
    async remove(mealLogId) {
        return apiRequester.remove(`${API_PATH.DELETE_MEAL_LOG}/${mealLogId}`);
    },
    async getById(mealLogId) {
        return apiRequester.get(`${API_PATH.MEAL_LOG_DETAILS}/${mealLogId}`);
    },
    async getAll() {
        return apiRequester.get(`${API_PATH.MEAL_LOGS}`);
    },
};

export default mealLogService;
