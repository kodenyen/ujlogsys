<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Session as SessionModel;

class AdminController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
            $this->redirect('/login');
        }
    }

    public function index() {
        $userModel = new User();
        $deptModel = new Department();
        $sessionModel = new SessionModel();

        $data = [
            'title' => 'Admin Dashboard',
            'student_count' => count($userModel->getAllByRole('Student')),
            'staff_count' => count($userModel->getAllByRole('Lecturer')) + count($userModel->getAllByRole('Consultant')),
            'dept_count' => count($deptModel->getAll()),
            'session_count' => count($sessionModel->getAllWithDept())
        ];

        $this->render('admin/dashboard', $data);
    }

    public function departments() {
        $deptModel = new Department();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                if ($_POST['action'] === 'delete') {
                    $deptModel->delete($_POST['id']);
                } elseif ($_POST['action'] === 'edit') {
                    $stmt = \App\Core\Database::getInstance()->getConnection()->prepare("UPDATE departments SET name = ? WHERE id = ?");
                    $stmt->execute([$_POST['dept_name'], $_POST['id']]);
                }
            } elseif (isset($_POST['dept_name'])) {
                $deptModel->create($_POST['dept_name']);
            }
            $this->redirect('/admin/departments');
        }

        $this->render('admin/departments', [
            'title' => 'Manage Departments',
            'departments' => $deptModel->getAll()
        ]);
    }

    public function sessions() {
        $sessionModel = new SessionModel();
        $deptModel = new Department();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                if ($_POST['action'] === 'delete') {
                    $sessionModel->delete($_POST['id']);
                } elseif ($_POST['action'] === 'edit') {
                    $sessionModel->update($_POST['id'], $_POST['session_name'], $_POST['dept_id']);
                }
            } elseif (isset($_POST['session_name'])) {
                $sessionModel->create($_POST['session_name'], $_POST['dept_id']);
            }
            $this->redirect('/admin/sessions');
        }

        $this->render('admin/sessions', [
            'title' => 'Manage Sessions',
            'sessions' => $sessionModel->getAllWithDept(),
            'departments' => $deptModel->getAll()
        ]);
    }

    public function users() {
        $userModel = new User();
        $deptModel = new Department();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                if ($_POST['action'] === 'delete') {
                    $stmt = \App\Core\Database::getInstance()->getConnection()->prepare("DELETE FROM users WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                } elseif ($_POST['action'] === 'edit') {
                    $photo_name = $_POST['current_photo'] ?? null;
                    if (!empty($_POST['photo_url'])) {
                        $photo_name = $_POST['photo_url'];
                    } elseif (!empty($_FILES['photo']['name'])) {
                        $photo_name = 'user_' . time() . "_" . basename($_FILES["photo"]["name"]);
                        move_uploaded_file($_FILES["photo"]["tmp_name"], __DIR__ . "/../../public/uploads/" . $photo_name);
                    }

                    $sql = "UPDATE users SET full_name = ?, username = ?, role = ?, matric_staff_id = ?, dept_id = ?, photo = ? WHERE id = ?";
                    $params = [$_POST['full_name'], $_POST['username'], $_POST['role'], $_POST['matric_staff_id'], $_POST['dept_id'] ?: null, $photo_name, $_POST['id']];
                    
                    if (!empty($_POST['password'])) {
                        $sql = "UPDATE users SET full_name = ?, username = ?, role = ?, matric_staff_id = ?, dept_id = ?, photo = ?, password_hash = ? WHERE id = ?";
                        $params = [$_POST['full_name'], $_POST['username'], $_POST['role'], $_POST['matric_staff_id'], $_POST['dept_id'] ?: null, $photo_name, password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['id']];
                    }
                    
                    $stmt = \App\Core\Database::getInstance()->getConnection()->prepare($sql);
                    $stmt->execute($params);
                }
            } else {
                $photo_name = null;
                if (!empty($_POST['photo_url'])) {
                    $photo_name = $_POST['photo_url'];
                } elseif (!empty($_FILES['photo']['name'])) {
                    $photo_name = 'user_' . time() . "_" . basename($_FILES["photo"]["name"]);
                    move_uploaded_file($_FILES["photo"]["tmp_name"], __DIR__ . "/../../public/uploads/" . $photo_name);
                }

                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $data = [
                    'full_name' => $_POST['full_name'],
                    'username' => $_POST['username'],
                    'password_hash' => $password,
                    'role' => $_POST['role'],
                    'matric_staff_id' => $_POST['matric_staff_id'],
                    'photo' => $photo_name,
                    'dept_id' => $_POST['dept_id'] ?: null
                ];
                $userModel->create($data);
            }
            $this->redirect('/admin/users');
        }

        $this->render('admin/users', [
            'title' => 'User Management',
            'all_users' => \App\Core\Database::getInstance()->getConnection()->query("SELECT u.*, d.name as dept_name FROM users u LEFT JOIN departments d ON u.dept_id = d.id ORDER BY u.full_name ASC")->fetchAll(),
            'students' => $userModel->getAllByRole('Student'),
            'lecturers' => $userModel->getAllByRole('Lecturer'),
            'consultants' => $userModel->getAllByRole('Consultant'),
            'tutors' => $userModel->getAllByRole('Tutor'),
            'departments' => $deptModel->getAll()
        ]);
    }

    public function logConfig() {
        $fieldModel = new \App\Models\LogActivityField();
        $typeModel = new \App\Models\LogActivityType();
        $deptModel = new Department();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                if ($_POST['action'] === 'delete_field') {
                    $fieldModel->delete($_POST['id']);
                } elseif ($_POST['action'] === 'edit_field') {
                    $stmt = \App\Core\Database::getInstance()->getConnection()->prepare("UPDATE log_activity_fields SET field_label = ?, field_type = ? WHERE id = ?");
                    $stmt->execute([$_POST['field_label'], $_POST['field_type'], $_POST['id']]);
                } elseif ($_POST['action'] === 'delete_type') {
                    $stmt = \App\Core\Database::getInstance()->getConnection()->prepare("DELETE FROM log_activity_types WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                }
            } elseif (isset($_POST['field_label'])) {
                $fieldModel->create($_POST['field_label'], $_POST['field_type'], 1);
            } elseif (isset($_POST['activity_name'])) {
                $typeId = $typeModel->create($_POST['activity_name'], $_POST['dept_id']);
                if (isset($_POST['fields'])) {
                    foreach ($_POST['fields'] as $fieldId) {
                        $typeModel->assignField($typeId, $fieldId);
                    }
                }
            }
            $this->redirect('/admin/logConfig');
        }

        $this->render('admin/log_config', [
            'title' => 'Log Activity Configuration',
            'fields' => $fieldModel->getAll(),
            'types' => $typeModel->getAllWithDept(),
            'departments' => $deptModel->getAll()
        ]);
    }

    public function reports() {
        $userModel = new User();
        $deptModel = new Department();
        $sessionModel = new SessionModel();
        $attendanceModel = new \App\Models\Attendance();
        $logModel = new \App\Models\LogActivityEntry();
        $settingModel = new \App\Models\Setting();

        $filters = [
            'student_id' => $_GET['student_id'] ?? null,
            'dept_id' => $_GET['dept_id'] ?? null,
            'session_id' => $_GET['session_id'] ?? null,
            'start_date' => $_GET['start_date'] ?? null,
            'end_date' => $_GET['end_date'] ?? null,
            'report_type' => $_GET['report_type'] ?? 'attendance'
        ];

        $data = [
            'title' => 'System Reports',
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

        $this->render('admin/reports', $data);
    }

    public function exportCSV() {
        $filters = $_GET;
        $report_type = $filters['report_type'] ?? 'attendance';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $report_type . '_report_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        if ($report_type === 'attendance') {
            fputcsv($output, ['Date', 'Student', 'Department', 'Session', 'Consultant', 'Status', 'Confirmed']);
            $model = new \App\Models\Attendance();
            $records = $model->getFilteredReports($filters);
            foreach ($records as $row) {
                fputcsv($output, [$row['attendance_date'], $row['student_name'], $row['dept_name'], $row['session_name'], $row['consultant_name'], $row['status'], $row['is_confirmed'] ? 'Yes' : 'No']);
            }
        } else {
            fputcsv($output, ['ID', 'Student', 'Activity Type', 'Department', 'Consultant', 'Approved']);
            $model = new \App\Models\LogActivityEntry();
            $records = $model->getFilteredLogs($filters);
            foreach ($records as $row) {
                fputcsv($output, [$row['id'], $row['student_name'], $row['type_name'], $row['dept_name'], $row['consultant_name'], $row['is_approved'] ? 'Yes' : 'No']);
            }
        }
        fclose($output);
        exit();
    }

    public function settings() {
        $settingModel = new \App\Models\Setting();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $org_name = $_POST['org_name'];
            $logo_name = null;

            if (!empty($_FILES['org_logo']['name'])) {
                $target_dir = __DIR__ . "/../../public/uploads/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $logo_name = time() . "_" . basename($_FILES["org_logo"]["name"]);
                move_uploaded_file($_FILES["org_logo"]["tmp_name"], $target_dir . $logo_name);
            }

            $settingModel->update($org_name, $logo_name);
            $this->redirect('/admin/settings');
        }

        $this->render('admin/settings', [
            'title' => 'Organization Settings',
            'current_settings' => $settingModel->get()
        ]);
    }
}
