<?php
class CategoryController
{
    public $modelCategory;
    public $modelProduct; // thêm model Product để lấy sản phẩm theo category

    public function __construct()
    {
        $this->modelCategory = new CategoryModel();
        $this->modelProduct = new ProductModel();
    }

    // Trang danh mục sản phẩm (frontend)
    public function view()
    {
        $id = $_GET['id'] ?? 0;
        $category = $this->modelCategory->getCategoryById($id);

        if (!$category) {
            $_SESSION['errors'] = ["Danh mục không tồn tại"];
            header('Location: index.php?act=products');
            exit;
        }

        // Xử lý phân trang
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = 9;

        // Xử lý sắp xếp
        $sort = $_GET['sort'] ?? 'newest';
        switch($sort) {
            case 'price-asc': $orderBy = 'price ASC'; break;
            case 'price-desc': $orderBy = 'price DESC'; break;
            case 'name-asc': $orderBy = 'name ASC'; break;
            case 'name-desc': $orderBy = 'name DESC'; break;
            case 'newest':
            default: $orderBy = 'created_at DESC'; break;
        }

        // Lấy sản phẩm theo category + sắp xếp
        $products = $this->modelProduct->getProductsByCategory($id, $orderBy);

        // Tổng số sản phẩm và phân trang
        $totalProducts = count($products);
        $totalPages = ceil($totalProducts / $limit);
        $products = array_slice($products, ($page - 1) * $limit, $limit);

        $view = './views/frontend/category/view.php';
        require_once './views/frontend/layout.php';
    }

    // Các hàm admin giữ nguyên (index, create, store, edit, update, delete)
    public function index()
    {
        $title = "Quản lý danh mục";
        
        $keyword = $_GET['keyword'] ?? '';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = 5;
        
        $categories = $this->modelCategory->getAllCategories($keyword, $page, $limit);
        $totalCategories = $this->modelCategory->countCategories($keyword);
        $totalPages = ceil($totalCategories / $limit);
        
        $view = './views/admin/category/index.php';
        require_once './views/admin/layout.php';
    }

    public function create()
    {
        $title = "Thêm danh mục mới";
        $view = './views/admin/category/create.php';
        require_once './views/admin/layout.php';
    }

    public function store()
    {
        $name = trim($_POST['name'] ?? '');
        $errors = [];

        if (empty($name)) {
            $errors[] = "Tên danh mục không được để trống";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: index.php?act=admin-category-create');
            exit;
        }

        $result = $this->modelCategory->addCategory($name);

        if ($result) {
            $_SESSION['success'] = "Thêm danh mục thành công";
        } else {
            $_SESSION['errors'] = ["Thêm danh mục thất bại"];
        }

        header('Location: index.php?act=admin-categories');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $category = $this->modelCategory->getCategoryById($id);

        if (!$category) {
            $_SESSION['errors'] = ["Danh mục không tồn tại"];
            header('Location: index.php?act=admin-categories');
            exit;
        }

        $title = "Chỉnh sửa danh mục";
        $view = './views/admin/category/edit.php';
        require_once './views/admin/layout.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? 0;
        $name = trim($_POST['name'] ?? '');
        $errors = [];

        if (empty($id)) {
            $errors[] = "ID danh mục không hợp lệ";
        }
        if (empty($name)) {
            $errors[] = "Tên danh mục không được để trống";
        }

        $category = $this->modelCategory->getCategoryById($id);
        if (!$category) {
            $errors[] = "Danh mục không tồn tại";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: index.php?act=admin-category-edit&id=' . $id);
            exit;
        }

        $result = $this->modelCategory->updateCategory($id, $name);

        if ($result) {
            $_SESSION['success'] = "Cập nhật danh mục thành công";
        } else {
            $_SESSION['errors'] = ["Cập nhật danh mục thất bại"];
        }

        header('Location: index.php?act=admin-categories');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        if (empty($id)) {
            $_SESSION['errors'] = ["ID danh mục không hợp lệ"];
            header('Location: index.php?act=admin-categories');
            exit;
        }

        $result = $this->modelCategory->deleteCategory($id);

        if ($result) {
            $_SESSION['success'] = "Xóa danh mục thành công";
        } else {
            $_SESSION['errors'] = ["Xóa danh mục thất bại"];
        }

        header('Location: index.php?act=admin-categories');
        exit;
    }
     public function category() {
        $categoryId = $_GET['id'] ?? null;
        $page = $_GET['page'] ?? 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $sort = $_GET['sort'] ?? 'newest';

        $productModel = new ProductModel();
        $products = $productModel->getProductsByCategory($categoryId, $sort, $limit, $offset);

        include "views/category.php";
    }

}
