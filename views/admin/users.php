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
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-all" type="button">
                                All Users <span class="badge bg-secondary ms-1"><?= count($all_users) ?></span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-admins" type="button">
                                Admins <span class="badge bg-danger ms-1"><?= count($admins) ?></span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-students" type="button">
                                Students <span class="badge bg-secondary ms-1"><?= count($students) ?></span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-lecturers" type="button">
                                Lecturers <span class="badge bg-secondary ms-1"><?= count($lecturers) ?></span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-consultants" type="button">
                                Consultants <span class="badge bg-secondary ms-1"><?= count($consultants) ?></span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-tutors" type="button">
                                Tutors <span class="badge bg-secondary ms-1"><?= count($tutors) ?></span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="userTabsContent">
                        <div class="tab-pane fade show active" id="tab-all" role="tabpanel">
                            <?php renderUserTable($all_users, $departments, true); ?>
                        </div>
                        <div class="tab-pane fade" id="tab-admins" role="tabpanel">
                            <?php renderUserTable($admins, $departments); ?>
                        </div>
                        <div class="tab-pane fade" id="tab-students" role="tabpanel">
                            <?php renderUserTable($students, $departments); ?>
                        </div>
                        <div class="tab-pane fade" id="tab-lecturers" role="tabpanel">
                            <?php renderUserTable($lecturers, $departments); ?>
                        </div>
                        <div class="tab-pane fade" id="tab-consultants" role="tabpanel">
                            <?php renderUserTable($consultants, $departments); ?>
                        </div>
                        <div class="tab-pane fade" id="tab-tutors" role="tabpanel">
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
            <div class="modal-content border-0 shadow">
                <form action="<?= BASE_URL ?>/admin/users" method="POST" enctype="multipart/form-data">
                    <div class="modal-header bg-navy text-white">
                        <h5 class="modal-title">Register New User</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">User Photo (Upload)</label>
                                <input type="file" class="form-control form-control-sm" name="photo" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">OR Photo URL</label>
                                <input type="url" class="form-control form-control-sm" name="photo_url" placeholder="https://example.com/photo.jpg">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" class="form-control form-control-sm" name="full_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Role</label>
                                <select class="form-select form-select-sm" name="role" required>
                                    <option value="Admin">Admin</option>
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
                                <label class="form-label small fw-bold">Matric / Staff ID (Optional for Admins)</label>
                                <input type="text" class="form-control form-control-sm" name="matric_staff_id">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Department</label>
                                <select class="form-select form-select-sm" name="dept_id">
                                    <option value="">Select Department</option>
                                    <?php foreach ($departments as $dept): ?>
                                        <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Register User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php 
function renderUserTable($users, $departments, $showRole = false) { ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle small">
            <thead class="table-light">
                <tr>
                    <th>Photo</th>
                    <th>Full Name</th>
                    <th>ID Number</th>
                    <?php if ($showRole): ?><th>Role</th><?php endif; ?>
                    <th>Username</th>
                    <th>Dept</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="<?= $showRole ? 7 : 6 ?>" class="text-center py-4 text-muted italic">No users found in this category.</td></tr>
                <?php endif; ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <div class="avatar-sm rounded-circle bg-light border" style="width: 40px; height: 40px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($user['photo'])): ?>
                                    <?php $isUrl = filter_var($user['photo'], FILTER_VALIDATE_URL); ?>
                                    <img src="<?= $isUrl ? $user['photo'] : BASE_URL . '/uploads/' . $user['photo'] ?>" alt="Photo" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <i class="fa-solid fa-user text-muted" style="font-size: 20px;"></i>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="fw-bold"><?= htmlspecialchars($user['full_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['matric_staff_id'] ?? 'N/A') ?></td>
                        <?php if ($showRole): ?>
                            <td><span class="badge bg-info text-dark"><?= $user['role'] ?></span></td>
                        <?php endif; ?>
                        <td><?= htmlspecialchars($user['username'] ?? '') ?></td>
                        <td class="small text-muted"><?= htmlspecialchars($user['dept_name'] ?? 'N/A') ?></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary py-0" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['id'] ?>">Edit</button>
                                <?php if ($user['id'] != $_SESSION['user_id']): // Prevent self-deletion ?>
                                <form action="<?= BASE_URL ?>/admin/users" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-link text-danger py-0"><i class="fa-solid fa-trash"></i></button>
                                </form>
                                <?php endif; ?>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 shadow">
                                        <form action="<?= BASE_URL ?>/admin/users" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="edit">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="current_photo" value="<?= $user['photo'] ?>">
                                            <div class="modal-header bg-primary text-white">
                                                <h6 class="modal-title">Edit User: <?= htmlspecialchars($user['username'] ?? '') ?></h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <div class="row g-2">
                                                    <div class="col-12 text-center mb-2">
                                                        <div class="avatar-lg rounded-circle bg-light border mx-auto mb-2" style="width: 80px; height: 80px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                                            <?php if (!empty($user['photo'])): ?>
                                                                <?php $isUrl = filter_var($user['photo'], FILTER_VALIDATE_URL); ?>
                                                                <img src="<?= $isUrl ? $user['photo'] : BASE_URL . '/uploads/' . $user['photo'] ?>" alt="Photo" style="width: 100%; height: 100%; object-fit: cover;">
                                                            <?php else: ?>
                                                                <i class="fa-solid fa-user fa-2x text-muted"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Update Photo (File)</label>
                                                                <input type="file" class="form-control form-control-sm" name="photo" accept="image/*">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Update Photo (URL)</label>
                                                                <input type="url" class="form-control form-control-sm" name="photo_url" placeholder="https://..." value="<?= (filter_var($user['photo'], FILTER_VALIDATE_URL)) ? $user['photo'] : '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label small fw-bold">Full Name</label>
                                                        <input type="text" class="form-control form-control-sm" name="full_name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Username</label>
                                                        <input type="text" class="form-control form-control-sm" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Role</label>
                                                        <select class="form-select form-select-sm" name="role" required>
                                                            <option value="Admin" <?= $user['role'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                                                            <option value="Student" <?= $user['role'] === 'Student' ? 'selected' : '' ?>>Student</option>
                                                            <option value="Lecturer" <?= $user['role'] === 'Lecturer' ? 'selected' : '' ?>>Lecturer</option>
                                                            <option value="Consultant" <?= $user['role'] === 'Consultant' ? 'selected' : '' ?>>Consultant</option>
                                                            <option value="Tutor" <?= $user['role'] === 'Tutor' ? 'selected' : '' ?>>Tutor</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">ID Number</label>
                                                        <input type="text" class="form-control form-control-sm" name="matric_staff_id" value="<?= htmlspecialchars($user['matric_staff_id'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Department</label>
                                                        <select class="form-select form-select-sm" name="dept_id">
                                                            <option value="">None</option>
                                                            <?php foreach ($departments as $dept): ?>
                                                                <option value="<?= $dept['id'] ?>" <?= $user['dept_id'] == $dept['id'] ? 'selected' : '' ?>><?= htmlspecialchars($dept['name'] ?? '') ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label small fw-bold text-danger">New Password (leave blank to keep current)</label>
                                                        <input type="password" class="form-control form-control-sm" name="password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">Update User</button>
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
