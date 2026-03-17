<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' . ($settings['org_name'] ?? APP_NAME) : ($settings['org_name'] ?? APP_NAME) ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-navy: #000080;
            --secondary-gold: #FFD700;
            --accent-gold: #DAA520;
            --dark-navy: #000050;
        }
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background-color: var(--primary-navy); border-bottom: 3px solid var(--secondary-gold); }
        .navbar-brand { font-weight: bold; color: var(--secondary-gold) !important; }
        .nav-link { color: white !important; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .btn-primary { background-color: var(--primary-navy); border: none; color: white; }
        .btn-primary:hover { background-color: var(--dark-navy); color: var(--secondary-gold); }
        .sidebar { min-height: 100vh; background-color: var(--dark-navy); color: white; padding-top: 20px; border-right: 2px solid var(--secondary-gold); }
        .sidebar a { color: #e0e0e0; text-decoration: none; padding: 12px 20px; display: block; border-left: 4px solid transparent; transition: all 0.3s; }
        .sidebar a:hover { background-color: rgba(255, 215, 0, 0.1); color: var(--secondary-gold); border-left: 4px solid var(--secondary-gold); }
        .sidebar a.active { background-color: rgba(255, 215, 0, 0.15); color: var(--secondary-gold); border-left: 4px solid var(--secondary-gold); font-weight: bold; }
        .badge.bg-primary { background-color: var(--primary-navy) !important; }
        .text-primary { color: var(--primary-navy) !important; }
        .bg-primary { background-color: var(--primary-navy) !important; }
        .btn-outline-primary { border-color: var(--primary-navy); color: var(--primary-navy); }
        .btn-outline-primary:hover { background-color: var(--primary-navy); color: var(--secondary-gold); }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <?php if (!empty($settings['org_logo'])): ?>
                    <img src="<?= BASE_URL ?>/uploads/<?= $settings['org_logo'] ?>" alt="Logo" height="30" class="me-2">
                <?php else: ?>
                    <i class="fa-solid fa-file-medical me-2 text-gold"></i>
                <?php endif; ?>
                <?= $settings['org_name'] ?? APP_NAME ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><span class="nav-link text-light me-3">Welcome, <?= $_SESSION['full_name'] ?> (<?= $_SESSION['role'] ?>)</span></li>
                    <li class="nav-item"><a class="nav-link btn btn-danger btn-sm text-white" href="<?= BASE_URL ?>/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
    <?php endif; ?>
