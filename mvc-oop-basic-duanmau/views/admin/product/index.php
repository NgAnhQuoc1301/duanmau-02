<?php
// Debug info
if (!isset($products)) {
    echo "<div class='alert alert-warning'>Biến \$products không được định nghĩa!</div>";
    $products = [];
}
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách sản phẩm</h5>
        <a href="index.php?act=admin-product-create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Thêm mới
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="10%">Hình ảnh</th>
                        <th width="20%">Tên sản phẩm</th>
                        <th width="10%">Giá</th>
                        <th width="10%">Giá KM</th>
                        <th width="15%">Danh mục</th>
                        <th width="10%">Trạng thái</th>
                        <th width="15%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td>
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" style="max-height: 50px;">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/50x50" alt="No Image" class="img-thumbnail">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $product['name']; ?></td>
                                <td><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</td>
                                <td>
                                        <?php 
                                        // Nếu không có sale_price trong db thì luôn hiển thị dấu "-" (có thể sửa nếu muốn)
                                        echo (isset($product['sale_price']) && $product['sale_price'] > 0) 
                                            ? number_format($product['sale_price'], 0, ',', '.') . 'đ' 
                                            : '-'; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        // Nếu không có trường status thì hiển thị dấu "-"
                                        echo isset($product['status']) 
                                            ? ($product['status'] == 1 ? 'Hiển thị' : 'Ẩn') 
                                            : '-'; 
                                        ?>
                                    </td>
                                <td>
                                    <a href="index.php?act=admin-product-edit&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index.php?act=admin-product-delete&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có sản phẩm nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
