import apiRequester from "../apiRequester";

const foodService = {
    async add(foodData) {
        return apiRequester.post(`${API_PATH.ADD_FOOD}`,foodData);
    },
    async update(foodId,foodData) {
        return apiRequester.patch(`${API_PATH.UPDATE_FOOD}/${foodId}`,foodData);
    },
    async remove(foodId) {
        return apiRequester.remove(`${API_PATH.DELETE_FOOD}/${foodId}`);
    },
    async getById(foodId) {
        return apiRequester.get(`${API_PATH.FOOD_DETAILS}/${foodId}`);
    },
    async getAll() {
        return apiRequester.get(`${API_PATH.FOODS}`);
    },
};

export default foodService;
