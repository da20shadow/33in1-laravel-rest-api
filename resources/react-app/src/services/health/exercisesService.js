import apiRequester from "../apiRequester";

const exerciseService = {
    async add(exerciseData) {
        return apiRequester.post(`${API_PATH.ADD_EXERCISE}`,exerciseData);
    },
    async update(exerciseId,exerciseData) {
        return apiRequester.patch(`${API_PATH.UPDATE_EXERCISE}/${exerciseId}`,exerciseData);
    },
    async remove(exerciseId) {
        return apiRequester.remove(`${API_PATH.DELETE_EXERCISE}/${exerciseId}`);
    },
    async getById(exerciseId) {
        return apiRequester.get(`${API_PATH.EXERCISE_DETAILS}/${exerciseId}`);
    },
    async getAll() {
        return apiRequester.get(`${API_PATH.EXERCISES}`);
    },
};

export default exerciseService;
