import apiRequester from "../../shared/services/apiRequester";
import {SLEEP_API_PATHS} from "../constants/sleepApiPath";
const sleepService = {
    async add(sleepData) {
        return apiRequester.post(`${SLEEP_API_PATHS.ADD_SLEEP_LOG}`,sleepData);
    },
    async start() {
        return apiRequester.post(`${SLEEP_API_PATHS.START_SLEEP_LOG}`);
    },
    async stop() {
        return apiRequester.post(`${SLEEP_API_PATHS.STOP_SLEEP_LOG}`);
    },
    //TODO:
    // async startNap() {
    //     return apiRequester.post(`${API_PATH.START_SLEEP_LOG}`);
    // },
    // async stopNap() {
    //     return apiRequester.post(`${API_PATH.STOP_SLEEP_LOG}`);
    // },
    async update(sleepId,sleepData) {
        return apiRequester.patch(`${SLEEP_API_PATHS.UPDATE_SLEEP_LOG}/${sleepId}`,sleepData);
    },
    async remove(sleepId) {
        return apiRequester.remove(`${SLEEP_API_PATHS.DELETE_SLEEP_LOG}/${sleepId}`);
    },
    async clearIfOldActive() {
        return apiRequester.get(`${SLEEP_API_PATHS.CLEAR_SLEEP_LOGS}`);
    },
    async getById(sleepId) {
        return apiRequester.get(`${SLEEP_API_PATHS.SLEEP_LOG_DETAILS}/${sleepId}`);
    },
    async getLastInProgress() {
        return apiRequester.get(`${SLEEP_API_PATHS.SLEEP_LOG_LAST_IN_PROGRESS}`);
    },
    async getTodaySleepLog() {
        return apiRequester.get(`${SLEEP_API_PATHS.SLEEP_LOG_TODAY}`);
    },
    async getAll() {
        return apiRequester.get(`${SLEEP_API_PATHS.SLEEP_LOGS}`);
    },
};

export default sleepService;
