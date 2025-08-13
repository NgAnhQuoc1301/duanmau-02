<?php if (isset($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="index.php?act=admin-user-store" method="POST">
    <div class="mb-3">
        <label for="username" class="form-label">Tên người dùng</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $_SESSION['old_data']['username'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $_SESSION['old_data']['email'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Vai trò</label>
        <select class="form-select" id="role" name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Thêm người dùng</button>
    <a href="index.php?act=admin-users" class="btn btn-secondary">Quay lại</a>
</form>
