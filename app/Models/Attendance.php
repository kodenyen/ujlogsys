<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Attendance extends Model {
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO attendance_records (student_id, section_id, consultant_id, attendance_date, status) 
            VALUES (:student_id, :section_id, :consultant_id, :attendance_date, :status)
        ");
        return $stmt->execute($data);
    }

    public function getStudentAttendance($student_id) {
        $stmt = $this->db->prepare("
            SELECT a.*, s.name as section_name, d.name as dept_name, u.full_name as consultant_name 
            FROM attendance_records a
            JOIN sections s ON a.section_id = s.id
            JOIN departments d ON s.department_id = d.id
            JOIN users u ON a.consultant_id = u.id
            WHERE a.student_id = ?
            ORDER BY a.attendance_date DESC
        ");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }

    public function getPendingConsultantConfirmations($consultant_id) {
        $stmt = $this->db->prepare("
            SELECT a.*, s.name as section_name, u.full_name as student_name 
            FROM attendance_records a
            JOIN sections s ON a.section_id = s.id
            JOIN users u ON a.student_id = u.id
            WHERE a.consultant_id = ? AND a.is_confirmed = 0
            ORDER BY a.attendance_date DESC
        ");
        $stmt->execute([$consultant_id]);
        return $stmt->fetchAll();
    }

    public function confirm($attendance_id) {
        $stmt = $this->db->prepare("
            UPDATE attendance_records 
            SET is_confirmed = 1, confirmed_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        return $stmt->execute([$attendance_id]);
    }

    public function getFilteredReports($filters = []) {
        $sql = "SELECT a.*, s.name as section_name, d.name as dept_name, u.full_name as student_name, c.full_name as consultant_name 
                FROM attendance_records a
                JOIN sections s ON a.section_id = s.id
                JOIN departments d ON s.department_id = d.id
                JOIN users u ON a.student_id = u.id
                JOIN users c ON a.consultant_id = c.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['student_id'])) {
            $sql .= " AND a.student_id = ?";
            $params[] = $filters['student_id'];
        }
        if (!empty($filters['dept_id'])) {
            $sql .= " AND s.department_id = ?";
            $params[] = $filters['dept_id'];
        }
        if (!empty($filters['start_date'])) {
            $sql .= " AND a.attendance_date >= ?";
            $params[] = $filters['start_date'];
        }
        if (!empty($filters['end_date'])) {
            $sql .= " AND a.attendance_date <= ?";
            $params[] = $filters['end_date'];
        }

        $sql .= " ORDER BY a.attendance_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
