<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class LogActivityType extends Model {
    public function getAllWithDept() {
        $stmt = $this->db->query("
            SELECT t.*, d.name as dept_name 
            FROM log_activity_types t 
            JOIN departments d ON t.department_id = d.id 
            ORDER BY d.name ASC, t.name ASC
        ");
        return $stmt->fetchAll();
    }

    public function create($name, $dept_id) {
        $stmt = $this->db->prepare("INSERT INTO log_activity_types (name, department_id) VALUES (?, ?)");
        $stmt->execute([$name, $dept_id]);
        return $this->db->lastInsertId();
    }

    public function assignField($type_id, $field_id) {
        $stmt = $this->db->prepare("INSERT INTO log_activity_type_fields (type_id, field_id) VALUES (?, ?)");
        return $stmt->execute([$type_id, $field_id]);
    }

    public function getFields($type_id) {
        $stmt = $this->db->prepare("
            SELECT f.* 
            FROM log_activity_fields f 
            JOIN log_activity_type_fields tf ON f.id = tf.field_id 
            WHERE tf.type_id = ?
        ");
        $stmt->execute([$type_id]);
        return $stmt->fetchAll();
    }
}
