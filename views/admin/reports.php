<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom no-print">
        <h1 class="h2">System Reports</h1>
        <div class="btn-group shadow-sm">
            <button onclick="window.print()" class="btn btn-primary btn-sm px-3">
                <i class="fa-solid fa-file-pdf me-2"></i> Export PDF / Print
            </button>
            <a href="<?= BASE_URL ?>/admin/exportCSV?<?= http_build_query($filters) ?>" class="btn btn-success btn-sm px-3">
                <i class="fa-solid fa-file-csv me-2"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Professional Print Header -->
    <div class="print-only">
        <div class="report-header text-center mb-4">
            <?php if (!empty($branding['org_logo'])): ?>
                <img src="<?= BASE_URL ?>/uploads/<?= $branding['org_logo'] ?>" alt="Institution Logo" class="report-logo mb-3">
            <?php endif; ?>
            <h1 class="institution-name"><?= strtoupper($branding['org_name'] ?? APP_NAME) ?></h1>
            <h4 class="college-name">COLLEGE OF HEALTH SCIENCES</h4>
            <div class="header-divider"></div>
            <h5 class="report-title mt-3">
                OFFICIAL <?= strtoupper(str_replace('_', ' ', $filters['report_type'])) ?> TRANSCRIPT
            </h5>
            <p class="report-meta">
                Date Generated: <strong><?= date('d F, Y') ?></strong> at <strong><?= date('H:i') ?></strong>
            </p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card shadow-sm mb-4 border-0 no-print bg-white">
        <div class="card-body p-3">
            <form action="<?= BASE_URL ?>/admin/reports" method="GET" class="row g-2">
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">REPORT TYPE</label>
                    <select class="form-select form-select-sm" name="report_type">
                        <option value="attendance" <?= $filters['report_type'] === 'attendance' ? 'selected' : '' ?>>Attendance</option>
                        <option value="clinical_log" <?= $filters['report_type'] === 'clinical_log' ? 'selected' : '' ?>>Clinical Log</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">STUDENT NAME</label>
                    <select class="form-select form-select-sm" name="student_id">
                        <option value="">All Students</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['id'] ?>" <?= $filters['student_id'] == $student['id'] ? 'selected' : '' ?>><?= htmlspecialchars($student['full_name'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">DEPARTMENT</label>
                    <select class="form-select form-select-sm" name="dept_id">
                        <option value="">All Depts</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= $filters['dept_id'] == $dept['id'] ? 'selected' : '' ?>><?= htmlspecialchars(str_ireplace(' SELECTED', '', $dept['name'] ?? '')) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">SESSION</label>
                    <select class="form-select form-select-sm" name="session_id">
                        <option value="">All Sessions</option>
                        <?php foreach ($sessions as $session): ?>
                            <option value="<?= $session['id'] ?>" <?= $filters['session_id'] == $session['id'] ? 'selected' : '' ?>><?= htmlspecialchars($session['name'] ?? '') ?> (<?= htmlspecialchars(str_ireplace(' SELECTED', '', $session['dept_name'] ?? '')) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">REFRESH REPORT</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card shadow-sm border-0 report-card bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <?php if ($filters['report_type'] === 'attendance'): ?>
                    <table class="table table-sm table-bordered table-hover align-middle mb-0">
                        <thead class="bg-navy text-white">
                            <tr>
                                <th width="50">S/N</th>
                                <th width="120">Date</th>
                                <th>Student Name</th>
                                <th>Dept / Session</th>
                                <th>Supervising Consultant</th>
                                <th width="100">Status</th>
                                <th width="80" class="text-center">Auth</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $index => $row): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['attendance_date'])) ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($row['student_name'] ?? '') ?></td>
                                    <td>
                                        <div class="small fw-bold text-navy"><?= htmlspecialchars(str_ireplace(' SELECTED', '', $row['dept_name'] ?? '')) ?></div>
                                        <div class="small text-muted italic"><?= htmlspecialchars($row['session_name'] ?? '') ?></div>
                                    </td>
                                    <td class="small"><?= htmlspecialchars($row['consultant_name'] ?? '') ?></td>
                                    <td><span class="badge <?= $row['status'] === 'Present' ? 'bg-success' : 'bg-danger' ?>"><?= strtoupper($row['status']) ?></span></td>
                                    <td class="text-center">
                                        <?php if ($row['is_confirmed']): ?>
                                            <i class="fa-solid fa-check-circle text-success" title="Verified"></i>
                                        <?php else: ?>
                                            <i class="fa-solid fa-circle-minus text-warning opacity-50" title="Pending"></i>
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
                                <th width="50">S/N</th>
                                <th width="80">Ref ID</th>
                                <th>Student</th>
                                <th>Clinical Activity</th>
                                <th>Consultant</th>
                                <th>Activity Details</th>
                                <th width="100" class="text-center">Approval</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $index => $row): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td class="text-muted small">#<?= $row['id'] ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($row['student_name'] ?? '') ?></td>
                                    <td>
                                        <div class="small fw-bold text-success"><?= htmlspecialchars($row['type_name'] ?? '') ?></div>
                                        <div class="small text-muted"><?= htmlspecialchars(str_ireplace(' SELECTED', '', $row['dept_name'] ?? '')) ?></div>
                                    </td>
                                    <td class="small"><?= htmlspecialchars($row['consultant_name'] ?? '') ?></td>
                                    <td>
                                        <div class="small p-2 bg-light rounded border-start border-3 border-success">
                                            <?php $details = json_decode($row['data_json'], true); ?>
                                            <?php foreach($details as $k => $v): ?>
                                                <div class="mb-1"><strong><?= strtoupper(str_replace('_', ' ', $k)) ?>:</strong> <?= htmlspecialchars($v ?? '') ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row['is_approved']): ?>
                                            <span class="badge bg-success w-100">APPROVED</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark w-100">PENDING</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if (empty($records)): ?>
                    <div class="text-center py-5 text-muted bg-light">
                        <i class="fa-solid fa-folder-open fa-4x mb-3 opacity-25"></i>
                        <p class="h5">No records found matching the applied filters.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Professional Print Footer -->
    <div class="print-only mt-5">
        <div class="row pt-5 g-4">
            <div class="col-4 text-center">
                <div class="signature-line"></div>
                <div class="fw-bold small">DEPARTMENT COORDINATOR</div>
                <div class="text-muted tiny">Sign & Date</div>
            </div>
            <div class="col-4 text-center">
                <div class="signature-line"></div>
                <div class="fw-bold small">COLLEGE REGISTRAR</div>
                <div class="text-muted tiny">Sign & Date</div>
            </div>
            <div class="col-4 text-center">
                <div class="stamp-box mx-auto">
                    OFFICIAL INSTITUTIONAL STAMP
                </div>
            </div>
        </div>
        <div class="text-center mt-5 tiny text-muted">
            This is an electronically generated report from the <?= $branding['org_name'] ?? APP_NAME ?> Portal.
        </div>
    </div>
</main>

<style>
/* Dashboard Styling */
.bg-navy { background-color: #000080 !important; }
.text-navy { color: #000080 !important; }
.italic { font-style: italic; }
.tiny { font-size: 0.7rem; }

/* Print Header Specifics */
.institution-name { font-size: 24px; font-weight: 900; color: #000080; margin-top: 10px; letter-spacing: 1px; }
.college-name { font-size: 16px; font-weight: 600; color: #555; margin-bottom: 15px; }
.header-divider { height: 4px; border-top: 2px solid #000080; border-bottom: 1px solid #FFD700; width: 100%; margin: 0 auto; }
.report-title { font-weight: 800; color: #333; letter-spacing: 2px; border: 1px solid #ddd; display: inline-block; padding: 5px 20px; background: #f9f9f9; }
.report-logo { max-height: 100px; width: auto; }
.report-meta { font-size: 12px; color: #666; margin-top: 10px; }

/* Signature & Stamp Styling */
.signature-line { border-top: 2px solid #333; width: 80%; margin: 40px auto 5px; }
.stamp-box { width: 120px; height: 120px; border: 2px dashed #ccc; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #aaa; text-align: center; border-radius: 10px; }

/* Print Rules */
.print-only { display: none; }

@media print {
    @page { size: A4 landscape; margin: 1cm; }
    .no-print, .sidebar, .navbar { display: none !important; }
    .print-only { display: block !important; }
    main { margin: 0 !important; padding: 0 !important; width: 100% !important; max-width: 100% !important; }
    body { background-color: white !important; font-size: 12px; }
    .card { border: none !important; box-shadow: none !important; }
    .table { width: 100% !important; border: 1px solid #000 !important; }
    .table th { background-color: #f0f0f0 !important; color: black !important; border: 1px solid #000 !important; }
    .table td { border: 1px solid #000 !important; }
    .badge { border: 1px solid #000; color: black !important; background: transparent !important; }
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
