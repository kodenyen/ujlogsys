<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Sessions</h1>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 small fw-bold">Add New Session</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/sessions" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Session Name</label>
                            <input type="text" class="form-control form-control-sm" name="session_name" placeholder="e.g., Antenatal Ward Rounds" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Department</label>
                            <select class="form-select form-select-sm" name="dept_id" required>
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Create Session</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 small fw-bold">Existing Sessions</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle small">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Session Name</th>
                                    <th>Department</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sessions as $index => $session): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td class="fw-bold"><?= $session['name'] ?></td>
                                        <td><span class="badge bg-secondary"><?= $session['dept_name'] ?></span></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary py-0" data-bs-toggle="modal" data-bs-target="#editSession<?= $session['id'] ?>">Edit</button>
                                                <form action="<?= BASE_URL ?>/admin/sessions" method="POST" class="d-inline" onsubmit="return confirm('Delete this session?')">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= $session['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-link text-danger py-0"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </div>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editSession<?= $session['id'] ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="<?= BASE_URL ?>/admin/sessions" method="POST">
                                                            <input type="hidden" name="action" value="edit">
                                                            <input type="hidden" name="id" value="<?= $session['id'] ?>">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Edit Session</h6>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label small fw-bold">Session Name</label>
                                                                    <input type="text" class="form-control form-control-sm" name="session_name" value="<?= $session['name'] ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label small fw-bold">Department</label>
                                                                    <select class="form-select form-select-sm" name="dept_id" required>
                                                                        <?php foreach ($departments as $dept): ?>
                                                                            <option value="<?= $dept['id'] ?>" <?= $dept['id'] == $session['department_id'] ? 'selected' : '' ?>><?= $dept['name'] ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary btn-sm w-100">Update Session</button>
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
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
