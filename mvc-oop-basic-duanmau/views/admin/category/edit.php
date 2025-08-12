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
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $_SESSION['old_data']['name'] ?? $category['name']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $_SESSION['old_data']['description'] ?? $category['description']; ?></textarea>
                <div class="form-text">Mô tả ngắn gọn về danh mục (không bắt buộc)</div>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <div class="form-text">Chọn hình ảnh mới để thay thế (để trống nếu không muốn thay đổi)</div>
            </div>
            
            <div class="mb-3">
                <?php if (!empty($category['image'])): ?>
                <div class="current-image mt-2">
                    <p>Hình ảnh hiện tại:</p>
                    <img src="<?php echo $category['image']; ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                </div>
                <?php endif; ?>
                
                <div id="image-preview" class="mt-3 d-none">
                    <p>Hình ảnh mới:</p>
                    <img src="" alt="Preview" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-secondary" id="reset-btn">Làm mới</button>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Hiển thị xem trước hình ảnh khi chọn file
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const previewImg = preview.querySelector('img');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
        }
    });
    
    // Reset form và ẩn xem trước hình ảnh mới
    document.getElementById('reset-btn').addEventListener('click', function() {
        document.getElementById('image-preview').classList.add('d-none');
    });
</script>

<?php
// Xóa dữ liệu cũ sau khi hiển thị form
unset($_SESSION['old_data']);
?>