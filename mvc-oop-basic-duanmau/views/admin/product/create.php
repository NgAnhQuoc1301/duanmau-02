<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Thêm sản phẩm mới</h5>
        <a href="index.php?act=admin-products" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        <form action="index.php?act=admin-product-store" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $_SESSION['old_data']['name'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $_SESSION['old_data']['price'] ?? '0'; ?>" min="0" required>
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sale_price" class="form-label">Giá khuyến mãi</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="sale_price" name="sale_price" value="<?php echo $_SESSION['old_data']['sale_price'] ?? '0'; ?>" min="0">
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" id="description" name="description" rows="5"><?php echo $_SESSION['old_data']['description'] ?? ''; ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo (isset($_SESSION['old_data']['category_id']) && $_SESSION['old_data']['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                    <?php echo $category['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1" <?php echo (!isset($_SESSION['old_data']['status']) || $_SESSION['old_data']['status'] == 1) ? 'selected' : ''; ?>>Hiển thị</option>
                            <option value="0" <?php echo (isset($_SESSION['old_data']['status']) && $_SESSION['old_data']['status'] == 0) ? 'selected' : ''; ?>>Ẩn</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" >
                        <div class="form-text">Chọn hình ảnh có kích thước tối đa 2MB, định dạng JPG, PNG, GIF.</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
// Xóa dữ liệu cũ sau khi hiển thị form
unset($_SESSION['old_data']);
?>