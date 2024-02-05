<?php
// api/services/UserService.php

namespace Api\Services;

use Api\Repositories\UserRepository;

class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function findById($id) {
        return $this->userRepository->findById($id);
    }

    public function findAll() {
        return $this->userRepository->findAll();
    }

    public function create(array $userData) {
        $this->validateUserData($userData);

        return $this->userRepository->create($userData);
    }

    public function update($id, array $userData) {
        $this->validateUserData($userData, true);

        return $this->userRepository->update($id, $userData);
    }

    private function validateUserData(array $data, $isUpdate = false) {

        if (empty($data['username'])) {
            throw new \InvalidArgumentException('O nome é obrigatório.');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('O e-mail é inválido.');
        }

    }
}
