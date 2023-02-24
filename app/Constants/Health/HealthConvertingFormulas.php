<?php

namespace App\Constants\Health;

class HealthConvertingFormulas
{
//An average step length for females is – height X 0.413, and for males, it is – height x 0.415 (height unit: cm).
    const AVG_FEMALE_STEP_LENGTH = 0.413;
    const AVG_MALE_STEP_LENGTH = 0.415;
//Formula to convert height to step length height X 0.413|0.415 for female|male
    public static function calculateStepLength(string $gender,float $height): float|int
    {
        if ($gender == 'MALE') {
            return $height * self::AVG_MALE_STEP_LENGTH;
        }else if ($gender == 'FEMALE') {
            return $height * self::AVG_FEMALE_STEP_LENGTH;
        }
        return $height * 0.414;
    }

//METs x 3.5 x Weight (kg) / 200 = Calories burned per minute.
    public static function calculateBurnedCaloriesPerMinute(float $MET, float $personKg): float|int
    {
        return (($MET * 3.5) * $personKg) / 200; //Burned calories per minute
    }
//Cal. burned per min / (60 min / time for 1 rep) = Calories burned per rep
    public static function calculateBurnedCaloriesPerRep(float $MET, float $personKg, int $secondsForOneRep): float|int
    {
        $calPerMinute = (($MET * 3.5) * $personKg) / 200; //Burned calories per minute
        return $calPerMinute / (60 / $secondsForOneRep); //Burned calories per rep
    }

}
