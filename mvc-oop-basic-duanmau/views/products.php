<div class="row mb-4">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <!-- Sidebar lọc sản phẩm -->
    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Lọc sản phẩm</h5>
            </div>
            <div class="card-body">
                <!-- Lọc theo danh mục -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Danh mục</h6>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="category<?php echo $category['id']; ?>" name="category[]" value="<?php echo $category['id']; ?>" <?php echo (isset($_GET['category']) && in_array($category['id'], $_GET['category'])) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="category<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không có danh mục nào.</p>
                    <?php endif; ?>
                </div>
                
                <!-- Lọc theo giá -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Giá</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="priceRange" id="price1">
                        <label class="form-check-label" for="price1">Dưới 1 triệu</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="priceRange" id="price2">
                        <label class="form-check-label" for="price2">1 - 3 triệu</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="priceRange" id="price3">
                        <label class="form-check-label" for="price3">3 - 5 triệu</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="priceRange" id="price4">
                        <label class="form-check-label" for="price4">5 - 10 triệu</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="priceRange" id="price5">
                        <label class="form-check-label" for="price5">Trên 10 triệu</label>
                    </div>
                </div>
                
                <!-- Lọc theo đánh giá -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Đánh giá</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rating" id="rating5">
                        <label class="form-check-label" for="rating5">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rating" id="rating4">
                        <label class="form-check-label" for="rating4">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                            trở lên
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rating" id="rating3">
                        <label class="form-check-label" for="rating3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                            trở lên
                        </label>
                    </div>
                </div>
                
                <button class="btn btn-primary w-100">Áp dụng</button>
            </div>
        </div>
    </div>
    
    <!-- Danh sách sản phẩm -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="text-muted">Hiển thị <?php echo count($products) ? '1-' . min(count($products), $limit) . ' của ' . $totalProducts : '0'; ?> sản phẩm</span>
            </div>
            <div class="d-flex align-items-center">
                <label for="sort" class="me-2">Sắp xếp:</label>
                <select class="form-select form-select-sm" id="sort" onchange="window.location.href=this.value">
                    <option value="index.php?act=products&sort=newest" <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>Mới nhất</option>
                    <option value="index.php?act=products&sort=price-asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price-asc') ? 'selected' : ''; ?>>Giá tăng dần</option>
                    <option value="index.php?act=products&sort=price-desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price-desc') ? 'selected' : ''; ?>>Giá giảm dần</option>
                    <option value="index.php?act=products&sort=name-asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name-asc') ? 'selected' : ''; ?>>Tên A-Z</option>
                    <option value="index.php?act=products&sort=name-desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name-desc') ? 'selected' : ''; ?>>Tên Z-A</option>
                </select>
            </div>
        </div>
        
        <div class="row g-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card product-card shadow-sm h-100">
                        <div class="position-relative">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x300?text=No+Image" class="card-img-top" alt="No Image">
                            <?php endif; ?>
                            <?php if ($product['sale_price'] > 0 && $product['sale_price'] < $product['price']): ?>
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-danger">-<?php echo round((($product['price'] - $product['sale_price']) / $product['price']) * 100); ?>%</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text text-truncate"><?php echo $product['description'] ?? 'Không có mô tả'; ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <?php if ($product['sale_price'] > 0): ?>
                                        <span class="text-danger fw-bold"><?php echo number_format($product['sale_price'], 0, ',', '.'); ?>đ</span>
                                        <br>
                                        <small class="text-decoration-line-through"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</small>
                                    <?php else: ?>
                                        <span class="text-danger fw-bold"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                                    <?php endif; ?>
                                </div>
                                <a href="index.php?act=product-detail&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">
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
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                    <h4>Không tìm thấy sản phẩm nào</h4>
                    <p class="text-muted">Vui lòng thử lại với bộ lọc khác hoặc xem tất cả sản phẩm.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Phân trang -->
        <?php if ($totalPages > 1): ?>
        <nav class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?act=products&page=<?php echo $page - 1; ?>" tabindex="-1" <?php echo ($page <= 1) ? 'aria-disabled="true"' : ''; ?>>Trước</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?act=products&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?act=products&page=<?php echo $page + 1; ?>" <?php echo ($page >= $totalPages) ? 'aria-disabled="true"' : ''; ?>>Sau</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>