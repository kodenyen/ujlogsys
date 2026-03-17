<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Clinical Posting Log</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#logAttendanceModal">
                <i class="fa-solid fa-calendar-plus me-2"></i> Attendance
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#logActivityModal">
                <i class="fa-solid fa-file-medical me-2"></i> Log Activity
            </button>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">Attendance History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>S/N</th>
                            <th>Date</th>
                            <th>Section</th>
                            <th>Consultant</th>
                            <th>Status</th>
                            <th>Confirmation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance_records as $index => $record): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= date('d M, Y', strtotime($record['attendance_date'])) ?></td>
                                <td><?= $record['section_name'] ?></td>
                                <td><?= $record['consultant_name'] ?></td>
                                <td>
                                    <span class="badge <?= $record['status'] === 'Present' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $record['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($record['is_confirmed']): ?>
                                        <span class="text-success small fw-bold"><i class="fa-solid fa-circle-check"></i> Confirmed</span>
                                    <?php else: ?>
                                        <span class="text-warning small fw-bold"><i class="fa-solid fa-clock"></i> Pending Approval</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($attendance_records)): ?>
                            <tr><td colspan="6" class="text-center py-4 text-muted">No attendance records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Clinical Activities Log Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">Clinical Activities Log</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>S/N</th>
                            <th>Activity Type</th>
                            <th>Consultant</th>
                            <th>Details</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($log_entries as $index => $entry): ?>
                            <?php $entryData = json_decode($entry['data_json'], true); ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $entry['type_name'] ?></td>
                                <td><?= $entry['consultant_name'] ?></td>
                                <td>
                                    <button class="btn btn-sm btn-link" data-bs-toggle="collapse" data-bs-target="#details<?= $entry['id'] ?>">
                                        View Details
                                    </button>
                                    <div class="collapse mt-2" id="details<?= $entry['id'] ?>">
                                        <div class="p-2 bg-light rounded small">
                                            <?php foreach ($entryData as $label => $value): ?>
                                                <div class="mb-1"><strong><?= str_replace('_', ' ', $label) ?>:</strong> <?= $value ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($entry['is_approved']): ?>
                                        <span class="text-success small fw-bold"><i class="fa-solid fa-shield-check"></i> Approved</span>
                                    <?php else: ?>
                                        <span class="text-warning small fw-bold"><i class="fa-solid fa-clock"></i> Pending</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($log_entries)): ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">No clinical activity logs found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Log Attendance Modal -->
    <div class="modal fade" id="logAttendanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="<?= BASE_URL ?>/student/dashboard" method="POST">
                    <input type="hidden" name="action" value="add_attendance">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold">Record Clinical Attendance</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Clinical Department</label>
                            <select class="form-select" id="dept_id" name="dept_id" required>
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Clinical Section</label>
                            <select class="form-select" id="section_id" name="section_id" required disabled>
                                <option value="">Select Section</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Consultant / Supervisor</label>
                            <select class="form-select" name="consultant_id" required>
                                <option value="">Select Consultant</option>
                                <?php foreach ($consultants as $consultant): ?>
                                    <option value="<?= $consultant['id'] ?>"><?= $consultant['full_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Date</label>
                                <input type="date" class="form-control" name="attendance_date" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Save Entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Log Clinical Activity Modal -->
    <div class="modal fade" id="logActivityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <form action="<?= BASE_URL ?>/student/submitLog" method="POST">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold">Log Clinical Activity</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Clinical Department</label>
                                <select class="form-select" id="log_dept_id" required>
                                    <option value="">Select Department</option>
                                    <?php foreach ($departments as $dept): ?>
                                        <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Consultant / Supervisor</label>
                                <select class="form-select" name="consultant_id" required>
                                    <option value="">Select Consultant</option>
                                    <?php foreach ($consultants as $consultant): ?>
                                        <option value="<?= $consultant['id'] ?>"><?= $consultant['full_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Activity Type</label>
                                <select class="form-select" id="log_type_id" name="type_id" required disabled>
                                    <option value="">Select Activity Type</option>
                                </select>
                            </div>
                        </div>

                        <!-- Dynamic Fields Container -->
                        <div id="dynamicFieldsContainer" class="mt-4 p-3 border rounded bg-light d-none">
                            <h6 class="mb-3 border-bottom pb-2">Activity Details</h6>
                            <div class="row g-3" id="dynamicFields">
                                <!-- Fields will be loaded here via JS -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Submit Log</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
// Logic for Attendance Sections
document.getElementById('dept_id').addEventListener('change', function() {
    const deptId = this.value;
    const sectionSelect = document.getElementById('section_id');
    
    if (deptId) {
        sectionSelect.disabled = true;
        sectionSelect.innerHTML = '<option value="">Loading sections...</option>';
        
        fetch('<?= BASE_URL ?>/student/getSections?dept_id=' + deptId)
            .then(response => response.json())
            .then(data => {
                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                data.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.name;
                    sectionSelect.appendChild(option);
                });
                sectionSelect.disabled = false;
            });
    } else {
        sectionSelect.disabled = true;
        sectionSelect.innerHTML = '<option value="">Select Section</option>';
    }
});

// Logic for Log Activity Types
document.getElementById('log_dept_id').addEventListener('change', function() {
    const deptId = this.value;
    const typeSelect = document.getElementById('log_type_id');
    const container = document.getElementById('dynamicFieldsContainer');
    
    container.classList.add('d-none');
    
    if (deptId) {
        typeSelect.disabled = true;
        typeSelect.innerHTML = '<option value="">Loading types...</option>';
        
        fetch('<?= BASE_URL ?>/student/getActivityTypes?dept_id=' + deptId)
            .then(response => response.json())
            .then(data => {
                typeSelect.innerHTML = '<option value="">Select Activity Type</option>';
                data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.textContent = type.name;
                    typeSelect.appendChild(option);
                });
                typeSelect.disabled = false;
            });
    } else {
        typeSelect.disabled = true;
        typeSelect.innerHTML = '<option value="">Select Activity Type</option>';
    }
});

// Logic for Loading Dynamic Fields
document.getElementById('log_type_id').addEventListener('change', function() {
    const typeId = this.value;
    const fieldsDiv = document.getElementById('dynamicFields');
    const container = document.getElementById('dynamicFieldsContainer');
    
    if (typeId) {
        fetch('<?= BASE_URL ?>/student/getTypeFields?type_id=' + typeId)
            .then(response => response.json())
            .then(fields => {
                fieldsDiv.innerHTML = '';
                fields.forEach(field => {
                    const col = document.createElement('div');
                    col.className = field.field_type === 'textarea' ? 'col-12' : 'col-md-6';
                    
                    let input = '';
                    if (field.field_type === 'textarea') {
                        input = `<textarea class="form-control" name="${field.field_label}" ${field.is_required ? 'required' : ''}></textarea>`;
                    } else {
                        input = `<input type="${field.field_type}" class="form-control" name="${field.field_label}" ${field.is_required ? 'required' : ''}>`;
                    }
                    
                    col.innerHTML = `
                        <label class="form-label">${field.field_label}</label>
                        ${input}
                    `;
                    fieldsDiv.appendChild(col);
                });
                container.classList.remove('d-none');
            });
    } else {
        container.classList.add('d-none');
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
