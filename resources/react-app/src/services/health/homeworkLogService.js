import apiRequester from "../apiRequester";

const homeworkLogService = {
    async add(homeworkLogData) {
        return apiRequester.post(`${API_PATH.ADD_HOMEWORK_LOG}`,homeworkLogData);
    },
    async update(homeworkLogId,homeworkLogData) {
        return apiRequester.patch(`${API_PATH.UPDATE_HOMEWORK_LOG}/${homeworkLogId}`,homeworkLogData);
    },
    async remove(homeworkLogId) {
        return apiRequester.remove(`${API_PATH.DELETE_HOMEWORK_LOG}/${homeworkLogId}`);
    },
    async getById(homeworkLogId) {
        return apiRequester.get(`${API_PATH.HOMEWORK_LOG_DETAILS}/${homeworkLogId}`);
    },
    async getAllWithDetails() {
        return apiRequester.get(`${API_PATH.HOMEWORK_LOG_DETAILS}`);
    },
    async getAll() {
        return apiRequester.get(`${API_PATH.HOMEWORK_LOGS}`);
    },
};

export default homeworkLogService;
