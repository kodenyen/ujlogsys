<div class="col-md-3 col-lg-2 d-md-block sidebar collapse shadow-sm">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4 px-3">
            <div class="avatar-circle mx-auto mb-2" style="width: 80px; height: 80px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid var(--secondary-gold); overflow: hidden;">
                <?php if (!empty($_SESSION['photo'])): ?>
                    <?php $isUrl = filter_var($_SESSION['photo'], FILTER_VALIDATE_URL); ?>
                    <img src="<?= $isUrl ? $_SESSION['photo'] : BASE_URL . '/uploads/' . $_SESSION['photo'] ?>" alt="User Photo" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                    <i class="fa-solid fa-user-doctor fa-2x text-primary"></i>
                <?php endif; ?>
            </div>
            <h6 class="text-white mb-0"><?= $_SESSION['full_name'] ?? 'User' ?></h6>
            <small class="text-warning"><?= $_SESSION['role'] ?? '' ?></small>
        </div>

        <hr class="mx-3" style="background-color: var(--secondary-gold); height: 2px; opacity: 0.3; margin-top: 0; margin-bottom: 20px;">

        <ul class="nav flex-column">
            <?php if ($_SESSION['role'] === 'Admin'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_GET['url'] ?? '', 'dashboard') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/dashboard">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_GET['url'] ?? '', 'users') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/users">
                        <i class="fa-solid fa-users me-2"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_GET['url'] ?? '', 'departments') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/departments">
                        <i class="fa-solid fa-hospital me-2"></i> Departments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_GET['url'] ?? '', 'sessions') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/sessions">
                        <i class="fa-solid fa-sitemap me-2"></i> Sessions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_GET['url'] ?? '', 'logConfig') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/logConfig">
                        <i class="fa-solid fa-gear me-2"></i> Log Config
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_GET['url'] ?? '', 'reports') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/reports">
                        <i class="fa-solid fa-chart-line me-2"></i> System Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_GET['url'] ?? '', 'settings') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/settings">
                        <i class="fa-solid fa-cogs me-2"></i> App Settings
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'Student'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_GET['url'] ?? '', 'dashboard') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/student/dashboard">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                </li>
            <?php endif; ?>

            <?php if (in_array($_SESSION['role'], ['Consultant', 'Lecturer', 'Tutor'])): ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_GET['url'] ?? '', 'dashboard') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/consultant/dashboard">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#pendingMenu">
                        <span><i class="fa-solid fa-clock-rotate-left me-2"></i> Pending Approvals</span>
                        <i class="fa-solid fa-chevron-down small"></i>
                    </a>
                    <div class="collapse show" id="pendingMenu">
                        <ul class="nav flex-column ms-3 small">
                            <li class="nav-item">
                                <a class="nav-link py-1" href="<?= BASE_URL ?>/consultant/dashboard#attendance-table">
                                    <i class="fa-solid fa-calendar-check me-2"></i> Attendance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-1" href="<?= BASE_URL ?>/consultant/dashboard#logs-table">
                                    <i class="fa-solid fa-file-medical me-2"></i> Clinical Logs
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/consultant/reports?report_type=attendance">
                        <i class="fa-solid fa-calendar-check me-2"></i> My Verified Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/consultant/reports?report_type=clinical_log">
                        <i class="fa-solid fa-file-medical me-2"></i> My Approved Logs
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
