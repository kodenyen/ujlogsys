<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class LogActivityField extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM log_activity_fields ORDER BY field_label ASC");
        return $stmt->fetchAll();
    }

    public function create($label, $type, $is_required = 1) {
        $stmt = $this->db->prepare("INSERT INTO log_activity_fields (field_label, field_type, is_required) VALUES (?, ?, ?)");
        return $stmt->execute([$label, $type, $is_required]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM log_activity_fields WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
