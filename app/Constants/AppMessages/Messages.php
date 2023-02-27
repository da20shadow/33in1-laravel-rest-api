<?php

namespace App\Constants\AppMessages;

class Messages
{

    //User
    const LOGIN_SUCCESS = 'Влязохте усшено.';
    const LOGOUT_SUCCESS = 'Излязохте успешно.';
    const REGISTER_SUCCESS = 'Успешна регистрация.';
    const UPDATE_PROFILE_SUCCESS = 'Успешно редактирахте профила си.';
    const DELETED_PROFILE_SUCCESS = 'Успешно изтрихте профила си.';

    const BAD_CREDENTIALS = 'Грешна парола или имейл.';
    const EMAIL_EXIST = 'Потребител с този имейл вече е регистриран.';
    const USER_NOT_FOUND = 'Потребителят не е намерен.';

    //Body Composition
    const ADDED_BODY_COMPOSITION_SUCCESS = 'Успешно добавихте данни за тялото си.';
    const UPDATED_BODY_COMPOSITION_SUCCESS = 'Успешно редактирахте данните за тялото си.';
    const BODY_COMPOSITION_EXIST = 'Вече сте добавили данни за тялото си.!';
    const NO_BODY_COMPOSITION = 'Не сте добавили данни за тялото!';

    //Exercises
    const EXERCISE_ADDED_SUCCESS = 'Успешно добавено упражнение.';
    const EXERCISE_ADDED_FAILURE = 'Добавянето на упражнение е неуспешно.';
    const EXERCISE_UPDATED_SUCCESS = 'Упражнението е редактирано успешно.';
    const EXERCISE_UPDATED_FAILURE = 'Редактирането на упражнението беше неуспешно.';
    const EXERCISE_EXIST = 'Упражнение с това име вече е добавено.';
    const EXERCISE_NOT_EXIST = 'Упражнението не е намерено.';
    const NO_EXERCISES = 'Все още няма упражнения.';
    const DELETED_EXERCISE_SUCCESS = 'Успешно изтрихте упражнение.';
    const DELETED_EXERCISE_FAILURE = 'Опита за изтриване на упражнението е неуспешен.';

    //Workout Logs
    const ADD_WORKOUT_LOG_SUCCESS = 'Успешно добваихте тренировка.';
    const ADD_WORKOUT_LOG_FAILURE = 'Добавнето на тренировка беше неуспешно.';
    const UPDATE_WORKOUT_LOG_SUCCESS = 'Усепешно редактирахте тренировка.';
    const UPDATE_WORKOUT_LOG_FAILURE = 'Редактирането на тренировката е неуспешно.';
    const DELETED_WORKOUT_LOG_SUCCESS = 'Успешно изтрита тренировка.';
    const DELETED_WORKOUT_LOG_FAILURE = 'Опита да изтриете тренировката беше неуспешен.';
    const WORKOUT_LOG_NOT_EXIST = 'Тренировката не съществува.';

    //Homework
    const NO_HOMEWORK = 'No homework added yet.';
    const HOMEWORK_NOT_EXIST = 'Such homework not exist.';
    const HOMEWORK_EXIST = 'Such homework already exists.';
    const HOMEWORK_ADDED_SUCCESS = 'Homework added successfully.';
    const HOMEWORK_ADDED_FAILURE = 'Unable to add homework.';
    const HOMEWORK_UPDATE_SUCCESS = 'Homework updated successfully.';
    const HOMEWORK_UPDATE_FAILURE = 'Unable to update homework.';
    const DELETE_HOMEWORK_SUCCESS = 'Homework deleted successfully.';
    const DELETE_HOMEWORK_FAILURE = 'Unable to delete homework.';

    //Homework Logs
    const HOMEWORK_LOG_NOT_EXIST = 'Such homework log not exist.';
    const ADD_HOMEWORK_LOG_SUCCESS = 'Successfully added new homework log!';
    const ADD_HOMEWORK_LOG_FAILURE = 'Unable to add homework log!';
    const UPDATE_HOMEWORK_LOG_SUCCESS = 'Successfully updated new homework log!';
    const UPDATE_HOMEWORK_LOG_FAILURE = 'Unable to update homework log!';
    const DELETE_HOMEWORK_LOG_SUCCESS = 'Successfully deleted homework log!';
    const DELETE_HOMEWORK_LOG_FAILURE = 'Unable to delete homework log!';

    //Water
    const WATER_LOGS_NOT_EXIST = 'Няма данни за водата в този период от време.';
    const ADD_WATER_LOG_SUCCESS = 'Успешно добваихте вода.';
    const ADD_WATER_LOG_FAILURE = 'Опита да добавите вода беше неуспешен.';
    const UPDATE_WATER_LOG_SUCCESS = 'Успешно редактирахте прием на вода.';
    const UPDATE_WATER_LOG_FAILURE = 'Опита да редактирате прием на вода е неуспешен.';
    const DELETE_WATER_LOG_SUCCESS = 'Успешно изтрихте прием на вода.';
    const DELETE_WATER_LOG_FAILURE = 'Опита да изтриете прием на вода е неуспешен.';

    //Food
    const FOOD_EXIST = 'Food with this name already added!';
    const FOOD_NOT_FOUND = 'Not Found Food!';
    const ADD_FOOD_SUCCESS = 'Successfully added food.';
    const ADD_FOOD_FAILURE = 'Unable to add food.';
    const UPDATE_FOOD_SUCCESS = 'Successfully updated food.';
    const UPDATE_FOOD_FAILURE = 'Unable to update food.';
    const DELETE_FOOD_SUCCESS = 'Successfully deleted food.';
    const DELETE_FOOD_FAILURE = 'Unable to delete food.';

    //Meal Logs
    const MEAL_LOG_EXIST = 'Food with this name already added!';
    const MEAL_LOG_NOT_FOUND = 'Not Found Food!';
    const ADD_MEAL_LOG_SUCCESS = 'Successfully added food.';
    const ADD_MEAL_LOG_FAILURE = 'Unable to add food.';
    const UPDATE_MEAL_LOG_SUCCESS = 'Successfully updated food.';
    const UPDATE_MEAL_LOG_FAILURE = 'Unable to update food.';
    const DELETE_MEAL_LOG_SUCCESS = 'Successfully deleted food.';
    const DELETE_MEAL_LOG_FAILURE = 'Unable to delete food.';

    //Sleep Log
    const SLEEP_LOG_EXIST = 'Запис за съня е вече добавен!';
    const SLEEP_LOG_NOT_FOUND = 'Записа за съня не е намерен!';
    const ADD_SLEEP_LOG_SUCCESS = 'Успешно добавихте запис за сън.';
    const ADD_SLEEP_LOG_FAILURE = 'Добавянето на запис за сън е неуспешно.';
    const UPDATE_SLEEP_LOG_SUCCESS = 'Успешно редактирахте запис за сън.';
    const UPDATE_SLEEP_LOG_FAILURE = 'Опита да редактирате запис за сън е неуспешен.';
    const DELETE_SLEEP_LOG_SUCCESS = 'Успешно изтрихте запис за сън.';
    const DELETE_SLEEP_LOG_FAILURE = 'Опита да изтриете запис за сън е неуспешен.';
    const SLEEP_LOG_STARTED_SUCCESS = 'Успешно тартирахте сън zzZZ.';
    const LAST_SLEEP_LOG_NOT_FOUND = 'Няма сън който да е в прогресс.';

    //DEFAULT Messages
    const DEFAULT_ERROR_MESSAGE = 'Нещо се обърка. Моля опитайте пак.';
    const NO_RIGHTS = "You have no rights to complete this operation!";

}
