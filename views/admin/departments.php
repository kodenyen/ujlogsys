<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Departments</h1>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 small fw-bold">Add New Department</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/departments" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Department Name</label>
                            <input type="text" class="form-control form-control-sm" name="dept_name" placeholder="e.g., Obstetrics and Gynaecology" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Create Department</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 small fw-bold">Existing Departments</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle small">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Department Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($departments as $index => $dept): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td class="fw-bold"><?= $dept['name'] ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary py-0" data-bs-toggle="modal" data-bs-target="#editDept<?= $dept['id'] ?>">Edit</button>
                                                <form action="<?= BASE_URL ?>/admin/departments" method="POST" class="d-inline" onsubmit="return confirm('Delete this department? This will delete all associated sessions and logs.')">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= $dept['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-link text-danger py-0"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </div>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editDept<?= $dept['id'] ?>" tabindex="-1">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <form action="<?= BASE_URL ?>/admin/departments" method="POST">
                                                            <input type="hidden" name="action" value="edit">
                                                            <input type="hidden" name="id" value="<?= $dept['id'] ?>">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Edit Department</h6>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="text" class="form-control form-control-sm" name="dept_name" value="<?= $dept['name'] ?>" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary btn-sm w-100">Update</button>
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
