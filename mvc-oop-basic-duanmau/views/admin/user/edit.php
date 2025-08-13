<?php
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old_data'] ?? $user ?? []; // ưu tiên old_data khi submit lỗi
unset($_SESSION['errors'], $_SESSION['old_data']);
?>

<h2 class="d-flex justify-content-between align-items-center">
    Chỉnh sửa người dùng
    <a href="index.php?act=admin-users" class="btn btn-secondary">Quay lại</a>
</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($errors as $err): ?>
                <li><?php echo $err; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="index.php?act=admin-user-update" method="POST">
    <input type="hidden" name="id" value="<?php echo $old['id'] ?? ''; ?>">

    <div class="mb-3">
        <label>Tên người dùng</label>
        <input type="text" name="username" class="form-control" value="<?php echo $old['username'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo $old['email'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Quyền</label>
        <select name="role" class="form-select">
            <option value="user" <?php echo ($old['role']=='user')?'selected':''; ?>>User</option>
            <option value="admin" <?php echo ($old['role']=='admin')?'selected':''; ?>>Admin</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
