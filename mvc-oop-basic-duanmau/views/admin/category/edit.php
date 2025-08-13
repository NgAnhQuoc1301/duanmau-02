<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Chỉnh sửa danh mục</h5>
        <a href="index.php?act=admin-categories" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        <form action="index.php?act=admin-category-update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?php echo htmlspecialchars($_SESSION['old_data']['name'] ?? $category['name']); ?>" required>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-secondary" id="reset-btn">Làm mới</button>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
</div>
<?php
// Xóa dữ liệu cũ sau khi hiển thị form
unset($_SESSION['old_data']);
?>
