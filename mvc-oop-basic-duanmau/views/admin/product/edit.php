<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Chỉnh sửa sản phẩm</h5>
        <a href="index.php?act=admin-products" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        <form action="index.php?act=admin-product-update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                            value="<?php echo $_SESSION['old_data']['name'] ?? $product['name'] ?? ''; ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="price" name="price" 
                                        value="<?php echo $_SESSION['old_data']['price'] ?? $product['price'] ?? ''; ?>" min="0" required>
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>
                        </div>

                        <!-- Xóa phần Giá khuyến mãi nếu không có trong DB -->
                        <!-- Nếu muốn giữ có thể dùng mặc định 0 hoặc để trống -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sale_price" class="form-label">Giá khuyến mãi</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="sale_price" name="sale_price" 
                                        value="<?php echo $_SESSION['old_data']['sale_price'] ?? ($product['sale_price'] ?? ''); ?>" min="0">
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo ((isset($_SESSION['old_data']['category_id']) ? $_SESSION['old_data']['category_id'] : ($product['category_id'] ?? '')) == $category['id']) ? 'selected' : ''; ?>>
                                    <?php echo $category['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Xóa phần trạng thái nếu DB không có -->
                    <!-- Nếu muốn giữ thì dùng mặc định 1 (Hiển thị) -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1" <?php echo ((isset($_SESSION['old_data']['status']) ? $_SESSION['old_data']['status'] : ($product['status'] ?? 1)) == 1) ? 'selected' : ''; ?>>Hiển thị</option>
                            <option value="0" <?php echo ((isset($_SESSION['old_data']['status']) ? $_SESSION['old_data']['status'] : ($product['status'] ?? 1)) == 0) ? 'selected' : ''; ?>>Ẩn</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                        <?php if (!empty($product['image'])): ?>
                            <div class="mb-2">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Chọn hình ảnh mới nếu muốn thay đổi. Bỏ trống nếu giữ nguyên hình ảnh hiện tại.</div>
                    </div>

                    <div class="mb-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
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
