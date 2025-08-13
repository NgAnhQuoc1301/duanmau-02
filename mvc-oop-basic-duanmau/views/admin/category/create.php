<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Thêm danh mục mới</h5>
        <a href="index.php?act=admin-categories" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        <form action="index.php?act=admin-category-store" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?php echo htmlspecialchars($_SESSION['old_data']['name'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <div id="image-preview" class="mt-2 d-none">
                    <p>Xem trước:</p>
                    <img src="" alt="Preview" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-secondary" id="reset-btn">Làm mới</button>
                <button type="submit" class="btn btn-primary">Lưu danh mục</button>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('image-preview');
    const previewImg = preview.querySelector('img');
    const resetBtn = document.getElementById('reset-btn');

    // Hiển thị preview khi chọn file
    imageInput.addEventListener('change', function(e) {
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

    // Reset form và ẩn preview
    resetBtn.addEventListener('click', function() {
        preview.classList.add('d-none');
    });
</script>

<?php
// Xóa dữ liệu cũ sau khi hiển thị form
unset($_SESSION['old_data']);
?>
