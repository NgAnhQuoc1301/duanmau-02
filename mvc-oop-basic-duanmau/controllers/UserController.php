<?php
// Class chứa các function thực thi xử lý logic cho user dashboard
class UserController
{
    public $modelProduct;
    public $modelCategory;
    public $modelComment;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
        $this->modelCategory = new CategoryModel();
        $this->modelComment = new CommentModel();
    }

    // Dashboard cho user
    public function dashboard()
    {
        // Kiểm tra đăng nhập
        AuthController::requireUser();
        
        // Lấy thông tin user
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        
        // Lấy sản phẩm yêu thích (có thể là sản phẩm đã comment)
        $favorite_products = $this->modelProduct->getProductsByUserComments($user_id);
        
        // Lấy comment gần đây của user
        $recent_comments = $this->modelComment->getCommentsByUser($user_id, 5);
        
        // Lấy sản phẩm mới
        $new_products = $this->modelProduct->getNewProducts(6);
        
        // Lấy danh mục
        $categories = $this->modelCategory->getAllCategories();
        
        $title = "Dashboard - " . $user_name;
        $view = './views/user/dashboard.php';
        require_once './views/layout.php';
    }

    // Trang hồ sơ user
    public function profile()
    {
        // Kiểm tra đăng nhập
        AuthController::requireUser();
        
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        $user_email = $_SESSION['user_email'];
        
        $title = "Hồ sơ - " . $user_name;
        $view = './views/user/profile.php';
        require_once './views/layout.php';
    }

    // Trang đơn hàng của user
    public function orders()
    {
        // Kiểm tra đăng nhập
        AuthController::requireUser();
        
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        
        $title = "Đơn hàng của tôi";
        $view = './views/user/orders.php';
        require_once './views/layout.php';
    }

    // Trang sản phẩm yêu thích
    public function favorites()
    {
        // Kiểm tra đăng nhập
        AuthController::requireUser();
        
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        
        // Lấy sản phẩm yêu thích (dựa trên comment)
        $favorite_products = $this->modelProduct->getProductsByUserComments($user_id);
        
        $title = "Sản phẩm yêu thích";
        $view = './views/user/favorites.php';
        require_once './views/layout.php';
    }
}
?> 