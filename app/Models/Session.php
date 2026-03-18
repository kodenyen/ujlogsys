<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Session extends Model {
    public function getAllWithDept() {
        $stmt = $this->db->query("
            SELECT s.*, d.name as dept_name 
            FROM sessions s 
            JOIN departments d ON s.department_id = d.id 
            ORDER BY d.name ASC, s.name ASC
        ");
        return $stmt->fetchAll();
    }

    public function create($name, $dept_id) {
        $stmt = $this->db->prepare("INSERT INTO sessions (name, department_id) VALUES (?, ?)");
        return $stmt->execute([$name, $dept_id]);
    }

    public function getByDept($dept_id) {
        $stmt = $this->db->prepare("SELECT * FROM sessions WHERE department_id = ?");
        $stmt->execute([$dept_id]);
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function update($id, $name, $dept_id) {
        $stmt = $this->db->prepare("UPDATE sessions SET name = ?, department_id = ? WHERE id = ?");
        return $stmt->execute([$name, $dept_id, $id]);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM sessions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
