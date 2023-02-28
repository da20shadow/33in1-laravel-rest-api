import apiRequester from '../../shared/services/apiRequester';
import {USER_API_PATHS} from "../constants/userApiPath";

const bodyCompositionService = {
    async add(bodyCompositionData) {
        return apiRequester.post(`${USER_API_PATHS.ADD_BODY_COMPOSITION}`,bodyCompositionData);
    },
    async update(bodyComposition) {
        return apiRequester.patch(`${USER_API_PATHS.UPDATE_BODY_COMPOSITION}`,bodyComposition);
    },
    async get() {
        return apiRequester.get(`${USER_API_PATHS.BODY_COMPOSITION}`);
    },
};

export default bodyCompositionService;
