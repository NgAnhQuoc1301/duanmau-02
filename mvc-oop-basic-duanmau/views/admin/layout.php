<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Quản trị'; ?> - Shop Online</title>
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
        
        .sidebar {
            background-color: var(--primary-color);
            min-height: 100vh;
            color: white;
        }
        
        .sidebar .nav-link {
            color: white;
            padding: 0.5rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.25rem;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--accent-color);
        }
        
        .sidebar .nav-link i {
            width: 1.5rem;
            text-align: center;
            margin-right: 0.5rem;
        }
        
        .content-wrapper {
            min-height: 100vh;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-primary:hover {
            background-color: #B45309;
            border-color: #B45309;
        }
        
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="d-flex flex-column p-3">
                    <a href="index.php?act=admin-products" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <i class="fas fa-shopping-cart me-2"></i>
                        <span class="fs-4">Shop Admin</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="index.php?act=/" class="nav-link">
                                <i class="fas fa-home"></i> Trang chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?act=admin-categories" class="nav-link <?php echo (isset($_GET['act']) && strpos($_GET['act'], 'admin-categor') !== false) ? 'active' : ''; ?>">
                                <i class="fas fa-list"></i> Quản lý danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?act=admin-products" class="nav-link <?php echo (isset($_GET['act']) && strpos($_GET['act'], 'admin-product') !== false) ? 'active' : ''; ?>">
                                <i class="fas fa-box"></i> Quản lý sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?act=admin-comments" class="nav-link <?php echo (isset($_GET['act']) && strpos($_GET['act'], 'admin-comment') !== false) ? 'active' : ''; ?>">
                                <i class="fas fa-comments"></i> Quản lý bình luận
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?act=admin-users" class="nav-link <?php echo (isset($_GET['act']) && strpos($_GET['act'], 'admin-users') !== false) ? 'active' : ''; ?>">
                                <i class="fas fa-users"></i> Quản lý người dùng
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://via.placeholder.com/32" alt="Admin" width="32" height="32" class="rounded-circle me-2">
                            <strong><?php echo $_SESSION['user_name'] ?? 'Admin'; ?></strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?act=logout">Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main content -->
            <div class="col-md-9 col-lg-10 content-wrapper">
                <!-- Top navbar -->
                <nav class="navbar navbar-expand-lg navbar-light mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <span class="nav-link fw-bold"><?php echo $title ?? 'Dashboard'; ?></span>
                                </li>
                            </ul>
                            <form class="d-flex" action="index.php" method="get">
                                <input class="form-control me-2" name="keyword" type="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" value="<?php echo $_GET['keyword'] ?? ''; ?>">
                                <input type="hidden" name="act" value="search-product"> <!-- trỏ đến phương thức mới -->
                                <button class="btn btn-outline-primary" type="submit">Tìm</button>
                            </form>
                        </div>
                    </div>
                </nav>
                
                <!-- Content -->
                <div class="container-fluid">
                    <!-- Hiển thị thông báo lỗi nếu có -->
                    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['errors']); ?>
                    <?php endif; ?>
                    
                    <!-- Hiển thị thông báo thành công nếu có -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['success']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    
                    <!-- Nội dung chính -->
                    <?php include_once $view; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>