import apiRequester from '../apiRequester';
import {API_PATH} from '../../constants/API_PATH';

const bodyCompositionService = {
    async add(bodyCompositionData) {
        return apiRequester.post(`${API_PATH.ADD_BODY_COMPOSITION}`,bodyCompositionData);
    },
    async update(bodyComposition) {
        return apiRequester.patch(`${API_PATH.UPDATE_BODY_COMPOSITION}`,bodyComposition);
    },
    async get() {
        return apiRequester.get(`${API_PATH.BODY_COMPOSITION}`);
    },
};

export default bodyCompositionService;
