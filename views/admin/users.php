<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">User Management</h1>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fa-solid fa-plus me-2"></i> Register New User
        </button>
    </div>

    <!-- User Lists -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-2">
                    <ul class="nav nav-tabs card-header-tabs small fw-bold" id="userTabs" role="tablist">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#students" type="button">Students</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#lecturers" type="button">Lecturers</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#consultants" type="button">Consultants</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tutors" type="button">Tutors</button></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="userTabsContent">
                        <!-- Students Tab -->
                        <div class="tab-pane fade show active" id="students" role="tabpanel">
                            <?php renderUserTable($students, $departments); ?>
                        </div>
                        <!-- Lecturers Tab -->
                        <div class="tab-pane fade" id="lecturers" role="tabpanel">
                            <?php renderUserTable($lecturers, $departments); ?>
                        </div>
                        <!-- Consultants Tab -->
                        <div class="tab-pane fade" id="consultants" role="tabpanel">
                            <?php renderUserTable($consultants, $departments); ?>
                        </div>
                        <!-- Tutors Tab -->
                        <div class="tab-pane fade" id="tutors" role="tabpanel">
                            <?php renderUserTable($tutors, $departments); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="<?= BASE_URL ?>/admin/users" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Register New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" class="form-control form-control-sm" name="full_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Role</label>
                                <select class="form-select form-select-sm" name="role" required>
                                    <option value="Student">Student</option>
                                    <option value="Lecturer">Lecturer</option>
                                    <option value="Consultant">Consultant</option>
                                    <option value="Tutor">Tutor</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Username</label>
                                <input type="text" class="form-control form-control-sm" name="username" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" class="form-control form-control-sm" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Matric / Staff ID</label>
                                <input type="text" class="form-control form-control-sm" name="matric_staff_id" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Department</label>
                                <select class="form-select form-select-sm" name="dept_id">
                                    <option value="">Select Department</option>
                                    <?php foreach ($departments as $dept): ?>
                                        <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm px-4">Register User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php 
function renderUserTable($users, $departments) { ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle small">
            <thead class="table-light">
                <tr>
                    <th>Full Name</th>
                    <th>ID Number</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="fw-bold"><?= $user['full_name'] ?></td>
                        <td><?= $user['matric_staff_id'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary py-0" data-bs-toggle="modal" data-bs-target="#editUser<?= $user['id'] ?>">Edit</button>
                                <form action="<?= BASE_URL ?>/admin/users" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-link text-danger py-0"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editUser<?= $user['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= BASE_URL ?>/admin/users" method="POST">
                                            <input type="hidden" name="action" value="edit">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Edit User: <?= $user['username'] ?></h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <label class="form-label small fw-bold">Full Name</label>
                                                        <input type="text" class="form-control form-control-sm" name="full_name" value="<?= $user['full_name'] ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Username</label>
                                                        <input type="text" class="form-control form-control-sm" name="username" value="<?= $user['username'] ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Role</label>
                                                        <select class="form-select form-select-sm" name="role" required>
                                                            <option value="Student" <?= $user['role'] === 'Student' ? 'selected' : '' ?>>Student</option>
                                                            <option value="Lecturer" <?= $user['role'] === 'Lecturer' ? 'selected' : '' ?>>Lecturer</option>
                                                            <option value="Consultant" <?= $user['role'] === 'Consultant' ? 'selected' : '' ?>>Consultant</option>
                                                            <option value="Tutor" <?= $user['role'] === 'Tutor' ? 'selected' : '' ?>>Tutor</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">ID Number</label>
                                                        <input type="text" class="form-control form-control-sm" name="matric_staff_id" value="<?= $user['matric_staff_id'] ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Department</label>
                                                        <select class="form-select form-select-sm" name="dept_id">
                                                            <option value="">None</option>
                                                            <?php foreach ($departments as $dept): ?>
                                                                <option value="<?= $dept['id'] ?>" <?= $user['dept_id'] == $dept['id'] ? 'selected' : '' ?>><?= $dept['name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label small fw-bold text-danger">New Password (leave blank to keep current)</label>
                                                        <input type="password" class="form-control form-control-sm" name="password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">Update User</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php } ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
