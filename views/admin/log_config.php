<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Log Activity Configuration</h1>
    </div>

    <div class="row">
        <!-- Manage Fields -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Step 1: Define Fields</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/logConfig" method="POST" class="mb-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Field Label</label>
                            <input type="text" class="form-control form-control-sm" name="field_label" placeholder="e.g., Hospital Number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Input Type</label>
                            <select class="form-select form-select-sm" name="field_type" required>
                                <option value="text">Short Text</option>
                                <option value="textarea">Long Text / Narrative</option>
                                <option value="date">Date Selector</option>
                                <option value="number">Numeric Only</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Add Field</button>
                    </form>

                    <h6>Existing Fields</h6>
                    <div class="list-group list-group-flush border rounded shadow-sm">
                        <?php foreach ($fields as $field): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <div>
                                    <span class="fw-bold small"><?= $field['field_label'] ?></span>
                                    <br><small class="text-muted"><?= $field['field_type'] ?></small>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-link text-primary p-0 me-2" data-bs-toggle="modal" data-bs-target="#editField<?= $field['id'] ?>"><i class="fa-solid fa-edit"></i></button>
                                    <form action="<?= BASE_URL ?>/admin/logConfig" method="POST" onsubmit="return confirm('Delete this field?')">
                                        <input type="hidden" name="action" value="delete_field">
                                        <input type="hidden" name="id" value="<?= $field['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>

                            <!-- Edit Field Modal -->
                            <div class="modal fade" id="editField<?= $field['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <form action="<?= BASE_URL ?>/admin/logConfig" method="POST">
                                            <input type="hidden" name="action" value="edit_field">
                                            <input type="hidden" name="id" value="<?= $field['id'] ?>">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Edit Field</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">Field Label</label>
                                                    <input type="text" class="form-control form-control-sm" name="field_label" value="<?= $field['field_label'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">Input Type</label>
                                                    <select class="form-select form-select-sm" name="field_type" required>
                                                        <option value="text" <?= $field['field_type'] === 'text' ? 'selected' : '' ?>>Short Text</option>
                                                        <option value="textarea" <?= $field['field_type'] === 'textarea' ? 'selected' : '' ?>>Long Text</option>
                                                        <option value="date" <?= $field['field_type'] === 'date' ? 'selected' : '' ?>>Date</option>
                                                        <option value="number" <?= $field['field_type'] === 'number' ? 'selected' : '' ?>>Number</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">Update Field</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manage Activity Types -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Step 2: Create Activity Types</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/logConfig" method="POST" class="mb-4 p-3 bg-light rounded border">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Activity Name</label>
                                <input type="text" class="form-control form-control-sm" name="activity_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Department</label>
                                <select class="form-select form-select-sm" name="dept_id" required>
                                    <?php foreach ($departments as $dept): ?>
                                        <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Assign Fields</label>
                                <div class="border rounded p-2 bg-white" style="max-height: 120px; overflow-y: auto;">
                                    <?php foreach ($fields as $field): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fields[]" value="<?= $field['id'] ?>" id="fx<?= $field['id'] ?>">
                                            <label class="form-check-label small" for="fx<?= $field['id'] ?>"><?= $field['field_label'] ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-sm w-100">Register Activity Type</button>
                            </div>
                        </div>
                    </form>

                    <h6 class="mt-4">Registered Activity Types</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover border small">
                            <thead class="table-light">
                                <tr>
                                    <th>Activity Type</th>
                                    <th>Department</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($types as $type): ?>
                                    <tr>
                                        <td class="fw-bold"><?= $type['name'] ?></td>
                                        <td><span class="badge bg-info text-dark"><?= $type['dept_name'] ?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary py-0" data-bs-toggle="modal" data-bs-target="#viewFields<?= $type['id'] ?>">View</button>
                                            <form action="<?= BASE_URL ?>/admin/logConfig" method="POST" class="d-inline" onsubmit="return confirm('Delete this activity type?')">
                                                <input type="hidden" name="action" value="delete_type">
                                                <input type="hidden" name="id" value="<?= $type['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-link text-danger py-0"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- View Fields Modal -->
                                    <div class="modal fade" id="viewFields<?= $type['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Fields for <?= $type['name'] ?></h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-0">
                                                    <ul class="list-group list-group-flush">
                                                        <?php 
                                                        $typeModel = new \App\Models\LogActivityType();
                                                        $assignedFields = $typeModel->getFields($type['id']);
                                                        foreach ($assignedFields as $af): ?>
                                                            <li class="list-group-item d-flex justify-content-between small">
                                                                <?= $af['field_label'] ?>
                                                                <span class="text-muted"><?= $af['field_type'] ?></span>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
