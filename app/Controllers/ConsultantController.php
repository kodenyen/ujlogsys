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
        
        $this->render('consultant/dashboard', [
            'title' => 'Consultant Dashboard',
            'pending_attendance' => $attendanceModel->getPendingConsultantConfirmations($_SESSION['user_id']),
            'pending_logs' => $logModel->getPendingApprovals($_SESSION['user_id'])
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
}
