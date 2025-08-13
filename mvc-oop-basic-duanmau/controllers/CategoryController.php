<?php
// Class chứa các function thực thi xử lý logic cho danh mục
class CategoryController
{
    public $modelCategory;

    public function __construct()
    {
        $this->modelCategory = new CategoryModel();
    }

    // Hiển thị danh sách danh mục với tìm kiếm và phân trang
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

    // Hiển thị form thêm danh mục
    public function create()
    {
        $title = "Thêm danh mục mới";
        $view = './views/admin/category/create.php';
        require_once './views/admin/layout.php';
    }

    // Xử lý thêm danh mục
    public function store()
    {
        $name = trim($_POST['name'] ?? '');
        $image = null;

        $errors = [];
        if (empty($name)) {
            $errors[] = "Tên danh mục không được để trống";
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            if (!in_array($ext, $allowed)) {
                $errors[] = "Chỉ chấp nhận file hình ảnh (jpg, jpeg, png, gif, webp)";
            } else {
                $image = uploadFile($_FILES['image'], '/uploads/categories/');
                if (!$image) {
                    $errors[] = "Không thể upload hình ảnh, vui lòng thử lại";
                }
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: index.php?act=admin-category-create');
            exit;
        }

        $result = $this->modelCategory->addCategory($name, null, $image);

        if ($result) {
            $_SESSION['success'] = "Thêm danh mục thành công";
        } else {
            $_SESSION['errors'] = ["Thêm danh mục thất bại"];
            if ($image) {
                deleteFile($image);
            }
        }

        header('Location: index.php?act=admin-categories');
        exit;
    }

    // Hiển thị form chỉnh sửa danh mục
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

    // Xử lý cập nhật danh mục
    public function update()
    {
        $id = $_POST['id'] ?? 0;
        $name = trim($_POST['name'] ?? '');
        $image = null;

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

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            if (!in_array($ext, $allowed)) {
                $errors[] = "Chỉ chấp nhận file hình ảnh (jpg, jpeg, png, gif, webp)";
            } else {
                $image = uploadFile($_FILES['image'], '/uploads/categories/');
                if (!$image) {
                    $errors[] = "Không thể upload hình ảnh, vui lòng thử lại";
                }
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: index.php?act=admin-category-edit&id=' . $id);
            exit;
        }

        $result = $this->modelCategory->updateCategory($id, $name, null, $image);

        if ($result) {
            if ($image && !empty($category['image'])) {
                deleteFile($category['image']);
            }
            $_SESSION['success'] = "Cập nhật danh mục thành công";
        } else {
            if ($image) {
                deleteFile($image);
            }
            $_SESSION['errors'] = ["Cập nhật danh mục thất bại"];
        }

        header('Location: index.php?act=admin-categories');
        exit;
    }

    // Xử lý xóa danh mục
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
}
