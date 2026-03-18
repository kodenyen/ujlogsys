<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">App Settings</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary fw-bold">Organization Details</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/settings" method="POST" enctype="multipart/form-data">
                        <div class="mb-4 text-center">
                            <label class="form-label d-block fw-bold">Current Logo</label>
                            <div class="bg-light p-3 rounded mb-2 d-inline-block border" style="width: 150px; height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <?php if (!empty($current_settings['org_logo'])): ?>
                                    <img src="<?= BASE_URL ?>/uploads/<?= $current_settings['org_logo'] ?>" alt="Logo" style="max-width: 100%; max-height: 100%;">
                                <?php else: ?>
                                    <i class="fa-solid fa-image fa-3x text-muted"></i>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Organization Name</label>
                            <input type="text" class="form-control" name="org_name" value="<?= htmlspecialchars($current_settings['org_name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Footer Copyright Text</label>
                            <input type="text" class="form-control" name="footer_text" value="<?= htmlspecialchars($current_settings['footer_text'] ?? '') ?>" placeholder="e.g. 2026 Your College. All rights reserved.">
                            <small class="text-muted">This appears at the bottom of every page.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Update Logo</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Upload File</small>
                                    <input type="file" class="form-control form-control-sm" name="org_logo" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">OR Paste URL</small>
                                    <input type="url" class="form-control form-control-sm" name="logo_url" placeholder="https://..." value="<?= (!empty($current_settings['org_logo']) && filter_var($current_settings['org_logo'], FILTER_VALIDATE_URL)) ? $current_settings['org_logo'] : '' ?>">
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">Recommended: Square/Wide logo with transparent background.</small>
                        </div>

                        <div class="border-top pt-3">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold text-dark mb-3">Theme Preview</h6>
                    <div class="p-4 rounded border text-center" style="background-color: var(--primary-navy); border: 2px solid var(--secondary-gold) !important;">
                        <h4 style="color: var(--secondary-gold); margin-bottom: 5px;">Navy & Gold Theme</h4>
                        <p class="text-white small mb-0">This is how your primary branding colors look.</p>
                    </div>
                    <div class="mt-4">
                        <p class="small text-muted">
                            <strong>Navy Blue:</strong> Used for headers, sidebars, and primary actions.<br>
                            <strong>Gold:</strong> Used for accents, borders, and highlighting branding elements.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
