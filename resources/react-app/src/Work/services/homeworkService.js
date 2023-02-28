import apiRequester from "../../shared/services/apiRequester";
import {API_PATH} from '../../shared/constants/API_PATH';
const homeworkService = {
    async add(homeworkData) {
        return apiRequester.post(`${API_PATH.ADD_HOMEWORK}`,homeworkData);
    },
    async update(homeworkId,homeworkData) {
        return apiRequester.patch(`${API_PATH.UPDATE_HOMEWORK}/${homeworkId}`,homeworkData);
    },
    async remove(homeworkId) {
        return apiRequester.remove(`${API_PATH.DELETE_HOMEWORK}/${homeworkId}`);
    },
    async getById(homeworkId) {
        return apiRequester.get(`${API_PATH.HOMEWORK_DETAILS}/${homeworkId}`);
    },
    async getAll() {
        return apiRequester.get(`${API_PATH.HOMEWORK}`);
    },
};

export default homeworkService;
