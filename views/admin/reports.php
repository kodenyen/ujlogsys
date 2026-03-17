<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">System Reports</h1>
        <div class="btn-group">
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="fa-solid fa-print me-2"></i> Print Report
            </button>
            <a href="<?= BASE_URL ?>/admin/exportCSV?<?= http_build_query($filters) ?>" class="btn btn-success">
                <i class="fa-solid fa-file-csv me-2"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body bg-light rounded">
            <form action="<?= BASE_URL ?>/admin/reports" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Report Type</label>
                    <select class="form-select form-select-sm" name="report_type">
                        <option value="attendance" <?= $filters['report_type'] === 'attendance' ? 'selected' : '' ?>>Attendance Records</option>
                        <option value="clinical_log" <?= $filters['report_type'] === 'clinical_log' ? 'selected' : '' ?>>Clinical Activity Logs</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Student</label>
                    <select class="form-select form-select-sm" name="student_id">
                        <option value="">All Students</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['id'] ?>" <?= $filters['student_id'] == $student['id'] ? 'selected' : '' ?>>
                                <?= $student['full_name'] ?> (<?= $student['matric_staff_id'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Department</label>
                    <select class="form-select form-select-sm" name="dept_id">
                        <option value="">All Depts</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= $filters['dept_id'] == $dept['id'] ? 'selected' : '' ?>>
                                <?= $dept['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Start Date</label>
                    <input type="date" class="form-control form-control-sm" name="start_date" value="<?= $filters['start_date'] ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <?php if ($filters['report_type'] === 'attendance'): ?>
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Department</th>
                                <th>Section</th>
                                <th>Consultant</th>
                                <th>Status</th>
                                <th>Confirmed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $row): ?>
                                <tr>
                                    <td><?= $row['attendance_date'] ?></td>
                                    <td class="fw-bold"><?= $row['student_name'] ?></td>
                                    <td><?= $row['dept_name'] ?></td>
                                    <td><?= $row['section_name'] ?></td>
                                    <td><?= $row['consultant_name'] ?></td>
                                    <td><span class="badge <?= $row['status'] === 'Present' ? 'bg-success' : 'bg-danger' ?>"><?= $row['status'] ?></span></td>
                                    <td><?= $row['is_confirmed'] ? '<span class="text-success">Yes</span>' : '<span class="text-muted">No</span>' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Activity Type</th>
                                <th>Department</th>
                                <th>Consultant</th>
                                <th>Details</th>
                                <th>Approved</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $row): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td class="fw-bold"><?= $row['student_name'] ?></td>
                                    <td><?= $row['type_name'] ?></td>
                                    <td><?= $row['dept_name'] ?></td>
                                    <td><?= $row['consultant_name'] ?></td>
                                    <td>
                                        <div class="small">
                                            <?php $details = json_decode($row['data_json'], true); ?>
                                            <?php foreach(array_slice($details, 0, 2) as $k => $v): ?>
                                                <div><strong><?= $k ?>:</strong> <?= $v ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td><?= $row['is_approved'] ? '<span class="text-success">Yes</span>' : '<span class="text-muted">No</span>' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if (empty($records)): ?>
                    <div class="text-center py-5 text-muted">No records matching the current filters.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<style>
@media print {
    .sidebar, .navbar, .btn-group, .card-body form {
        display: none !important;
    }
    main {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }
    .card {
        box-shadow: none !important;
        border: none !important;
    }
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
