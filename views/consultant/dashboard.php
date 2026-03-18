<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Consultant Dashboard</h1>
        <?php if (!empty($pending_attendance)): ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmAllModal">
                <i class="fa-solid fa-check-double me-2"></i> Confirm All Pending
            </button>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_password'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Invalid password. Approval/Confirmation failed.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Attendance Table -->
        <div class="col-12 mb-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary fw-bold"><i class="fa-solid fa-calendar-check me-2"></i>Pending Attendance Confirmations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
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
                                        <td class="fw-bold"><?= $record['student_name'] ?></td>
                                        <td><?= $record['session_name'] ?></td>
                                        <td>
                                            <span class="badge <?= $record['status'] === 'Present' ? 'bg-success' : 'bg-danger' ?>">
                                                <?= $record['status'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $record['id'] ?>">
                                                Confirm
                                            </button>

                                            <div class="modal fade" id="confirmModal<?= $record['id'] ?>" tabindex="-1">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <form action="<?= BASE_URL ?>/consultant/confirmAttendance" method="POST">
                                                            <input type="hidden" name="attendance_id" value="<?= $record['id'] ?>">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Verify Approval</h6>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="small text-muted mb-3">Please enter your account password to confirm <strong><?= $record['student_name'] ?></strong> as <strong><?= $record['status'] ?></strong>.</p>
                                                                <input type="password" class="form-control" name="password" placeholder="Your Password" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary w-100">Confirm Now</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($pending_attendance)): ?>
                                    <tr><td colspan="5" class="text-center py-5 text-muted">No pending confirmations at the moment.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clinical Log Approvals -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-success fw-bold"><i class="fa-solid fa-file-signature me-2"></i>Pending Clinical Log Approvals</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
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
                                        <td class="fw-bold"><?= $log['student_name'] ?></td>
                                        <td><?= $log['type_name'] ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-link" data-bs-toggle="collapse" data-bs-target="#logData<?= $log['id'] ?>">View Details</button>
                                            <div class="collapse mt-2" id="logData<?= $log['id'] ?>">
                                                <div class="p-2 bg-light rounded small border">
                                                    <?php foreach ($logData as $label => $val): ?>
                                                        <div><strong><?= str_replace('_', ' ', $label) ?>:</strong> <?= $v ?></div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-success px-3" data-bs-toggle="modal" data-bs-target="#approveLogModal<?= $log['id'] ?>">
                                                Approve
                                            </button>

                                            <div class="modal fade" id="approveLogModal<?= $log['id'] ?>" tabindex="-1">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <form action="<?= BASE_URL ?>/consultant/approveLog" method="POST">
                                                            <input type="hidden" name="log_id" value="<?= $log['id'] ?>">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Verify Approval</h6>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="small text-muted mb-3">Enter password to approve this clinical log for <strong><?= $log['student_name'] ?></strong>.</p>
                                                                <input type="password" class="form-control" name="password" placeholder="Your Password" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success w-100">Approve Log</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($pending_logs)): ?>
                                    <tr><td colspan="4" class="text-center py-5 text-muted">No pending log approvals.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm All Modal -->
    <div class="modal fade" id="confirmAllModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?= BASE_URL ?>/consultant/confirmAllAttendance" method="POST">
                    <div class="modal-header">
                        <h6 class="modal-title">Bulk Confirmation</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="small text-muted mb-3">Enter your password to confirm <strong>ALL</strong> pending attendance records at once.</p>
                        <input type="password" class="form-control" name="password" placeholder="Your Password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Confirm All Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
