<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model {
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO users (full_name, username, password_hash, role, matric_staff_id, photo, dept_id) 
                VALUES (:full_name, :username, :password_hash, :role, :matric_staff_id, :photo, :dept_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getAllByRole($role) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = ?");
        $stmt->execute([$role]);
        return $stmt->fetchAll();
    }
}
