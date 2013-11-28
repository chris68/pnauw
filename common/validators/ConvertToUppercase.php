<?php

namespace common\validators;
use yii\validators\Validator;

/**
 * Modifing validator to convert a string to uppercase
 */
class ConvertToUppercase extends Validator {
    public function validateAttribute($object,$attribute) {
        $object->$attribute = mb_strtoupper($object->$attribute, 'UTF-8');
    }
     
}
 
?>
