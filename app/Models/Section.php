<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Section extends Model {
    public function getAllWithDept() {
        $stmt = $this->db->query("
            SELECT s.*, d.name as dept_name 
            FROM sections s 
            JOIN departments d ON s.department_id = d.id 
            ORDER BY d.name ASC, s.name ASC
        ");
        return $stmt->fetchAll();
    }

    public function create($name, $dept_id) {
        $stmt = $this->db->prepare("INSERT INTO sections (name, department_id) VALUES (?, ?)");
        return $stmt->execute([$name, $dept_id]);
    }

    public function getByDept($dept_id) {
        $stmt = $this->db->prepare("SELECT * FROM sections WHERE department_id = ?");
        $stmt->execute([$dept_id]);
        return $stmt->fetchAll();
    }
}
