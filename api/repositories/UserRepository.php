<?php
// api/repositories/UserRepository.php

namespace Api\Repositories;

use Api\Utils\Database;
use PDOException;

class UserRepository {
    private $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function findById($id) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();

            $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($userData) {
                return new \Api\Models\User(
                    $userData['id'],
                    $userData['username'],
                    $userData['email'],
                );
            }
            return null;

        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function findAll() {
        try {
            $stmt = $this->connection->query("SELECT id, username, email FROM users");
            return $stmt->fetchAll(\PDO::FETCH_FUNC, function ($id, $name, $email) {
                return new \Api\Models\User($id, $name, $email);
            });

        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function create(array $userData) {
        try {
            $stmt = $this->connection->prepare("INSERT INTO users (username, email) VALUES (:username, :email)");

            $stmt->bindValue(':username', $userData['username']);
            $stmt->bindValue(':email', $userData['email']);

            $stmt->execute();

            return $this->findById($this->connection->lastInsertId());

        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function update($id, array $userData) {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");

            $stmt->bindParam(':id', $id);
            $stmt->bindValue(':username', $userData['username']);
            $stmt->bindValue(':email', $userData['email']);

            if (isset($userData['password'])) {
                $stmt->bindValue(':password', password_hash($userData['password'], PASSWORD_DEFAULT));
                $stmt = $this->connection->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id");
            }

            $stmt->execute();

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            throw $e;
        }
    }
}
