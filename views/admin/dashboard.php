<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Administrator Dashboard</h1>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-1 small fw-bold">Students</h6>
                            <h2 class="mb-0 fw-bold"><?= $student_count ?></h2>
                        </div>
                        <i class="fa-solid fa-user-graduate fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-1 small fw-bold">Staff Members</h6>
                            <h2 class="mb-0 fw-bold"><?= $staff_count ?></h2>
                        </div>
                        <i class="fa-solid fa-user-tie fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-1 small fw-bold">Departments</h6>
                            <h2 class="mb-0 fw-bold"><?= $dept_count ?></h2>
                        </div>
                        <i class="fa-solid fa-building-user fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-1 small fw-bold">Clinical Sections</h6>
                            <h2 class="mb-0 fw-bold"><?= $section_count ?></h2>
                        </div>
                        <i class="fa-solid fa-list-check fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">System Quick Links</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="<?= BASE_URL ?>/admin/users" class="list-group-item list-group-item-action py-3 d-flex align-items-center">
                            <i class="fa-solid fa-user-plus me-3 text-primary"></i> Register New User
                        </a>
                        <a href="<?= BASE_URL ?>/admin/departments" class="list-group-item list-group-item-action py-3 d-flex align-items-center">
                            <i class="fa-solid fa-folder-plus me-3 text-success"></i> Manage Departments
                        </a>
                        <a href="<?= BASE_URL ?>/admin/sections" class="list-group-item list-group-item-action py-3 d-flex align-items-center">
                            <i class="fa-solid fa-layer-group me-3 text-info"></i> Configure Sections
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
