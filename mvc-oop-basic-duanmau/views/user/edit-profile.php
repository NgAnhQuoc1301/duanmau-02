<div class="container mt-5">
    <h2 class="mb-4 text-center">Chỉnh sửa hồ sơ</h2>

    <div class="card profile-card shadow-lg p-4">
        <form action="index.php?url=update-profile" method="POST">
            <div class="mb-3">
                <label class="form-label">Họ tên</label>
                <input type="text" name="fullname" class="form-control" 
                       value="<?= htmlspecialchars($user['fullname']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" 
                       value="<?= htmlspecialchars($user['phone']) ?>">
            </div>

            <div class="text-end mt-4">
                <a href="index.php?url=profile" class="btn btn-outline-light">⬅ Quay lại</a>
                <button type="submit" class="btn btn-light">💾 Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
