<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class LogActivityEntry extends Model {
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO log_activity_entries (student_id, type_id, consultant_id, data_json) 
            VALUES (:student_id, :type_id, :consultant_id, :data_json)
        ");
        return $stmt->execute($data);
    }

    public function getStudentLogs($student_id) {
        $stmt = $this->db->prepare("
            SELECT e.*, t.name as type_name, u.full_name as consultant_name 
            FROM log_activity_entries e
            JOIN log_activity_types t ON e.type_id = t.id
            JOIN users u ON e.consultant_id = u.id
            WHERE e.student_id = ?
            ORDER BY e.id DESC
        ");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }

    public function getPendingApprovals($consultant_id) {
        $stmt = $this->db->prepare("
            SELECT e.*, t.name as type_name, u.full_name as student_name 
            FROM log_activity_entries e
            JOIN log_activity_types t ON e.type_id = t.id
            JOIN users u ON e.student_id = u.id
            WHERE e.consultant_id = ? AND e.is_approved = 0
            ORDER BY e.id DESC
        ");
        $stmt->execute([$consultant_id]);
        return $stmt->fetchAll();
    }

    public function approve($id) {
        $stmt = $this->db->prepare("
            UPDATE log_activity_entries 
            SET is_approved = 1, approved_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        return $stmt->execute([id]);
    }

    public function getFilteredLogs($filters = []) {
        $sql = "SELECT e.*, t.name as type_name, d.name as dept_name, u.full_name as student_name, c.full_name as consultant_name 
                FROM log_activity_entries e
                JOIN log_activity_types t ON e.type_id = t.id
                JOIN departments d ON t.department_id = d.id
                JOIN users u ON e.student_id = u.id
                JOIN users c ON e.consultant_id = c.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['student_id'])) {
            $sql .= " AND e.student_id = ?";
            $params[] = $filters['student_id'];
        }
        if (!empty($filters['consultant_id'])) {
            $sql .= " AND e.consultant_id = ?";
            $params[] = $filters['consultant_id'];
        }
        if (!empty($filters['dept_id'])) {
            $sql .= " AND t.department_id = ?";
            $params[] = $filters['dept_id'];
        }
        if (!empty($filters['type_id'])) {
            $sql .= " AND e.type_id = ?";
            $params[] = $filters['type_id'];
        }

        $sql .= " ORDER BY e.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
