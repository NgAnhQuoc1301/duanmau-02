<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Trang chủ'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1F2937;
            --secondary-color: #F5F5F5;
            --accent-color: #D97706;
            --text-color: #374151;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background-color: var(--secondary-color);
        }
        
        .navbar {
            background-color: var(--primary-color);
        }
        
        .navbar-brand, .nav-link {
            color: white !important;
        }
        
        .nav-link:hover {
            color: var(--accent-color) !important;
        }
        
        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-primary:hover {
            background-color: #B45309;
            border-color: #B45309;
        }
        
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
        }
        
        .product-card {
            transition: transform 0.3s;
            height: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .category-item {
            background-color: white;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .category-item:hover {
            background-color: var(--accent-color);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Shop Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=products">Sản phẩm</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Danh mục
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?act=category&id=1">Áo Thun</a></li>
                            <li><a class="dropdown-item" href="index.php?act=category&id=2">Sơ Mi</a></li>
                            <li><a class="dropdown-item" href="index.php?act=category&id=3">Quần Jeans</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="index.php?act=cart" class="btn btn-outline-light me-2">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                    </a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo $_SESSION['user_name']; ?>
                            </button>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                    <li><a class="dropdown-item" href="index.php?act=admin-products">Quản lý sản phẩm</a></li>
                                    <li><a class="dropdown-item" href="index.php?act=admin-categories">Quản lý danh mục</a></li>
                                    <li><a class="dropdown-item" href="index.php?act=admin-comments">Quản lý bình luận</a></li>
                                    <li><a class="dropdown-item" href="index.php?act=admin-users">Quản lý người dùng</a></li>
                                <?php endif; ?>
                                <hr>
                                <li><a class="dropdown-item" href="index.php?act=user-dashboard">Dashboard</a></li>
                                <li><a class="dropdown-item" href="index.php?act=user-profile">Hồ sơ</a></li>
                                <li><a class="dropdown-item" href="index.php?act=user-orders">Đơn hàng</a></li>
                                <li><a class="dropdown-item" href="index.php?act=user-favorites">Yêu thích</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?act=logout">Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="index.php?act=login" class="btn btn-outline-light me-2">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                        <a href="index.php?act=register" class="btn btn-outline-light">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <?php include $view; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Shop Online</h5>
                    <p>Cung cấp các sản phẩm chất lượng cao với giá cả hợp lý.</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Trang chủ</a></li>
                        <li><a href="index.php?act=products" class="text-white">Sản phẩm</a></li>
                        <li><a href="index.php?act=about" class="text-white">Giới thiệu</a></li>
                        <li><a href="index.php?act=contact" class="text-white">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <address>
                        <p><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, TP. HCM</p>
                        <p><i class="fas fa-phone"></i> (84) 123-456-789</p>
                        <p><i class="fas fa-envelope"></i> info@shoponline.com</p>
                    </address>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p>&copy; <?php echo date('Y'); ?> Shop Online. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>