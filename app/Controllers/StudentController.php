<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Section;
use App\Models\Attendance;

class StudentController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Student') {
            $this->redirect('/login');
        }
    }

    public function index() {
        $attendanceModel = new Attendance();
        $logModel = new \App\Models\LogActivityEntry();
        $deptModel = new Department();
        $userModel = new User();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_attendance') {
            $data = [
                'student_id' => $_SESSION['user_id'],
                'section_id' => $_POST['section_id'],
                'consultant_id' => $_POST['consultant_id'],
                'attendance_date' => $_POST['attendance_date'],
                'status' => $_POST['status']
            ];
            $attendanceModel->create($data);
            $this->redirect('/student/dashboard');
        }

        $this->render('student/dashboard', [
            'title' => 'Student Dashboard',
            'attendance_records' => $attendanceModel->getStudentAttendance($_SESSION['user_id']),
            'log_entries' => $logModel->getStudentLogs($_SESSION['user_id']),
            'departments' => $deptModel->getAll(),
            'consultants' => $userModel->getAllByRole('Consultant')
        ]);
    }

    public function submitLog() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $logModel = new \App\Models\LogActivityEntry();
            
            // Extract all form data except fixed ones
            $formData = $_POST;
            unset($formData['type_id'], $formData['consultant_id']);
            
            $data = [
                'student_id' => $_SESSION['user_id'],
                'type_id' => $_POST['type_id'],
                'consultant_id' => $_POST['consultant_id'],
                'data_json' => json_encode($formData)
            ];
            
            $logModel->create($data);
            $this->redirect('/student/dashboard');
        }
    }

    // AJAX endpoint to get activity types by department
    public function getActivityTypes() {
        if (isset($_GET['dept_id'])) {
            $typeModel = new \App\Models\LogActivityType();
            // Need a getByDept method in LogActivityType
            $stmt = \App\Core\Database::getInstance()->getConnection()->prepare("SELECT * FROM log_activity_types WHERE department_id = ?");
            $stmt->execute([$_GET['dept_id']]);
            $types = $stmt->fetchAll();
            header('Content-Type: application/json');
            echo json_encode($types);
            exit();
        }
    }

    // AJAX endpoint to get fields for an activity type
    public function getTypeFields() {
        if (isset($_GET['type_id'])) {
            $typeModel = new \App\Models\LogActivityType();
            $fields = $typeModel->getFields($_GET['type_id']);
            header('Content-Type: application/json');
            echo json_encode($fields);
            exit();
        }
    }

    // AJAX endpoint to get sections by department
    public function getSections() {
        if (isset($_GET['dept_id'])) {
            $sectionModel = new Section();
            $sections = $sectionModel->getByDept($_GET['dept_id']);
            header('Content-Type: application/json');
            echo json_encode($sections);
            exit();
        }
    }
}
