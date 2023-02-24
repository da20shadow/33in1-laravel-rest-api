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


    //DEFAULT Messages
    const DEFAULT_ERROR_MESSAGE = 'Something went wrong. Please try again later.';
    const NO_RIGHTS = "You have no rights to complete this operation!";

}
