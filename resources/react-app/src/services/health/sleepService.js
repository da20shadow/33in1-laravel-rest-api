import apiRequester from "../apiRequester";
import {API_PATH} from '../../constants/API_PATH';
const sleepService = {
    async add(sleepData) {
        return apiRequester.post(`${API_PATH.ADD_SLEEP_LOG}`,sleepData);
    },
    async start() {
        return apiRequester.post(`${API_PATH.START_SLEEP_LOG}`);
    },
    async stop() {
        return apiRequester.post(`${API_PATH.STOP_SLEEP_LOG}`);
    },
    //TODO:
    // async startNap() {
    //     return apiRequester.post(`${API_PATH.START_SLEEP_LOG}`);
    // },
    // async stopNap() {
    //     return apiRequester.post(`${API_PATH.STOP_SLEEP_LOG}`);
    // },
    async update(sleepId,sleepData) {
        return apiRequester.patch(`${API_PATH.UPDATE_SLEEP_LOG}/${sleepId}`,sleepData);
    },
    async remove(sleepId) {
        return apiRequester.remove(`${API_PATH.DELETE_SLEEP_LOG}/${sleepId}`);
    },
    async clearIfOldActive() {
        return apiRequester.get(`${API_PATH.CLEAR_SLEEP_LOGS}`);
    },
    async getById(sleepId) {
        return apiRequester.get(`${API_PATH.SLEEP_LOG_DETAILS}/${sleepId}`);
    },
    async getLastInProgress() {
        return apiRequester.get(`${API_PATH.SLEEP_LOG_LAST_IN_PROGRESS}`);
    },
    async getTodaySleepLog() {
        return apiRequester.get(`${API_PATH.SLEEP_LOG_TODAY}`);
    },
    async getAll() {
        return apiRequester.get(`${API_PATH.SLEEP_LOGS}`);
    },
};

export default sleepService;
