<?php
// Class chứa các function thực thi xử lý logic cho authentication
class AuthController
{
    public $modelUser;

    public function __construct()
    {
        $this->modelUser = new UserModel();
    }

    // Hiển thị form đăng nhập
    public function showLogin()
    {
        $title = "Shop Online - Đăng nhập";
        $view = './views/auth/login.php';
        require_once './views/layout.php';
    }

    // Xử lý đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validation
            $errors = [];
            if (empty($email)) {
                $errors[] = "Email không được để trống";
            }
            if (empty($password)) {
                $errors[] = "Mật khẩu không được để trống";
            }

            if (empty($errors)) {
                $user = $this->modelUser->login($email, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['username'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['success'] = "Đăng nhập thành công!";
                    if ($user['role'] === 'admin') {
                        header('Location: index.php?act=admin-products');
                    } else {
                        header('Location: index.php?act=user-dashboard');
                    }
                    exit;
                } else {
                    $errors[] = "Email hoặc mật khẩu không đúng";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $_POST;
                header('Location: index.php?act=login');
                exit;
            }
        }

        // Nếu không phải POST request, redirect về form login
        header('Location: index.php?act=login');
        exit;
    }

    // Hiển thị form đăng ký
    public function showRegister()
    {
        $title = "Shop Online - Đăng ký";
        $view = './views/auth/register.php';
        require_once './views/layout.php';
    }

    // Xử lý đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validation
            $errors = [];
            if (empty($username)) {
                $errors[] = "Tên đăng nhập không được để trống";
            }
            if (empty($email)) {
                $errors[] = "Email không được để trống";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ";
            }
            if (empty($password)) {
                $errors[] = "Mật khẩu không được để trống";
            } elseif (strlen($password) < 6) {
                $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
            }
            if ($password !== $confirm_password) {
                $errors[] = "Mật khẩu xác nhận không khớp";
            }

            // Kiểm tra email đã tồn tại chưa
            if (empty($errors)) {
                $existingUser = $this->modelUser->getUserByEmail($email);
                if ($existingUser) {
                    $errors[] = "Email đã được sử dụng";
                }
            }

            if (empty($errors)) {
                // Thêm user mới
                $result = $this->modelUser->addUser($username, $email, $password);
                
                if ($result) {
                    $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                    header('Location: index.php?act=login');
                    exit;
                } else {
                    $errors[] = "Đăng ký thất bại";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $_POST;
                header('Location: index.php?act=register');
                exit;
            }
        }

        header('Location: index.php?act=register');
        exit;
    }

    // Đăng xuất
    public function logout()
    {
        // Xóa session
        session_destroy();
        $_SESSION['success'] = "Đăng xuất thành công!";
        header('Location: index.php');
        exit;
    }

    // Kiểm tra quyền admin
    public static function requireAdmin()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['errors'] = ["Vui lòng đăng nhập để tiếp tục"];
            header('Location: index.php?act=login');
            exit;
        }
        
        if ($_SESSION['user_role'] !== 'admin') {
            $_SESSION['errors'] = ["Bạn không có quyền truy cập trang admin"];
            header('Location: index.php');
            exit;
        }
    }

    // Kiểm tra đã đăng nhập
    public static function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['errors'] = ["Vui lòng đăng nhập để tiếp tục"];
            header('Location: index.php?act=login');
            exit;
        }
    }

    // Kiểm tra quyền user
    public static function requireUser()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['errors'] = ["Vui lòng đăng nhập để tiếp tục"];
            header('Location: index.php?act=login');
            exit;
        }
    }
}
?> 