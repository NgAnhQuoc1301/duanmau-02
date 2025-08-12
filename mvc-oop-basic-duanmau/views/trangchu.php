<!-- Banner/Slider -->
<div id="homeCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner rounded shadow">
        <div class="carousel-item active">
            <img src="https://via.placeholder.com/1200x400/1F2937/FFFFFF?text=Khuyến+mãi+đặc+biệt" class="d-block w-100" alt="Khuyến mãi đặc biệt">
            <div class="carousel-caption d-none d-md-block">
                <h2>Khuyến mãi đặc biệt</h2>
                <p>Giảm giá lên đến 50% cho các sản phẩm hot</p>
                <a href="index.php?act=products" class="btn btn-primary">Xem ngay</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/1200x400/374151/FFFFFF?text=Sản+phẩm+mới" class="d-block w-100" alt="Sản phẩm mới">
            <div class="carousel-caption d-none d-md-block">
                <h2>Sản phẩm mới</h2>
                <p>Khám phá các sản phẩm mới nhất của chúng tôi</p>
                <a href="index.php?act=products" class="btn btn-primary">Khám phá</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/1200x400/D97706/FFFFFF?text=Miễn+phí+vận+chuyển" class="d-block w-100" alt="Miễn phí vận chuyển">
            <div class="carousel-caption d-none d-md-block">
                <h2>Miễn phí vận chuyển</h2>
                <p>Cho tất cả đơn hàng trên 500.000đ</p>
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
    <h2 class="text-center mb-4">Danh mục nổi bật</h2>
    <div class="row g-4">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="index.php?act=category&id=<?php echo $category['id'] ?? 0; ?>" class="text-decoration-none">
                        <div class="category-item text-center p-4 shadow-sm">
                            <i class="fas fa-folder fa-3x mb-3 text-primary"></i>
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
                                <img src="https://via.placeholder.com/300x300?text=No+Image" class="card-img-top" alt="No Image">
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
            <div class="card bg-dark text-white overflow-hidden">
                <img src="https://via.placeholder.com/600x300/1F2937/FFFFFF?text=Khuyến+mãi+mùa+hè" class="card-img" alt="Khuyến mãi mùa hè">
                <div class="card-img-overlay d-flex flex-column justify-content-center">
                    <h3 class="card-title">Khuyến mãi mùa hè</h3>
                    <p class="card-text">Giảm giá đặc biệt cho tất cả sản phẩm mùa hè</p>
                    <a href="index.php?act=products" class="btn btn-primary mt-2 align-self-start">Xem ngay</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-dark text-white overflow-hidden">
                <img src="https://via.placeholder.com/600x300/D97706/FFFFFF?text=Sản+phẩm+độc+quyền" class="card-img" alt="Sản phẩm độc quyền">
                <div class="card-img-overlay d-flex flex-column justify-content-center">
                    <h3 class="card-title">Sản phẩm độc quyền</h3>
                    <p class="card-text">Khám phá các sản phẩm chỉ có tại cửa hàng chúng tôi</p>
                    <a href="index.php?act=products" class="btn btn-primary mt-2 align-self-start">Khám phá</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sản phẩm mới nhất -->
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sản phẩm mới nhất</h2>
        <a href="index.php?act=products" class="btn btn-outline-primary">Xem tất cả</a>
    </div>
    <div class="row g-4">
        <?php for($i = 9; $i <= 12; $i++): ?>
            <div class="col-6 col-md-3">
                <div class="card product-card shadow-sm h-100">
                    <img src="https://via.placeholder.com/300x300?text=New+Product+<?php echo $i; ?>" class="card-img-top" alt="New Product <?php echo $i; ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Sản phẩm mới <?php echo $i; ?></h5>
                        <p class="card-text text-truncate">Mô tả ngắn về sản phẩm mới <?php echo $i; ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="fw-bold">1.350.000đ</span>
                            <a href="index.php?act=product-detail&id=<?php echo $i; ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</section>
