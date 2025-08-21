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
        
        <div class="mb-4">
            <div class="d-flex align-items-center">
                <h3 class="text-danger me-3"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</h3>
            </div>
        </div>
        
        <div class="mb-4">
            <h5 class="mb-3">Mô tả:</h5>
            <p><?php echo $product['description'] ?? 'Không có mô tả'; ?></p>
        </div>

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

<?php
// Lấy dữ liệu bình luận đã duyệt cho sản phẩm này
$product_comments = $this->modelComment->getCommentsByProduct($product['id']);
$show_limit = 2; // chỉ hiện 2 bình luận đầu tiên
?>
<div id="comment-section" class="mb-5">
    <h4>Viết bình luận của bạn</h4>

    <?php if (isset($_SESSION['user_id'])): ?>
    <form id="commentForm">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <div class="mb-3">
            <textarea name="content" class="form-control" rows="3" placeholder="Nhập bình luận..." required></textarea>
        </div>
        <div class="mb-3 w-25">
            <select name="rating" class="form-select">
                <option value="5">5 ⭐</option>
                <option value="4">4 ⭐</option>
                <option value="3">3 ⭐</option>
                <option value="2">2 ⭐</option>
                <option value="1">1 ⭐</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Gửi bình luận</button>
    </form>
    <?php else: ?>
        <p class="text-muted">Vui lòng <a href="index.php?act=login">đăng nhập</a> để bình luận.</p>
    <?php endif; ?>

    <div id="comment-list" class="mt-4">
        <?php
        $total_comments = count($product_comments);
        foreach(array_slice($product_comments, 0, $show_limit) as $comment):
            $short_content = strlen($comment['content']) > 120 ? substr($comment['content'],0,120) . '...' : $comment['content'];
            $is_truncated = strlen($comment['content']) > 120;
        ?>
        <div class="border p-2 mb-2 comment-item">
            <strong><?php echo htmlspecialchars($comment['user_name']); ?></strong> - 
            <small><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></small>
            <div>
                <i class="fas fa-star text-warning"></i> <?php echo $comment['rating']; ?>/5
            </div>
            <p class="comment-content" data-full="<?php echo htmlspecialchars($comment['content']); ?>">
                <?php echo htmlspecialchars($short_content); ?>
                <?php if($is_truncated): ?>
                    <a href="#" class="toggle-comment">Xem thêm</a>
                <?php endif; ?>
            </p>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if($total_comments > $show_limit): ?>
        <button id="show-all-comments" class="btn btn-link p-0">Xem tất cả bình luận (<?php echo $total_comments; ?>)</button>
    <?php endif; ?>
</div>

<script>
document.getElementById('commentForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);

    fetch('index.php?act=comment-add', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            const commentList = document.getElementById('comment-list');
            const div = document.createElement('div');
            div.className = 'border p-2 mb-2 comment-item';

            let shortContent = data.content.length > 120 ? data.content.substr(0,120) + '...' : data.content;
            let toggle = data.content.length > 120 ? ' <a href="#" class="toggle-comment">Xem thêm</a>' : '';

            div.innerHTML = `<strong>${data.user_name}</strong> - <small>${data.created_at}</small>
                             <div><i class="fas fa-star text-warning"></i> ${data.rating}/5</div>
                             <p class="comment-content" data-full="${data.content}">${shortContent}${toggle}</p>`;
            commentList.prepend(div);
            form.reset();

            // Thêm sự kiện xem thêm cho bình luận mới
            div.querySelectorAll('.toggle-comment').forEach(link => {
                link.addEventListener('click', function(e){
                    e.preventDefault();
                    const p = this.closest('.comment-content');
                    p.textContent = p.dataset.full;
                });
            });
        } else {
            alert(data.errors?.join("\n") || "Có lỗi xảy ra, vui lòng thử lại!");
        }
    })
    .catch(err => {
        console.error(err);
        alert("Có lỗi xảy ra, vui lòng thử lại!");
    });
});

// Xem thêm nội dung bình luận
document.querySelectorAll('.toggle-comment').forEach(link => {
    link.addEventListener('click', function(e){
        e.preventDefault();
        const p = this.closest('.comment-content');
        p.textContent = p.dataset.full;
    });
});

// Hiển thị tất cả bình luận khi click
document.getElementById('show-all-comments')?.addEventListener('click', function() {
    const commentList = document.getElementById('comment-list');
    commentList.innerHTML = '';
    const allComments = <?php echo json_encode($product_comments); ?>;
    allComments.forEach(comment => {
        const div = document.createElement('div');
        div.className = 'border p-2 mb-2 comment-item';
        let shortContent = comment.content.length > 120 ? comment.content.substr(0,120) + '...' : comment.content;
        let toggle = comment.content.length > 120 ? ' <a href="#" class="toggle-comment">Xem thêm</a>' : '';
        div.innerHTML = `<strong>${comment.user_name}</strong> - <small>${new Date(comment.created_at).toLocaleString('vi-VN')}</small>
                         <div><i class="fas fa-star text-warning"></i> ${comment.rating}/5</div>
                         <p class="comment-content" data-full="${comment.content}">${shortContent}${toggle}</p>`;
        commentList.appendChild(div);
    });

    // Thêm sự kiện Xem thêm cho tất cả bình luận
    document.querySelectorAll('.toggle-comment').forEach(link => {
        link.addEventListener('click', function(e){
            e.preventDefault();
            const p = this.closest('.comment-content');
            p.textContent = p.dataset.full;
        });
    });

    this.style.display = 'none'; // ẩn nút sau khi show tất cả
});
</script>

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
<style>/* ==== WHITE & BLACK THEME ==== */
body {
    background-color: #fff;
    color: #000;
}

/* Tiêu đề */
h2, h3, h4, h5 {
    color: #000;
}

/* Nút chính */
.btn-primary {
    background-color: #000;
    border: 1px solid #000;
    color: #fff;
}
.btn-primary:hover {
    background-color: #fff;
    color: #000;
}

/* Nút danger (mua ngay) */
.btn-danger {
    background-color: #333;
    border: 1px solid #333;
    color: #fff;
}
.btn-danger:hover {
    background-color: #fff;
    color: #000;
}

/* Nút outline */
.btn-outline-secondary,
.btn-outline-primary {
    border: 1px solid #000;
    color: #000;
    background: transparent;
}
.btn-outline-secondary:hover,
.btn-outline-primary:hover {
    background: #000;
    color: #fff;
}

/* Input */
.form-control, .form-select {
    border: 1px solid #000;
    background: #fff;
    color: #000;
}
.form-control:focus, .form-select:focus {
    border-color: #000;
    box-shadow: none;
}

/* Card sản phẩm */
.product-card, .card {
    border: 1px solid #000;
    background: #fff;
    color: #000;
}
.product-card .card-title {
    color: #000;
}

/* Bình luận */
.comment-item {
    border: 1px solid #000 !important;
    background: #fff;
    color: #000;
}

/* Icon ngôi sao giữ màu vàng */
.fa-star, .fa-star-half-alt {
    color: #ffcc00 !important;
}

/* Link */
a {
    color: #000;
    text-decoration: none;
}
a:hover {
    text-decoration: underline;
}

/* Nút link (xem thêm bình luận) */
.btn-link {
    color: #000;
}
.btn-link:hover {
    text-decoration: underline;
    color: #333;
}

/* ==== FOOTER ==== */
footer {
    background: #000;
    color: #fff;
}
footer a {
    color: #fff;
}
footer a:hover {
    color: #ddd;
}

</style>