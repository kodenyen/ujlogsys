<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card p-4 shadow-lg w-100" style="max-width: 400px; border-top: 5px solid var(--secondary-gold);">
        <div class="text-center mb-4">
            <?php if (!empty($settings['org_logo'])): ?>
                <img src="<?= BASE_URL ?>/uploads/<?= $settings['org_logo'] ?>" alt="Logo" class="mb-3" style="max-height: 100px;">
            <?php else: ?>
                <i class="fa-solid fa-user-doctor fa-3x text-primary mb-3"></i>
            <?php endif; ?>
            <h4 class="fw-bold text-primary"><?= $settings['org_name'] ?? 'Student Clinical Log System' ?></h4>
            <p class="text-muted small">Please sign in to continue</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/login" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-start-0" id="username" name="username" placeholder="Enter username" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                    <input type="password" class="form-control bg-light border-start-0" id="password" name="password" placeholder="Enter password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Login <i class="fa-solid fa-arrow-right-to-bracket ms-1"></i></button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
