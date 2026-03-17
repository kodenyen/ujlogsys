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
                    <small class="text-muted">Create reusable fields (e.g., Hospital No, Diagnosis)</small>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/logConfig" method="POST" class="mb-4">
                        <div class="mb-3">
                            <label class="form-label">Field Label</label>
                            <input type="text" class="form-control" name="field_label" placeholder="e.g., Hospital Number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Input Type</label>
                            <select class="form-select" name="field_type" required>
                                <option value="text">Short Text</option>
                                <option value="textarea">Long Text / Narrative</option>
                                <option value="date">Date Selector</option>
                                <option value="number">Numeric Only</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Field</button>
                    </form>

                    <h6>Existing Fields</h6>
                    <div class="list-group list-group-flush border rounded">
                        <?php foreach ($fields as $field): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold"><?= $field['field_label'] ?></span>
                                    <br><small class="text-muted">Type: <?= $field['field_type'] ?></small>
                                </div>
                                <button class="btn btn-sm text-danger"><i class="fa-solid fa-trash"></i></button>
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
                    <small class="text-muted">Group fields into specific report types (e.g., Clerking)</small>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/logConfig" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Activity Type Name</label>
                            <input type="text" class="form-control" name="activity_name" placeholder="e.g., Antenatal - Clerking and Presentation" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Department</label>
                            <select class="form-select" name="dept_id" required>
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assign Fields to this Type</label>
                            <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                <?php foreach ($fields as $field): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="fields[]" value="<?= $field['id'] ?>" id="f<?= $field['id'] ?>">
                                        <label class="form-check-label" for="f<?= $field['id'] ?>">
                                            <?= $field['field_label'] ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Create Activity Type</button>
                    </form>

                    <h6 class="mt-4">Registered Activity Types</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover border">
                            <thead class="table-light">
                                <tr>
                                    <th>Activity Type</th>
                                    <th>Department</th>
                                    <th>Fields</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($types as $type): ?>
                                    <tr>
                                        <td><?= $type['name'] ?></td>
                                        <td><span class="badge bg-info text-dark"><?= $type['dept_name'] ?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-link py-0" data-bs-toggle="tooltip" title="View assigned fields">
                                                <i class="fa-solid fa-eye"></i> View
                                            </button>
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
