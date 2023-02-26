import apiRequester from '../apiRequester';

const bodyCompositionService = {
    async add(bodyCompositionData) {
        return apiRequester.post(`${API_PATH.ADD_BODY_COMPOSITION}`,bodyCompositionData);
    },
    async update() {
        return apiRequester.patch(`${API_PATH.UPDATE_BODY_COMPOSITION}`);
    },
    async get() {
        return apiRequester.get(`${API_PATH.BODY_COMPOSITION}`);
    },
};

export default bodyCompositionService;
