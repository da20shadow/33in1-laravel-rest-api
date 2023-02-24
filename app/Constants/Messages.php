<?php

namespace App\Constants;

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
    const DELETED_WORKOUT_LOG_SUCCESS = 'Successfully Deleted Workout Log.';
    const DELETED_WORKOUT_LOG_FAILURE = 'Unable to Deleted Workout Log.';


    //DEFAULT Messages
    const DEFAULT_ERROR_MESSAGE = 'Something went wrong. Please try again later.';
    const NO_RIGHTS = "You have no rights to complete this operation!";

}
