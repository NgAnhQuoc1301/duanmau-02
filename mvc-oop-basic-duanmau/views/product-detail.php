<!-- Chi tiết sản phẩm -->
<div class="row mb-5">
    <!-- Hình ảnh sản phẩm -->
    <div class="col-md-5 mb-4 mb-md-0">
        <div class="position-relative mb-3">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner rounded shadow">
                    <div class="carousel-item active">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?php echo $product['image']; ?>" class="d-block w-100" alt="<?php echo $product['name']; ?>" style="height: 400px; object-fit: contain;">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/600x600?text=No+Image" class="d-block w-100" alt="No Image">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Thông tin sản phẩm -->
    <div class="col-md-7">
        <h2 class="mb-3"><?php echo $product['name']; ?></h2>
        
        <div class="d-flex align-items-center mb-3">
            <div class="me-3">
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star-half-alt text-warning"></i>
                <span class="ms-1">4.5</span>
            </div>
            <div class="me-3 text-muted">|</div>
            <div class="me-3">
                <span class="text-muted">Danh mục: </span>
                <?php if (isset($category)): ?>
                <a href="index.php?act=category&id=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a>
                <?php else: ?>
                <span>Chưa phân loại</span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Chỉ hiển thị giá gốc, không có sale_price -->
        <div class="mb-4">
            <div class="d-flex align-items-center">
                <h3 class="text-danger me-3"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</h3>
            </div>
        </div>
        
        <div class="mb-4">
            <h5 class="mb-3">Mô tả:</h5>
            <p><?php echo $product['description'] ?? 'Không có mô tả'; ?></p>
        </div>
        
        <!-- Đã xóa phần trạng thái -->

        <div class="mb-4">
            <h5 class="mb-3">Số lượng:</h5>
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-secondary" onclick="decrementQuantity()">-</button>
                <input type="number" id="quantity" class="form-control mx-2" value="1" min="1" style="width: 70px;">
                <button class="btn btn-outline-secondary" onclick="incrementQuantity()">+</button>
            </div>
        </div>
        
        <div class="d-flex gap-2 mb-4">
            <button class="btn btn-primary btn-lg flex-grow-1">
                <i class="fas fa-cart-plus me-2"></i> Thêm vào giỏ hàng
            </button>
            <button class="btn btn-danger btn-lg flex-grow-1">
                Mua ngay
            </button>
        </div>
        
        <div class="d-flex gap-3">
            <button class="btn btn-outline-secondary">
                <i class="far fa-heart"></i> Yêu thích
            </button>
            <button class="btn btn-outline-secondary">
                <i class="fas fa-share-alt"></i> Chia sẻ
            </button>
        </div>
    </div>
</div>

<!-- Sản phẩm liên quan -->
<?php if (!empty($relatedProducts)): ?>
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Sản phẩm liên quan</h3>
        <?php if (isset($category)): ?>
        <a href="index.php?act=category&id=<?php echo $category['id']; ?>" class="btn btn-outline-primary">Xem thêm</a>
        <?php else: ?>
        <a href="index.php?act=products" class="btn btn-outline-primary">Xem tất cả</a>
        <?php endif; ?>
    </div>
    <div class="row g-4">
        <?php foreach($relatedProducts as $relatedProduct): ?>
        <div class="col-6 col-md-3">
            <div class="card product-card shadow-sm h-100">
                <div class="position-relative">
                    <?php if (!empty($relatedProduct['image'])): ?>
                        <img src="<?php echo $relatedProduct['image']; ?>" class="card-img-top" alt="<?php echo $relatedProduct['name']; ?>" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x300?text=No+Image" class="card-img-top" alt="No Image">
                    <?php endif; ?>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo $relatedProduct['name']; ?></h5>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div>
                            <span class="text-danger fw-bold"><?php echo number_format($relatedProduct['price'], 0, ',', '.'); ?>đ</span>
                        </div>
                        <a href="index.php?act=product-detail&id=<?php echo $relatedProduct['id']; ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<script>
function decrementQuantity() {
    const qtyInput = document.getElementById('quantity');
    let current = parseInt(qtyInput.value);
    if (current > 1) {
        qtyInput.value = current - 1;
    }
}
function incrementQuantity() {
    const qtyInput = document.getElementById('quantity');
    let current = parseInt(qtyInput.value);
    qtyInput.value = current + 1;
}
</script>
