<div class="container mt-4">
    <h2>Thông tin cá nhân</h2>
    <div class="card p-3 shadow-sm">
        <p><strong>Họ tên:</strong> <?= htmlspecialchars($user['fullname']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <a href="index.php?url=edit-profile" class="btn btn-primary">Chỉnh sửa</a>
    </div>
</div>