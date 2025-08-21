<div class="container mt-5">
    <h2 class="mb-4 text-center">Hồ sơ cá nhân</h2>

    <div class="card profile-card shadow-lg p-4">
        <div class="d-flex align-items-center mb-3">
            <div class="profile-avatar me-3">
                <i class="bi bi-person-circle" style="font-size: 4rem; color: #fff;"></i>
            </div>
            <div>
                <h4 class="mb-1"><?= htmlspecialchars($user['fullname']) ?></h4>
                <span class="badge bg-light text-dark"><?= htmlspecialchars($user['role'] ?? 'user') ?></span>
            </div>
        </div>

        <div class="profile-info mt-3">
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></p>
            <p><strong>Tài khoản:</strong> <?= htmlspecialchars($user['username']) ?></p>
        </div>

        <div class="mt-4 text-end">
            <a href="index.php?url=edit-profile" class="btn btn-light">✏️ Chỉnh sửa hồ sơ</a>
        </div>
    </div>
</div>
