<?php
// api/utils/Database.php

namespace Api\Utils;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    private function __construct() {
    }

    public static function getConnection() {
        if (self::$instance === null) {
            $host = 'db';
            $db   = 'joyjet_users';
            $user = 'joyjet';
            $pass = 'joyjet123';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$instance;
    }
}
