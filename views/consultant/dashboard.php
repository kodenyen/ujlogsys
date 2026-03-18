<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Consultant Dashboard</h1>
        <?php if (!empty($pending_attendance)): ?>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmAllModal">
                <i class="fa-solid fa-check-double me-2"></i> Bulk Confirm Attendance
            </button>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_password'): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> Invalid password. Action cancelled.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100 border-start border-4 border-warning shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small fw-bold text-uppercase">Pending Attendance</h6>
                    <h2 class="mb-0 fw-bold text-warning"><?= count($pending_attendance) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-start border-4 border-info shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small fw-bold text-uppercase">Pending Logs</h6>
                    <h2 class="mb-0 fw-bold text-info"><?= count($pending_logs) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-start border-4 border-success shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small fw-bold text-uppercase">Total Verified</h6>
                    <h2 class="mb-0 fw-bold text-success"><?= $stats['total_verified'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-start border-4 border-primary shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small fw-bold text-uppercase">Total Logs Approved</h6>
                    <h2 class="mb-0 fw-bold text-primary"><?= $stats['total_logs'] ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Quick Help / Profile -->
        <div class="col-md-12">
            <div class="card shadow-sm bg-navy text-white h-100 border-0">
                <div class="card-body d-flex flex-column justify-content-center text-center py-5">
                    <div class="mb-3">
                        <i class="fa-solid fa-shield-halved fa-4x text-gold"></i>
                    </div>
                    <h4>Secure Approval Mode</h4>
                    <p class="opacity-75">All student clinical records require your account password for final verification to ensure data integrity.</p>
                    <a href="<?= BASE_URL ?>/consultant/reports?report_type=clinical_log" class="btn btn-outline-light btn-sm mt-3 px-4">View My Full History</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div id="attendance-table" class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <h5 class="card-title mb-0 text-primary fw-bold"><i class="fa-solid fa-calendar-check me-2"></i>Pending Attendance Confirmations</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle small">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Student Name</th>
                            <th>Session</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_attendance as $record): ?>
                            <tr>
                                <td><?= date('d M, Y', strtotime($record['attendance_date'])) ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($record['student_name']) ?></td>
                                <td><?= htmlspecialchars($record['session_name']) ?></td>
                                <td>
                                    <span class="badge <?= $record['status'] === 'Present' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= strtoupper($record['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $record['id'] ?>">
                                        CONFIRM
                                    </button>

                                    <div class="modal fade" id="confirmModal<?= $record['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content border-0 shadow">
                                                <form action="<?= BASE_URL ?>/consultant/confirmAttendance" method="POST">
                                                    <input type="hidden" name="attendance_id" value="<?= $record['id'] ?>">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h6 class="modal-title">Verify Approval</h6>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <p class="small text-muted mb-3">Enter password to confirm <strong><?= htmlspecialchars($record['student_name']) ?></strong>.</p>
                                                        <input type="password" class="form-control form-control-sm" name="password" placeholder="Password" required>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">AUTHORIZE</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($pending_attendance)): ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted bg-light">No pending confirmations.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Clinical Log Approvals -->
    <div id="logs-table" class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <h5 class="card-title mb-0 text-success fw-bold"><i class="fa-solid fa-file-signature me-2"></i>Pending Clinical Log Approvals</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle small">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Activity Type</th>
                            <th>Data Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_logs as $log): ?>
                            <?php $logData = json_decode($log['data_json'], true); ?>
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($log['student_name']) ?></td>
                                <td><?= htmlspecialchars($log['type_name']) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-link text-decoration-none p-0" data-bs-toggle="collapse" data-bs-target="#logData<?= $log['id'] ?>">View Details <i class="fa-solid fa-caret-down"></i></button>
                                    <div class="collapse mt-2" id="logData<?= $log['id'] ?>">
                                        <div class="p-2 bg-light rounded small border">
                                            <?php foreach ($logData as $label => $val): ?>
                                                <div class="mb-1 text-truncate"><strong><?= strtoupper(str_replace('_', ' ', $label)) ?>:</strong> <?= htmlspecialchars($val) ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#approveLogModal<?= $log['id'] ?>">
                                        APPROVE
                                    </button>

                                    <div class="modal fade" id="approveLogModal<?= $log['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content border-0 shadow">
                                                <form action="<?= BASE_URL ?>/consultant/approveLog" method="POST">
                                                    <input type="hidden" name="log_id" value="<?= $log['id'] ?>">
                                                    <div class="modal-header bg-success text-white">
                                                        <h6 class="modal-title">Verify Approval</h6>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <p class="small text-muted mb-3">Enter password to approve clinical log for <strong><?= htmlspecialchars($log['student_name']) ?></strong>.</p>
                                                        <input type="password" class="form-control form-control-sm" name="password" placeholder="Password" required>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">AUTHORIZE</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($pending_logs)): ?>
                            <tr><td colspan="4" class="text-center py-5 text-muted bg-light">No pending approvals.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bulk Confirm Modal -->
    <div class="modal fade" id="confirmAllModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content border-0 shadow">
                <form action="<?= BASE_URL ?>/consultant/confirmAllAttendance" method="POST">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title">Bulk Confirmation</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <div class="mb-3"><i class="fa-solid fa-circle-check fa-3x text-warning opacity-50"></i></div>
                        <p class="mb-3">Confirm <strong>ALL</strong> pending attendance records at once?</p>
                        <input type="password" class="form-control form-control-sm" name="password" placeholder="Enter Your Password" required>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">CONFIRM ALL RECORDS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
