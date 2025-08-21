<?php
// Bật hiển thị lỗi để debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Khởi tạo session nếu chưa có
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
require_once './models/CommentModel.php';
require_once './models/UserModel.php';

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/CommentController.php';
require_once './controllers/AuthController.php';
require_once './controllers/UserController.php';

// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // ===== FRONTEND ROUTES =====
    // Trang chủ
    '/'=>(new ProductController())->Home(),
    
    // Trang sản phẩm
    'products'=>(new ProductController())->Products(),
    
    // Trang chi tiết sản phẩm
    'product-detail'=>(new ProductController())->ProductDetail(),
    
    // Trang danh mục sản phẩm
    'category'=>(new CategoryController())->Category(),
    
    // Trang đăng nhập/đăng ký
    'login'=>(new AuthController())->showLogin(),
    'register'=>(new AuthController())->showRegister(),
    'auth-login'=>(new AuthController())->login(),
    'auth-register'=>(new AuthController())->register(),
    'logout'=>(new AuthController())->logout(),
    
    // ===== ADMIN ROUTES =====
    // Quản lý danh mục
    'admin-categories'=> (new CategoryController())->index(),
    'admin-category-create'=> (new CategoryController())->create(),
    'admin-category-store'=> (new CategoryController())->store(),
    'admin-category-edit'=> (new CategoryController())->edit(),
    'admin-category-update'=> (new CategoryController())->update(),
    'admin-category-delete'=> (new CategoryController())->delete(),
    
    // Quản lý sản phẩm
    'admin-products' =>(new ProductController())->adminProducts(),
    'admin-product-create'=> (new ProductController())->createProduct(),
    'admin-product-store'=> (new ProductController())->storeProduct(),
    'admin-product-edit'=> (new ProductController())->editProduct(),
    'admin-product-update'=> (new ProductController())->updateProduct(),
    'admin-product-delete'=> (new ProductController())->deleteProduct(),
    
    // ===== COMMENT ROUTES =====
    // Quản lý bình luận
    'admin-comments'=> (new CommentController())->index(),
    'admin-comment-pending'=> (new CommentController())->pending(),
    'admin-comment-approve'=> (new CommentController())->approve(),
    'admin-comment-reject'=> (new CommentController())->reject(),
    'admin-comment-edit'=> (new CommentController())->edit(),
    'admin-comment-update'=> (new CommentController())->update(),
    'admin-comment-delete'=> (new CommentController())->delete(),
    'comment-add'=>(new CommentController())->add(),
    // Quản lý người dùng
    'admin-users'=> (new UserController())->index(),
    'search-product'  => (new ProductController())->searchProduct(),
    'admin-user-create'=> (new UserController())->create(),
    'admin-user-store'=> (new UserController())->store(),
    'admin-user-edit'=> (new UserController())->edit(),
    'admin-user-update'=> (new UserController())->update(),

    
    // ===== USER ROUTES =====
    'user-dashboard'=> (new UserController())->dashboard(),
    'user-profile'=> (new UserController())->profile(),
    // 'user-orders'=> (new UserController())->orders(),
    // 'user-favorites'=> (new UserController())->favorites(),
    
    
    // Mặc định về trang chủ
    default => (new ProductController())->Home(),
};
?>