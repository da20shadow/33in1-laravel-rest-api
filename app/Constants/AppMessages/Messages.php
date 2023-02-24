<?php

namespace App\Constants\AppMessages;

class Messages
{

    //User
    const LOGIN_SUCCESS = 'Successfully logged in.';
    const LOGOUT_SUCCESS = 'Successfully logged out.';
    const REGISTER_SUCCESS = 'Successfully registered.';
    const UPDATE_PROFILE_SUCCESS = 'Profile updated successfully.';
    const DELETED_PROFILE_SUCCESS = 'Successfully Deleted Account.';

    const BAD_CREDENTIALS = 'Invalid Email or Password.';
    const EMAIL_EXIST = 'User with this email already registered.';
    const USER_NOT_FOUND = 'User not found.';

    //Body Composition
    const ADDED_BODY_COMPOSITION_SUCCESS = 'Successfully added body composition';
    const UPDATED_BODY_COMPOSITION_SUCCESS = 'Successfully updated body composition';
    const BODY_COMPOSITION_EXIST = 'Body composition already added!';

    //Exercises
    const EXERCISE_ADDED_SUCCESS = 'Successfully added new exercise.';
    const EXERCISE_ADDED_FAILURE = 'Unable to added new exercise.';
    const EXERCISE_UPDATED_SUCCESS = 'Successfully updated exercise.';
    const EXERCISE_UPDATED_FAILURE = 'Unable to updated exercise.';
    const EXERCISE_EXIST = 'Exercise with such name already added.';
    const EXERCISE_NOT_EXIST = 'Exercise not found.';
    const NO_EXERCISES = 'There are no exercises yet.';
    const DELETED_EXERCISE_SUCCESS = 'Successfully Deleted Exercise.';
    const DELETED_EXERCISE_FAILURE = 'Unable to Deleted Exercise.';

    //Workout Logs
    const ADD_WORKOUT_LOG_SUCCESS = 'Successfully added workout log.';
    const ADD_WORKOUT_LOG_FAILURE = 'Unable to added workout log.';
    const UPDATE_WORKOUT_LOG_SUCCESS = 'Successfully updated workout log.';
    const UPDATE_WORKOUT_LOG_FAILURE = 'Unable to update workout log.';
    const DELETED_WORKOUT_LOG_SUCCESS = 'Successfully Deleted Workout Log.';
    const DELETED_WORKOUT_LOG_FAILURE = 'Unable to Deleted Workout Log.';
    const WORKOUT_LOG_NOT_EXIST = 'Workout Log not exist.';

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

    //DEFAULT Messages
    const DEFAULT_ERROR_MESSAGE = 'Something went wrong. Please try again later.';
    const NO_RIGHTS = "You have no rights to complete this operation!";

}
