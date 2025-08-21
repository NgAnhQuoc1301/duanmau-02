<?php
class UserController
{
    public $modelUser;

    public function __construct()
    {
        $this->modelUser = new UserModel();
    }

    // Hiển thị danh sách user
    public function index()
    {
        AuthController::requireAdmin();

        $keyword = $_GET['keyword'] ?? '';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = 5;

        $users = $this->modelUser->getAllUsers($keyword, $page, $limit);
        $totalUsers = $this->modelUser->countUsers($keyword);
        $totalPages = ceil($totalUsers / $limit);

        $title = "Quản lý người dùng";
        $view = './views/admin/user/index.php';
        require_once './views/admin/layout.php';
    }

    // Thêm user mới
    public function create()
    {
        AuthController::requireAdmin();

        $title = "Thêm người dùng mới";
        $view = './views/admin/user/create.php';
        require_once './views/admin/layout.php';
    }

    // Xử lý thêm người dùng mới
    public function store()
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? 'user';

        $errors = [];

        if (empty($username)) $errors[] = "Tên người dùng không được để trống";
        if (empty($email)) $errors[] = "Email không được để trống";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ";
        if (empty($password)) $errors[] = "Mật khẩu không được để trống";
        if ($password !== $confirm_password) $errors[] = "Xác nhận mật khẩu không khớp";

        if ($this->modelUser->getUserByEmail($email)) {
            $errors[] = "Email đã được sử dụng";
        }

        if ($this->modelUser->getUserByUsername($username)) {
             $errors[] = "Tên người dùng đã được sử dụng";
    }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: index.php?act=admin-user-create');
            exit;
        }

        $result = $this->modelUser->addUser($username, $email, $password, $role);

        if ($result) {
            $_SESSION['success'] = "Thêm người dùng thành công";
        } else {
            $_SESSION['errors'] = ["Thêm người dùng thất bại"];
        }

        header('Location: index.php?act=admin-users');
        exit;
    }

    // Edit user
    public function edit()
    {
        AuthController::requireAdmin();

        $id = $_GET['id'] ?? 0;
        $user = $this->modelUser->getUserById($id);
        if (!$user) {
            $_SESSION['errors'] = ["Người dùng không tồn tại"];
            header("Location: index.php?act=admin-users");
            exit;
        }

        $title = "Chỉnh sửa người dùng";
        $view = './views/admin/user/edit.php';
        require_once './views/admin/layout.php';
    }

    public function update()
{
    $id = $_POST['id'] ?? 0;
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? null; // role từ form
    $errors = [];

    if (!$id) $errors[] = "ID người dùng không hợp lệ";
    if (!$username) $errors[] = "Tên đăng nhập không được để trống";
    if (!$email) $errors[] = "Email không được để trống";

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: index.php?act=admin-user-edit&id=$id");
        exit;
    }

    // Lấy user cũ
    $oldUser = $this->modelUser->getUserById($id);
    if (!$oldUser) {
        $_SESSION['errors'] = ["Người dùng không tồn tại"];
        header("Location: index.php?act=admin-users");
        exit;
    }

    // Nếu role null thì giữ role cũ
    if (!$role) {
        $role = $oldUser['role'];
    }

    $result = $this->modelUser->updateUser($id, $username, $email, $role);

    if ($result) {
        $_SESSION['success'] = "Cập nhật người dùng thành công";
    } else {
        $_SESSION['errors'] = ["Cập nhật người dùng thất bại"];
    }

    header("Location: index.php?act=admin-users");
    exit;
}

public function dashboard() {
    $user_name = $_SESSION['user_name'] ?? '';
    $title = "Dashboard người dùng";
    $view = './views/user/dashboard.php';
    require_once './views/layout.php';
}
public function profile() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=user-profile");
            exit;
        }

        // Lấy thông tin user từ session
        $user = $_SESSION['user'];

        // Gọi view hiển thị
        include_once "views/user/profile.php";
    }
}
?>
