<?php
// api/controllers/UserController.php

namespace Api\Controllers;

use Api\Services\UserService;
use Api\Utils\ResponseHandler;
use Api\Utils\RequestValidator;

require_once __DIR__ . '/../utils/RequestValidator.php';

class UserController {
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function getUser($id) {
        if (!RequestValidator::validateId($id)) {
            return ['status' => 400, 'data' => ['error' => 'Invalid ID format']];
        }

        $user = $this->userService->findById($id);
        
        if ($user) {
            return ['status' => 200, 'data' => $user];
        } else {
            return ['status' => 404, 'data' => ['error' => 'User not found']];
        }
    }

    public function getAllUsers() {
        $users = $this->userService->findAll();
        return ['status' => 200, 'data' => $users];
    }

    public function createUser($jsonData) {
        $data = json_decode($jsonData, true);
        if (!RequestValidator::validateUserInput($data)) {
            return ['status' => 400, 'data' => ['error' => 'Invalid user data']];
        }

        $createdUser = $this->userService->create($data);
        return ['status' => 201, 'data' => $createdUser];
    }

    public function updateUser($id, $jsonData) {
        if (!RequestValidator::validateId($id)) {
            return ['status' => 400, 'data' => ['error' => 'Invalid ID format']];
        }

        $data = json_decode($jsonData, true);
        if (!RequestValidator::validateUserInput($data, true)) {
            return ['status' => 400, 'data' => ['error' => 'Invalid user data']];
        }

        $updatedUser = $this->userService->update($id, $data);
        if ($updatedUser) {
            return ['status' => 200, 'data' => $updatedUser];
        } else {
            return ['status' => 404, 'data' => ['error' => 'User not found']];
        }
    }
}
