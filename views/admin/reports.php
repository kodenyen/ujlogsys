<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom no-print">
        <h1 class="h2">System Reports</h1>
        <div class="btn-group">
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-file-pdf me-2"></i> Print / Save PDF
            </button>
            <a href="<?= BASE_URL ?>/admin/exportCSV?<?= http_build_query($filters) ?>" class="btn btn-success btn-sm">
                <i class="fa-solid fa-file-csv me-2"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Print Header (Only visible when printing) -->
    <div class="print-only mb-4">
        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
            <div class="d-flex align-items-center">
                <?php if (!empty($branding['org_logo'])): ?>
                    <img src="<?= BASE_URL ?>/uploads/<?= $branding['org_logo'] ?>" alt="Logo" height="80" class="me-3">
                <?php endif; ?>
                <div>
                    <h2 class="mb-0 fw-bold text-navy"><?= $branding['org_name'] ?? APP_NAME ?></h2>
                    <p class="text-muted mb-0">Clinical Posting & Attendance Report</p>
                </div>
            </div>
            <div class="text-end">
                <p class="small mb-0">Generated on: <?= date('d M, Y H:i') ?></p>
                <p class="small mb-0 fw-bold">Report: <?= ucfirst(str_replace('_', ' ', $filters['report_type'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Filters Section (Hidden when printing) -->
    <div class="card shadow-sm mb-4 border-0 no-print">
        <div class="card-body bg-light rounded">
            <form action="<?= BASE_URL ?>/admin/reports" method="GET" class="row g-2">
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Type</label>
                    <select class="form-select form-select-sm" name="report_type">
                        <option value="attendance" <?= $filters['report_type'] === 'attendance' ? 'selected' : '' ?>>Attendance</option>
                        <option value="clinical_log" <?= $filters['report_type'] === 'clinical_log' ? 'selected' : '' ?>>Clinical Log</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Student</label>
                    <select class="form-select form-select-sm" name="student_id">
                        <option value="">All Students</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['id'] ?>" <?= $filters['student_id'] == $student['id'] ? 'selected' : '' ?>><?= htmlspecialchars($student['full_name'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Department</label>
                    <select class="form-select form-select-sm" name="dept_id">
                        <option value="">All Depts</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= $filters['dept_id'] == $dept['id'] ? 'selected' : '' ?>><?= htmlspecialchars($dept['name'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Session</label>
                    <select class="form-select form-select-sm" name="session_id">
                        <option value="">All Sessions</option>
                        <?php foreach ($sessions as $session): ?>
                            <option value="<?= $session['id'] ?>" <?= $filters['session_id'] == $session['id'] ? 'selected' : '' ?>><?= htmlspecialchars($session['name'] ?? '') ?> (<?= htmlspecialchars($session['dept_name'] ?? '') ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card shadow-sm border-0 report-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <?php if ($filters['report_type'] === 'attendance'): ?>
                    <table class="table table-sm table-bordered table-hover align-middle mb-0">
                        <thead class="bg-navy text-white">
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Dept / Session</th>
                                <th>Consultant</th>
                                <th>Status</th>
                                <th class="text-center">Confirmed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $index => $row): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['attendance_date'])) ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($row['student_name'] ?? '') ?></td>
                                    <td>
                                        <div class="small fw-bold text-navy"><?= htmlspecialchars($row['dept_name'] ?? '') ?></div>
                                        <div class="small text-muted"><?= htmlspecialchars($row['session_name'] ?? '') ?></div>
                                    </td>
                                    <td class="small"><?= htmlspecialchars($row['consultant_name'] ?? '') ?></td>
                                    <td><span class="badge <?= $row['status'] === 'Present' ? 'bg-success' : 'bg-danger' ?>"><?= $row['status'] ?></span></td>
                                    <td class="text-center">
                                        <?php if ($row['is_confirmed']): ?>
                                            <i class="fa-solid fa-check-circle text-success"></i>
                                        <?php else: ?>
                                            <i class="fa-solid fa-circle-minus text-warning opacity-50"></i>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <table class="table table-sm table-bordered table-hover align-middle mb-0">
                        <thead class="bg-success text-white">
                            <tr>
                                <th>S/N</th>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Activity / Dept</th>
                                <th>Consultant</th>
                                <th>Activity Details</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $index => $row): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>#<?= $row['id'] ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($row['student_name'] ?? '') ?></td>
                                    <td>
                                        <div class="small fw-bold text-success"><?= htmlspecialchars($row['type_name'] ?? '') ?></div>
                                        <div class="small text-muted"><?= htmlspecialchars($row['dept_name'] ?? '') ?></div>
                                    </td>
                                    <td class="small"><?= htmlspecialchars($row['consultant_name'] ?? '') ?></td>
                                    <td>
                                        <div class="small p-1 bg-light rounded" style="max-width: 250px;">
                                            <?php $details = json_decode($row['data_json'], true); ?>
                                            <?php foreach($details as $k => $v): ?>
                                                <div class="text-truncate"><strong><?= str_replace('_', ' ', $k) ?>:</strong> <?= htmlspecialchars($v ?? '') ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row['is_approved']): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if (empty($records)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-folder-open fa-3x mb-3 opacity-25"></i>
                        <p>No records matching the current filters.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Print Footer -->
    <div class="print-only mt-5">
        <div class="row pt-5">
            <div class="col-4 text-center">
                <div class="border-top pt-2">Registrar Signature</div>
            </div>
            <div class="col-4"></div>
            <div class="col-4 text-center">
                <div class="border-top pt-2">Official Stamp</div>
            </div>
        </div>
    </div>
</main>

<style>
.bg-navy { background-color: var(--primary-navy) !important; }
.text-navy { color: var(--primary-navy) !important; }

.print-only { display: none; }

@media print {
    .no-print, .sidebar, .navbar { display: none !important; }
    .print-only { display: block !important; }
    main { margin: 0 !important; padding: 0 !important; width: 100% !important; max-width: 100% !important; }
    .card { border: 1px solid #ddd !important; box-shadow: none !important; }
    .table { width: 100% !important; border-collapse: collapse !important; }
    .table th { background-color: #f8f9fa !important; color: black !important; }
    body { background-color: white !important; }
    .report-card { border: none !important; }
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
