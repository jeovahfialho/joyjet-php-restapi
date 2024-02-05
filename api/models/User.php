<?php

namespace Api\Models;

use Api\Utils\Database;

class User {
    private $db;
    private $id;
    private $name;
    private $email;

    public function __construct($id, $name, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->db = Database::getConnection();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $data['username'], $data['email']);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $data['username'], $data['email'], $id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            // Inclua outras propriedades que deseja expor
        ];
    }
}
