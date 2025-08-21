<!-- Banner/Slider -->
<div id="homeCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
    <div id="homeCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <!-- Nút chuyển slide -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner rounded shadow">
        <div class="carousel-item active">
            <img src="uploads/image/slider_3.jpg" class="d-block w-100" alt="Khuyến mãi đặc biệt">
            <div class="carousel-caption d-none d-md-block">
                <a href="index.php?act=products" class="btn btn-primary">Xem ngay</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="uploads/image/banner.jpg" class="d-block w-100" alt="Sản phẩm mới">
            <div class="carousel-caption d-none d-md-block">
                <a href="index.php?act=products" class="btn btn-primary">Khám phá</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="uploads/image/slider_2.jpg" class="d-block w-100" alt="Miễn phí vận chuyển">
            <div class="carousel-caption d-none d-md-block">
                <a href="index.php?act=products" class="btn btn-primary">Mua sắm ngay</a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Danh mục nổi bật -->
<section class="mb-5">
    <h2 class="text-center mb-4">Danh Mục Sản Phẩm Nổi Bật</h2>
    <div class="row g-4">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="index.php?act=category&id=<?php echo $category['id'] ?? 0; ?>" class="text-decoration-none">
                        <div class="category-item text-center p-4 shadow-sm">
                            <h5><?php echo $category['name'] ?? 'Không tên'; ?></h5>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>Không có danh mục nào.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Sản phẩm nổi bật -->
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sản phẩm nổi bật</h2>
        <a href="index.php?act=products" class="btn btn-outline-primary">Xem tất cả</a>
    </div>
    <div class="row g-4">
        <?php if (!empty($featuredProducts)): ?>
            <?php foreach ($featuredProducts as $product): ?>
                <?php 
                    $id = $product['id'] ?? 0;
                    $name = $product['name'] ?? 'Không tên';
                    $image = $product['image'] ?? '';
                    $price = $product['price'] ?? 0;
                    $sale_price = $product['sale_price'] ?? 0;
                    $description = $product['description'] ?? 'Không có mô tả';
                ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card product-card shadow-sm h-100">
                        <div class="position-relative">
                            <?php if (!empty($image)): ?>
                                <img src="<?php echo $image; ?>" class="card-img-top" alt="<?php echo $name; ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <img src="uploads/image/slider_2.jpg" class="card-img-top" alt="No Image">
                            <?php endif; ?>

                            <?php if ($sale_price > 0 && $sale_price < $price): ?>
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-danger">
                                        -<?php echo round((($price - $sale_price) / $price) * 100); ?>%
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $name; ?></h5>
                            <p class="card-text text-truncate"><?php echo $description; ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <?php if ($sale_price > 0): ?>
                                        <span class="text-danger fw-bold"><?php echo number_format($sale_price, 0, ',', '.'); ?>đ</span>
                                        <span class="text-decoration-line-through text-muted small"><?php echo number_format($price, 0, ',', '.'); ?>đ</span>
                                    <?php else: ?>
                                        <span class="text-danger fw-bold"><?php echo number_format($price, 0, ',', '.'); ?>đ</span>
                                    <?php endif; ?>
                                </div>
                                <a href="index.php?act=product-detail&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-grid">
                            <button class="btn btn-primary">
                                <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>Không có sản phẩm nào.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Banner quảng cáo -->
<section class="mb-5">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card banner-card">
                <img src="uploads/image/quangcao.jpg" class="card-img-top" alt="Khuyến mãi mùa hè">
                <div class="card-body text-center">
                    <h5 class="card-title">Giảm giá nhân dịp sinh nhật</h5>
                    <p class="card-text">Đừng bỏ lỡ cơ hội mua sắm với giá ưu đãi</p>
                    <a href="index.php?act=products" class="btn btn-primary mt-2">Xem ngay</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card banner-card">
                <img src="uploads/image/image.png" class="card-img-top" alt="Sản phẩm độc quyền">
                <div class="card-body text-center">
                    <h5 class="card-title">Sản phẩm độc quyền</h5>
                    <p class="card-text">Khám phá các sản phẩm chỉ có tại cửa hàng chúng tôi</p>
                    <a href="index.php?act=products" class="btn btn-primary mt-2">Khám phá</a>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    /* ==== TRANG CHỦ (STYLE TRẮNG – ĐEN) ==== */

/* Tổng thể nền trắng, chữ đen */
body {
    background-color: #fff;
    color: #111;
    font-family: "Helvetica Neue", Arial, sans-serif;
}

/* Nút chung */
.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* Nút chính: nền đen – chữ trắng */
.btn-primary {
    background-color: #111;
    border-color: #111;
    color: #fff;
}
.btn-primary:hover {
    background-color: #fff;
    border-color: #111;
    color: #111;
}

/* ===== Carousel ===== */

/* Nút điều hướng carousel */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1); /* đổi icon trắng thành đen */
}

/* Chấm tròn điều hướng */
.carousel-indicators button {
    background-color: #aaa;
}
.carousel-indicators .active {
    background-color: #111;
}

/* ===== Card sản phẩm ===== */
.product-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

/* Ảnh sản phẩm */
.product-card img {
    transition: transform 0.4s ease, filter 0.4s ease;
}
.product-card:hover img {
    transform: scale(1.05);
    filter: brightness(90%);
}

/* Tên sản phẩm */
.product-card .card-title {
    color: #111;
    font-weight: 600;
}

/* Giá */
.product-card .price {
    color: #111;
    font-size: 1rem;
    font-weight: bold;
}
.product-card .old-price {
    color: #777;
    text-decoration: line-through;
    margin-left: 6px;
    font-size: 0.9rem;
}

/* Badge giảm giá */
.product-card .badge-sale {
    background-color: #111;
    color: #fff;
    font-size: 0.8rem;
    border-radius: 0;
}
.product-card:hover .badge-sale {
    background-color: #444;
}
/* Banner quảng cáo 2 bên bằng nhau */
.banner-card {
    height: 100%;
    border: none;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.banner-card img {
    width: 100%;
    height: 300px; /* chỉnh chiều cao ảnh */
    object-fit: cover; /* ảnh luôn đầy đủ khung */
}

.banner-card .card-body {
    flex-grow: 1;
    padding: 15px;
    background: #f8f9fa; /* nền sáng dưới ảnh */
    text-align: center;
}

.banner-card .card-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}
.btn-outline-primary {
    border: 1px solid #111;
    color: #fff;
    background-color: #111;
    transition: all 0.3s ease;
}
.btn-outline-primary:hover {
    background-color: #fff;
    color: #111;
}

</style>