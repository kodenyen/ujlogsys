<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Attendance;

class ConsultantController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Consultant') {
            $this->redirect('/login');
        }
    }

    public function index() {
        $attendanceModel = new Attendance();
        $logModel = new \App\Models\LogActivityEntry();
        $db = \App\Core\Database::getInstance()->getConnection();

        // Get monthly activity for the graph
        $graphQuery = $db->prepare("
            SELECT DATE_FORMAT(attendance_date, '%b') as month, COUNT(*) as count 
            FROM attendance_records 
            WHERE consultant_id = ? AND is_confirmed = 1
            GROUP BY month ORDER BY attendance_date DESC LIMIT 6
        ");
        $graphQuery->execute([$_SESSION['user_id']]);
        
        $this->render('consultant/dashboard', [
            'title' => 'Consultant Dashboard',
            'pending_attendance' => $attendanceModel->getPendingConsultantConfirmations($_SESSION['user_id']),
            'pending_logs' => $logModel->getPendingApprovals($_SESSION['user_id']),
            'stats' => [
                'total_verified' => $db->query("SELECT COUNT(*) FROM attendance_records WHERE consultant_id = {$_SESSION['user_id']} AND is_confirmed = 1")->fetchColumn(),
                'total_logs' => $db->query("SELECT COUNT(*) FROM log_activity_entries WHERE consultant_id = {$_SESSION['user_id']} AND is_approved = 1")->fetchColumn()
            ],
            'chart_data' => array_reverse($graphQuery->fetchAll())
        ]);
    }

    public function approveLog() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $log_id = $_POST['log_id'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByUsername($_SESSION['username']);

            if (password_verify($password, $user['password_hash'])) {
                $logModel = new \App\Models\LogActivityEntry();
                $logModel->approve($log_id);
                $this->redirect('/consultant/dashboard');
            } else {
                $this->redirect('/consultant/dashboard?error=invalid_password');
            }
        }
    }

    public function confirmAttendance() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $attendance_id = $_POST['attendance_id'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByUsername($_SESSION['username']);

            if (password_verify($password, $user['password_hash'])) {
                $attendanceModel = new Attendance();
                $attendanceModel->confirm($attendance_id);
                $this->redirect('/consultant/dashboard');
            } else {
                // In a real app, use session flash messages for errors
                $this->redirect('/consultant/dashboard?error=invalid_password');
            }
        }
    }

    public function confirmAllAttendance() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByUsername($_SESSION['username']);

            if (password_verify($password, $user['password_hash'])) {
                $attendanceModel = new Attendance();
                $pending = $attendanceModel->getPendingConsultantConfirmations($_SESSION['user_id']);
                foreach ($pending as $record) {
                    $attendanceModel->confirm($record['id']);
                }
                $this->redirect('/consultant/dashboard');
            } else {
                $this->redirect('/consultant/dashboard?error=invalid_password');
            }
        }
    }

    public function reports() {
        $userModel = new User();
        $deptModel = new \App\Models\Department();
        $sessionModel = new \App\Models\Session();
        $attendanceModel = new \App\Models\Attendance();
        $logModel = new \App\Models\LogActivityEntry();
        $settingModel = new \App\Models\Setting();

        $filters = [
            'student_id' => $_GET['student_id'] ?? null,
            'dept_id' => $_GET['dept_id'] ?? null,
            'session_id' => $_GET['session_id'] ?? null,
            'start_date' => $_GET['start_date'] ?? null,
            'end_date' => $_GET['end_date'] ?? null,
            'report_type' => $_GET['report_type'] ?? 'attendance',
            'consultant_id' => $_SESSION['user_id'] // Restrict to records for THIS consultant
        ];

        $data = [
            'title' => 'My Verified Reports',
            'students' => $userModel->getAllByRole('Student'),
            'departments' => $deptModel->getAll(),
            'sessions' => $sessionModel->getAllWithDept(),
            'filters' => $filters,
            'branding' => $settingModel->get()
        ];

        if ($filters['report_type'] === 'attendance') {
            $data['records'] = $attendanceModel->getFilteredReports($filters);
        } else {
            $data['records'] = $logModel->getFilteredLogs($filters);
        }

        // Using the same professional report view used by admin
        $this->render('admin/reports', $data);
    }
}
