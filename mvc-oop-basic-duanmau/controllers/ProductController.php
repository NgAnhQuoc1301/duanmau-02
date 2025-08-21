<?php
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
        $fullCategories = $this->modelCategory->getAllCategories();
        $categories = [];
        foreach ($fullCategories as $cat) {
            $categories[] = ['id' => $cat['id'], 'name' => $cat['name']];
        }
        $featuredProducts = $this->modelProduct->getAllProducts(8);
        $title = "Shop Online - Trang chủ";
        $view = './views/trangchu.php';
        require_once './views/layout.php';
    }

    public function Products()
{
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 12;
    $offset = ($page - 1) * $limit;

    // Lấy giá trị filter từ GET
    $selectedCategories = isset($_GET['category']) ? $_GET['category'] : [];
    $selectedPrice = isset($_GET['priceRange']) ? $_GET['priceRange'] : null;
    $selectedRating = isset($_GET['rating']) ? $_GET['rating'] : null;

    // Lấy tổng số sản phẩm (có filter)
    $productsFiltered = $this->modelProduct->getFilteredProducts($selectedCategories, $selectedPrice, $selectedRating, 100000, 0); 
    $totalProducts = count($productsFiltered);
    $totalPages = ceil($totalProducts / $limit);

    // Lấy sản phẩm hiển thị trang hiện tại
    $products = $this->modelProduct->getFilteredProducts($selectedCategories, $selectedPrice, $selectedRating, $limit, $offset);

    $categories = $this->modelCategory->getAllCategories();
    $title = "Shop Online - Tất cả sản phẩm";
    $view = './views/products.php';
    require_once './views/layout.php';
}

    public function ProductDetail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = $this->modelProduct->getProductById($id);
        if (!$product) {
            header('Location: index.php?act=products');
            exit;
        }
        $relatedProducts = $this->modelProduct->getProductsByCategory($product['category_id'], 4);
        $comments = $this->modelComment->getCommentsByProduct($id);
        $title = "Shop Online - " . $product['name'];
        $view = './views/product-detail.php';
        require_once './views/layout.php';
    }

    public function Category()
    {
        $category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $fullCategory = $this->modelCategory->getCategoryById($category_id);
        if (!$fullCategory) {
            header('Location: index.php?act=products');
            exit;
        }
        $category = ['id' => $fullCategory['id'], 'name' => $fullCategory['name']];
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;
        $products = $this->modelProduct->getProductsByCategory($category_id, $limit, $offset);
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

    public function adminProducts()
    {
        $title = "Quản lý sản phẩm";
        $products = $this->modelProduct->getAllProducts();
        $view = './views/admin/product/index.php';
        require_once './views/admin/layout.php';
    }

    public function createProduct()
    {
        $title = "Thêm sản phẩm mới";
        $categories = $this->modelCategory->getAllCategories();
        $view = './views/admin/product/create.php';
        require_once './views/admin/layout.php';
    }

    public function storeProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $sale_price = $_POST['sale_price'] ?? 0;
            $description = $_POST['description'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $status = $_POST['status'] ?? 1;

            // Upload ảnh
            $imagePath = null;
            if (!empty($_FILES['image']['name'])) {
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetPath = 'uploads/' . $fileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imagePath = $targetPath;
                }
            }

            $result = $this->modelProduct->addProduct($name, $price, $sale_price, $imagePath, $description, $category_id, $status);

            if ($result) {
                header('Location: index.php?act=admin-products');
                exit;
            } else {
                echo "Lỗi khi thêm sản phẩm.";
            }
        }
    }

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

    public function updateProduct()
    {
        $id = $_POST['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $sale_price = $_POST['sale_price'] ?? 0;
        $description = $_POST['description'] ?? '';
        $category_id = $_POST['category_id'] ?? null;
        $status = $_POST['status'] ?? 1;

        $errors = [];
        if (!$id) $errors[] = "ID sản phẩm không hợp lệ";
        if (!$name) $errors[] = "Tên sản phẩm không được để trống";
        if (!is_numeric($price) || $price < 0) $errors[] = "Giá sản phẩm không hợp lệ";
        if (!is_numeric($sale_price) || $sale_price < 0) $errors[] = "Giá khuyến mãi không hợp lệ";

        $category = $this->modelCategory->getCategoryById($category_id);
        if (!$category) $errors[] = "Danh mục không hợp lệ";

        $product = $this->modelProduct->getProductById($id);
        if (!$product) $errors[] = "Sản phẩm không tồn tại";

        $imagePath = $product['image']; // giữ ảnh cũ
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = 'uploads/' . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $targetPath;
                if ($product['image'] && file_exists($product['image'])) {
                    unlink($product['image']);
                }
            } else {
                $errors[] = "Không thể upload hình ảnh";
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: index.php?act=admin-product-edit&id=' . $id);
            exit;
        }

        $result = $this->modelProduct->updateProduct($id, $name, $price, $sale_price, $description, $category_id, $status, $imagePath);

        if ($result) {
            $_SESSION['success'] = "Cập nhật sản phẩm thành công";
        } else {
            $_SESSION['errors'] = ["Cập nhật sản phẩm thất bại"];
        }

        header('Location: index.php?act=admin-products');
        exit;
    }

    public function deleteProduct()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            $_SESSION['errors'] = ["ID sản phẩm không hợp lệ"];
            header('Location: index.php?act=admin-products');
            exit;
        }
        $result = $this->modelProduct->deleteProduct($id);
        if ($result) {
            $_SESSION['success'] = "Xóa sản phẩm thành công";
        } else {
            $_SESSION['errors'] = ["Xóa sản phẩm thất bại"];
        }
        header('Location: index.php?act=admin-products');
        exit;
    }
    // tìm kiếm sản phẩm
    public function searchProduct() {
    $keyword = $_GET['keyword'] ?? '';

    if (!empty($keyword)) {
        $products = $this->modelProduct->searchProducts($keyword);
    } else {
        $products = $this->modelProduct->getAllProducts();
    }

    $title = 'Quản lý sản phẩm';
    $view = './views/admin/product/index.php'; 
    require_once './views/admin/layout.php';
}

}

