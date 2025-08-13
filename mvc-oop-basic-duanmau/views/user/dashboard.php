<?php
// Khởi tạo các biến nếu chưa có để tránh cảnh báo
$user_name = $user_name ?? '';
$favorite_products = $favorite_products ?? [];
$recent_comments = $recent_comments ?? [];
$new_products = $new_products ?? [];
?>
<div class="container mt-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fas fa-user-circle me-2"></i>
                        Chào mừng, <?php echo htmlspecialchars($user_name); ?>!
                    </h2>
                    <p class="card-text">Đây là trang dashboard cá nhân của bạn. Bạn có thể xem sản phẩm yêu thích, comment gần đây và các sản phẩm mới.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sản phẩm yêu thích -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-heart text-danger me-2"></i>
                        Sản phẩm yêu thích
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($favorite_products)): ?>
                        <div class="row g-3">
                            <?php foreach ($favorite_products as $product): ?>
                                <div class="col-6">
                                    <div class="card product-card h-100">
                                        <div class="position-relative">
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" style="height: 120px; object-fit: cover;">
                                            <?php else: ?>
                                                <img src="https://via.placeholder.com/200x120?text=No+Image" class="card-img-top" alt="No Image">
                                            <?php endif; ?>
                                            <?php if ($product['sale_price'] > 0 && $product['sale_price'] < $product['price']): ?>
                                                <div class="position-absolute top-0 end-0 p-1">
                                                    <span class="badge bg-danger">-<?php echo round((($product['price'] - $product['sale_price']) / $product['price']) * 100); ?>%</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body p-2">
                                            <h6 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h6>
                                            <div class="d-flex justify-content-between align-items-center">
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
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-heart-broken text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Bạn chưa có sản phẩm yêu thích nào</p>
                            <a href="index.php?act=products" class="btn btn-primary">Khám phá sản phẩm</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Comment gần đây -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-comments text-info me-2"></i>
                        Bình luận gần đây
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_comments)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recent_comments as $comment): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?php echo htmlspecialchars($comment['product_name']); ?></h6>
                                            <p class="mb-1 text-muted"><?php echo htmlspecialchars(substr($comment['content'], 0, 100)) . (strlen($comment['content']) > 100 ? '...' : ''); ?></p>
                                            <small class="text-muted">
                                                <i class="fas fa-star text-warning"></i>
                                                <?php echo $comment['rating']; ?>/5 - 
                                                <?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?>
                                            </small>
                                        </div>
                                        <a href="index.php?act=product-detail&id=<?php echo $comment['product_id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-comment-slash text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Bạn chưa có bình luận nào</p>
                            <a href="index.php?act=products" class="btn btn-primary">Viết bình luận đầu tiên</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm mới -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-star text-warning me-2"></i>
                        Sản phẩm mới
                    </h5>
                    <a href="index.php?act=products" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php foreach ($new_products as $product): ?>
                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="card product-card h-100">
                                    <div class="position-relative">
                                        <?php if (!empty($product['image'])): ?>
                                            <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" style="height: 120px; object-fit: cover;">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/200x120?text=No+Image" class="card-img-top" alt="No Image">
                                        <?php endif; ?>
                                        <?php if ($product['sale_price'] > 0 && $product['sale_price'] < $product['price']): ?>
                                            <div class="position-absolute top-0 end-0 p-1">
                                                <span class="badge bg-danger">-<?php echo round((($product['price'] - $product['sale_price']) / $product['price']) * 100); ?>%</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h6>
                                        <div class="d-flex justify-content-between align-items-center">
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
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 