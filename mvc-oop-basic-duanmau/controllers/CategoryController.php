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
        
        // Lấy tham số tìm kiếm và phân trang
        $keyword = $_GET['keyword'] ?? '';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = 5; // Số danh mục trên mỗi trang
        
        // Lấy danh sách danh mục với phân trang và tìm kiếm
        $categories = $this->modelCategory->getAllCategories($keyword, $page, $limit);
        
        // Đếm tổng số danh mục để tính số trang
        $totalCategories = $this->modelCategory->countCategories($keyword);
        $totalPages = ceil($totalCategories / $limit);
        
        // Truyền dữ liệu sang view
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
        // Lấy dữ liệu từ form
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = null;

        // Validate dữ liệu
        $errors = [];
        if (empty($name)) {
            $errors[] = "Tên danh mục không được để trống";
        }

        // Xử lý upload hình ảnh nếu có
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Kiểm tra loại file
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            if (!in_array($ext, $allowed)) {
                $errors[] = "Chỉ chấp nhận file hình ảnh (jpg, jpeg, png, gif, webp)";
            } else {
                // Upload file
                $image = uploadFile($_FILES['image'], '/uploads/categories/');
                if (!$image) {
                    $errors[] = "Không thể upload hình ảnh, vui lòng thử lại";
                }
            }
        }

        // Nếu có lỗi, quay lại form với thông báo lỗi
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: index.php?act=admin-category-create');
            exit;
        }

        // Thêm danh mục vào database
        $result = $this->modelCategory->addCategory($name, $description, $image);

        // Chuyển hướng với thông báo phù hợp
        if ($result) {
            $_SESSION['success'] = "Thêm danh mục thành công";
        } else {
            $_SESSION['errors'] = ["Thêm danh mục thất bại"];
            // Xóa file ảnh đã upload nếu thêm thất bại
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
        // Lấy dữ liệu từ form
        $id = $_POST['id'] ?? 0;
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = null;

        // Validate dữ liệu
        $errors = [];
        if (empty($id)) {
            $errors[] = "ID danh mục không hợp lệ";
        }
        if (empty($name)) {
            $errors[] = "Tên danh mục không được để trống";
        }

        // Lấy thông tin danh mục hiện tại
        $category = $this->modelCategory->getCategoryById($id);
        if (!$category) {
            $errors[] = "Danh mục không tồn tại";
        }

        // Xử lý upload hình ảnh nếu có
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Kiểm tra loại file
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            if (!in_array($ext, $allowed)) {
                $errors[] = "Chỉ chấp nhận file hình ảnh (jpg, jpeg, png, gif, webp)";
            } else {
                // Upload file
                $image = uploadFile($_FILES['image'], '/uploads/categories/');
                if (!$image) {
                    $errors[] = "Không thể upload hình ảnh, vui lòng thử lại";
                }
            }
        }

        // Nếu có lỗi, quay lại form với thông báo lỗi
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: index.php?act=admin-category-edit&id=' . $id);
            exit;
        }

        // Cập nhật danh mục trong database
        $result = $this->modelCategory->updateCategory($id, $name, $description, $image);

        // Chuyển hướng với thông báo phù hợp
        if ($result) {
            // Nếu cập nhật thành công và có hình ảnh mới, xóa hình ảnh cũ
            if ($image && !empty($category['image'])) {
                deleteFile($category['image']);
            }
            $_SESSION['success'] = "Cập nhật danh mục thành công";
        } else {
            // Nếu cập nhật thất bại và đã upload hình ảnh mới, xóa hình ảnh mới
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

        // Validate dữ liệu
        if (empty($id)) {
            $_SESSION['errors'] = ["ID danh mục không hợp lệ"];
            header('Location: index.php?act=admin-categories');
            exit;
        }

        // Xóa danh mục
        $result = $this->modelCategory->deleteCategory($id);

        // Chuyển hướng với thông báo phù hợp
        if ($result) {
            $_SESSION['success'] = "Xóa danh mục thành công";
        } else {
            $_SESSION['errors'] = ["Xóa danh mục thất bại"];
        }

        header('Location: index.php?act=admin-categories');
        exit;
    }
}