<?php

class ResponseHandler {
    public static function sendResponse($statusCode = 200, $data = null) {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        // Check if $data is an object and has the jsonSerialize method.
        if (is_object($data) && method_exists($data, 'jsonSerialize')) {
            echo json_encode($data->jsonSerialize());
        } else {
            // If $data is not an object or doesn't have the jsonSerialize method,
            // pass it directly to json_encode.
            echo json_encode($data);
        }

        exit;
    }
}
