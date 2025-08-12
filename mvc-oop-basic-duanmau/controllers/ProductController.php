<?php
// có class chứa các function thực thi xử lý logic 
class ProductController
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

    public function Home()
    {
        // Lấy danh sách danh mục
        $fullCategories = $this->modelCategory->getAllCategories();
        
        // Chỉ lấy id và name của danh mục
        $categories = [];
        foreach ($fullCategories as $cat) {
            $categories[] = [
                'id' => $cat['id'],
                'name' => $cat['name']
            ];
        }
        
        // Lấy danh sách sản phẩm nổi bật (8 sản phẩm mới nhất)
        $featuredProducts = $this->modelProduct->getAllProducts(8);
        
        $title = "Shop Online - Trang chủ";
        $view = './views/trangchu.php';
        require_once './views/layout.php';
    }
    
    public function Products()
    {
        // Phân trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12; // Số sản phẩm trên mỗi trang
        $offset = ($page - 1) * $limit;
        
        // Lấy tổng số sản phẩm
        $totalProducts = $this->modelProduct->countProducts();
        $totalPages = ceil($totalProducts / $limit);
        
        // Lấy danh sách sản phẩm theo phân trang
        $products = $this->modelProduct->getAllProducts($limit, $offset);
        
        // Lấy danh sách danh mục để hiển thị bộ lọc
        $categories = $this->modelCategory->getAllCategories();
        
        $title = "Shop Online - Tất cả sản phẩm";
        $view = './views/products.php';
        require_once './views/layout.php';
    }
    
    public function ProductDetail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        // Lấy thông tin sản phẩm theo ID
        $product = $this->modelProduct->getProductById($id);
        
        if (!$product) {
            // Nếu không tìm thấy sản phẩm, chuyển hướng về trang sản phẩm
            header('Location: index.php?act=products');
            exit;
        }
        
        // Lấy các sản phẩm liên quan (cùng danh mục)
        $relatedProducts = $this->modelProduct->getProductsByCategory($product['category_id'], 4);
        
        // Lấy bình luận của sản phẩm
        $comments = $this->modelComment->getCommentsByProduct($id);
        
        $title = "Shop Online - " . $product['name'];
        $view = './views/product-detail.php';
        require_once './views/layout.php';
    }
    
    public function Category()
    {
        $category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        // Lấy thông tin danh mục
        $fullCategory = $this->modelCategory->getCategoryById($category_id);
        
        if (!$fullCategory) {
            // Nếu không tìm thấy danh mục, chuyển hướng về trang sản phẩm
            header('Location: index.php?act=products');
            exit;
        }
        
        // Chỉ lấy id và name của danh mục
        $category = [
            'id' => $fullCategory['id'],
            'name' => $fullCategory['name']
        ];
        
        // Phân trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12; // Số sản phẩm trên mỗi trang
        $offset = ($page - 1) * $limit;
        
        // Lấy sản phẩm theo danh mục và phân trang
        $products = $this->modelProduct->getProductsByCategory($category_id, $limit, $offset);
        
        // Lấy tổng số sản phẩm trong danh mục
        $totalProducts = count($this->modelProduct->getProductsByCategory($category_id));
        $totalPages = ceil($totalProducts / $limit);
        
        $title = "Shop Online - " . $category['name'];
        $view = './views/category.php';
        require_once './views/layout.php';
    }
    
    public function Login()
    {
        $title = "Shop Online - Đăng nhập";
        $view = './views/auth.php';
        require_once './views/layout.php';
    }
    
    public function Register()
    {
        $title = "Shop Online - Đăng ký";
        $view = './views/auth.php';
        require_once './views/layout.php';
    }
    
    // ===== ADMIN PRODUCT MANAGEMENT =====
    
    // Hiển thị danh sách sản phẩm trong admin
    public function adminProducts()
    {
        $title = "Quản lý sản phẩm";
        $products = $this->modelProduct->getAllProducts();
        $view = './views/admin/product/index.php';
        require_once './views/admin/layout.php';
    }
    
    // Hiển thị form thêm sản phẩm
    public function createProduct()
    {
        $title = "Thêm sản phẩm mới";
        $categories = $this->modelCategory->getAllCategories();
        $view = './views/admin/product/create.php';
        require_once './views/admin/layout.php';
    }
    
    // Xử lý thêm sản phẩm
    public function storeProduct()
    {
        // Lấy dữ liệu từ form
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $sale_price = $_POST['sale_price'] ?? 0;
        $description = $_POST['description'] ?? '';
        $category_id = $_POST['category_id'] ?? 0;
        $status = $_POST['status'] ?? 1;
        $image = null;
        
        // Validate dữ liệu
        $errors = [];
        if (empty($name)) {
            $errors[] = "Tên sản phẩm không được để trống";
        }
        if (!is_numeric($price) || $price < 0) {
            $errors[] = "Giá sản phẩm không hợp lệ";
        }
        if (!is_numeric($sale_price) || $sale_price < 0) {
            $errors[] = "Giá khuyến mãi không hợp lệ";
        }
        if (empty($category_id)) {
            $errors[] = "Vui lòng chọn danh mục";
        }
        
        // Thêm sản phẩm vào database
        $result = $this->modelProduct->addProduct($name, $price, $sale_price, $image, $description, $category_id, $status);
        
        // Chuyển hướng với thông báo phù hợp
        if ($result) {
            $_SESSION['success'] = "Thêm sản phẩm thành công";
        } else {
            $_SESSION['errors'] = ["Thêm sản phẩm thất bại"];
        }
        
        header('Location: index.php?act=admin-products');
        exit;
    }
    
    // Hiển thị form chỉnh sửa sản phẩm
    public function editProduct()
    {
        $id = $_GET['id'] ?? 0;
        $product = $this->modelProduct->getProductById($id);
        
        if (!$product) {
            $_SESSION['errors'] = ["Sản phẩm không tồn tại"];
            header('Location: index.php?act=admin-products');
            exit;
        }
        
        $title = "Chỉnh sửa sản phẩm";
        $categories = $this->modelCategory->getAllCategories();
        $view = './views/admin/product/edit.php';
        require_once './views/admin/layout.php';
    }
    
    // Xử lý cập nhật sản phẩm
    public function updateProduct()
{
    // Lấy dữ liệu từ form
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $sale_price = $_POST['sale_price'] ?? 0;
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'] ?? 0;
    $status = $_POST['status'] ?? 1;
    $image = null;

    // Validate dữ liệu
    $errors = [];
    if (empty($id)) {
        $errors[] = "ID sản phẩm không hợp lệ";
    }
    if (empty($name)) {
        $errors[] = "Tên sản phẩm không được để trống";
    }
    if (!is_numeric($price) || $price < 0) {
        $errors[] = "Giá sản phẩm không hợp lệ";
    }
    if (!is_numeric($sale_price) || $sale_price < 0) {
        $errors[] = "Giá khuyến mãi không hợp lệ";
    }
    if (empty($category_id)) {
        $errors[] = "Vui lòng chọn danh mục";
    } else {
        // Thêm kiểm tra category_id tồn tại trong bảng categories
        $category = $this->modelCategory->getCategoryById($category_id);
        if (!$category) {
            $errors[] = "Danh mục không hợp lệ";
        }
    }

    // Lấy thông tin sản phẩm hiện tại
    $product = $this->modelProduct->getProductById($id);
    if (!$product) {
        $errors[] = "Sản phẩm không tồn tại";
    }

    // Xử lý upload hình ảnh nếu có
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = uploadFile($_FILES['image'], 'uploads/imgproduct/');
        if (!$image) {
            $errors[] = "Không thể upload hình ảnh";
        }

        // Xóa hình ảnh cũ nếu có
        if ($product && $product['image']) {
            deleteFile($product['image']);
        }
    }

    // Nếu có lỗi, quay lại form với thông báo lỗi
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header('Location: index.php?act=admin-product-edit&id=' . $id);
        exit;
    }

    // Cập nhật sản phẩm trong database
    $result = $this->modelProduct->updateProduct($id, $name, $price, $sale_price, $description, $category_id, $status, $image);

    // Chuyển hướng với thông báo phù hợp
    if ($result) {
        $_SESSION['success'] = "Cập nhật sản phẩm thành công";
    } else {
        $_SESSION['errors'] = ["Cập nhật sản phẩm thất bại"];
    }

    header('Location: index.php?act=admin-products');
    exit;
}
    
    // Xử lý xóa sản phẩm
    public function deleteProduct()
    {
        $id = $_GET['id'] ?? 0;
        
        // Validate dữ liệu
        if (empty($id)) {
            $_SESSION['errors'] = ["ID sản phẩm không hợp lệ"];
            header('Location: index.php?act=admin-products');
            exit;
        }
        
        // Xóa sản phẩm
        $result = $this->modelProduct->deleteProduct($id);
        
        // Chuyển hướng với thông báo phù hợp
        if ($result) {
            $_SESSION['success'] = "Xóa sản phẩm thành công";
        } else {
            $_SESSION['errors'] = ["Xóa sản phẩm thất bại"];
        }
        
        header('Location: index.php?act=admin-products');
        exit;
    }
}
