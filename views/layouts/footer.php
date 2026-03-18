        <?php if (isset($_SESSION['user_id'])): ?>
        </div> <!-- row -->
    </div> <!-- container-fluid -->
    <?php endif; ?>

    <footer class="bg-white py-3 text-center mt-auto border-top no-print">
        <div class="container text-muted small">
            &copy; <?= date('Y') ?> <?= htmlspecialchars($settings['footer_text'] ?? ($settings['org_name'] ?? 'UJ Medical College of Health Science. All rights reserved.')) ?>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>
