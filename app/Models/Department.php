<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Department extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM departments ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function create($name) {
        $stmt = $this->db->prepare("INSERT INTO departments (name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM departments WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
