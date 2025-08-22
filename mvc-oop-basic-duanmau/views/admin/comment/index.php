<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách bình luận</h5>
        <div>
            <a href="index.php?act=admin-comment-pending" class="btn btn-warning btn-sm me-2">
                <i class="fas fa-clock"></i> Chưa duyệt
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="20%">Người dùng</th>
                        <th width="25%">Sản phẩm</th>
                        <th width="40%">Nội dung</th>
                        <th width="10%">Đánh giá</th>
                        <th width="15%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td><?php echo $comment['id']; ?></td>
                                <td><?php echo $comment['user_name'] ?? 'Khách'; ?></td>
                                <td><?php echo $comment['product_name'] ?? 'N/A'; ?></td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;" title="<?php echo htmlspecialchars($comment['content']); ?>">
                                        <?php echo htmlspecialchars($comment['content']); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-warning">
                                        <?php 
                                        $rating = (isset($comment['rating']) && $comment['rating'] > 0) 
                                                ? (int)$comment['rating'] 
                                                : rand(1,5);
                                        for ($i = 1; $i <= 5; $i++): 
                                        ?>
                                            <i class="fas fa-star<?php echo ($i <= $rating) ? '' : '-o'; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="index.php?act=admin-comment-delete&id=<?php echo $comment['id']; ?>" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Không có bình luận nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
