<?php
// api/utils/RequestValidator.php

namespace Api\Utils;

class RequestValidator {
    public static function validateId($id) {
        return is_numeric($id) && $id > 0;
    }

    public static function validateUserInput($data, $isUpdate = false) {

        return true; 
    }
}
