import apiRequester from "../apiRequester";
import {API_PATH} from '../../constants/API_PATH';
const workoutLogService = {
    async add(workoutLogData) {
        return apiRequester.post(`${API_PATH.ADD_WORKOUT_LOG}`,workoutLogData);
    },
    async update(workoutLogId,workoutLogData) {
        return apiRequester.patch(`${API_PATH.UPDATE_WORKOUT_LOG}/${workoutLogId}`,workoutLogData);
    },
    async remove(workoutLogId) {
        return apiRequester.remove(`${API_PATH.DELETE_WORKOUT_LOG}/${workoutLogId}`);
    },
    async getById(workoutLogId) {
        return apiRequester.get(`${API_PATH.WORKOUT_LOGS}/${workoutLogId}`);
    },
    async getAll() {
        return apiRequester.get(`${API_PATH.WORKOUT_LOGS}`);
    },
};

export default workoutLogService;
