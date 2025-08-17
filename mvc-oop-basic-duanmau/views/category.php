<div class="row mb-4">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?act=products">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $category['name'] ?? 'Danh mục sản phẩm'; ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Banner danh mục -->
<div class="mb-4">
    <div class="position-relative">
        <div class="bg-primary text-white p-5 rounded shadow">
            <div class="text-center">
                <h1 class="display-4 fw-bold"><?php echo $category['name'] ?? 'Danh mục sản phẩm'; ?></h1>
            </div>
        </div>
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
                <!-- Sidebar code giữ nguyên như cũ -->
                ...
                <button class="btn btn-primary w-100">Áp dụng</button>
            </div>
        </div>
    </div>
    
    <!-- Danh sách sản phẩm -->
    <div class="col-lg-9">
        <!-- Tiêu đề và sắp xếp -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><?php echo $category['name'] ?? 'Danh mục sản phẩm'; ?></h2>
                <?php
                    $start = ($page-1)*$limit + 1;
                    $end = min($page*$limit, $totalProducts);
                ?>
                <span class="text-muted">Hiển thị <?php echo ($totalProducts > 0) ? "$start - $end của $totalProducts sản phẩm" : '0 sản phẩm'; ?></span>
            </div>
            <div class="d-flex align-items-center">
                <label for="sort" class="me-2">Sắp xếp:</label>
                <select class="form-select form-select-sm" id="sort" onchange="window.location.href=this.value">
                    <?php
                        $sortOptions = [
                            'newest' => 'Mới nhất',
                            'price-asc' => 'Giá tăng dần',
                            'price-desc' => 'Giá giảm dần',
                            'name-asc' => 'Tên A-Z',
                            'name-desc' => 'Tên Z-A'
                        ];
                        $currentSort = $_GET['sort'] ?? 'newest';
                        foreach ($sortOptions as $key => $label) {
                            $selected = ($currentSort == $key) ? 'selected' : '';
                            echo '<option value="index.php?act=category&id=' . $category['id'] . '&sort=' . $key . '&page=' . $page . '" ' . $selected . '>' . $label . '</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        
        <!-- Hiển thị sản phẩm -->
        <div class="row g-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                <div class="col-md-4">
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
                            <button class="btn btn-primary" <?php echo ($product['status'] == 0) ? 'disabled' : ''; ?>>
                                <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                    <h4>Không tìm thấy sản phẩm nào trong danh mục này</h4>
                    <p class="text-muted">Vui lòng xem các danh mục khác hoặc quay lại sau.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Phân trang -->
        <?php if ($totalPages > 1): ?>
        <nav class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?act=category&id=<?php echo $category['id']; ?>&sort=<?php echo $currentSort; ?>&page=<?php echo $page - 1; ?>" tabindex="-1" <?php echo ($page <= 1) ? 'aria-disabled="true"' : ''; ?>>Trước</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?act=category&id=<?php echo $category['id']; ?>&sort=<?php echo $currentSort; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?act=category&id=<?php echo $category['id']; ?>&sort=<?php echo $currentSort; ?>&page=<?php echo $page + 1; ?>" <?php echo ($page >= $totalPages) ? 'aria-disabled="true"' : ''; ?>>Sau</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>
