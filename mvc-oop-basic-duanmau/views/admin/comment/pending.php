<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Bình luận chờ duyệt</h5>
        <a href="index.php?act=admin-comments" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại tất cả bình luận
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Người dùng</th>
                        <th width="20%">Sản phẩm</th>
                        <th width="35%">Nội dung</th>
                        <th width="10%">Đánh giá</th>
                        <th width="15%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <?php if (($comment['status'] ?? -1) === 0): ?>
                                <tr>
                                    <td><?= $comment['id'] ?></td>
                                    <td><?= $comment['user_name'] ?? 'Khách' ?></td>
                                    <td><?= $comment['product_name'] ?? 'N/A' ?></td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 300px;" title="<?= htmlspecialchars($comment['content']) ?>">
                                            <?= htmlspecialchars($comment['content']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-warning">
                                            <?php
                                            $rating = isset($comment['rating']) ? (int)$comment['rating'] : 0;
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo ($i <= $rating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="index.php?act=admin-comment-approve&id=<?= $comment['id'] ?>" class="btn btn-success btn-sm" title="Duyệt">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="index.php?act=admin-comment-reject&id=<?= $comment['id'] ?>" class="btn btn-warning btn-sm" title="Từ chối">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Không có bình luận chờ duyệt</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
