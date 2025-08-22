<?php
class AuthController
{
    public $modelUser;

    public function __construct()
    {
        $this->modelUser = new UserModel();
    }

    public function showLogin()
    {
        $title = "Shop Online - Đăng nhập";
        $view = './views/auth/login.php';
        require_once './views/layout.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

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

        header('Location: index.php?act=login');
        exit;
    }

    public function showRegister()
    {
        $title = "Shop Online - Đăng ký";
        $view = './views/register.php'; // Đảm bảo đúng đường dẫn
        require_once './views/layout.php';
    }
        public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Xác thực dữ liệu
        $errors = [];
        if (empty($name)) $errors[] = "Họ và tên không được để trống";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ";
        if (empty($password)) $errors[] = "Mật khẩu không được để trống";
        if ($password !== $confirm_password) $errors[] = "Mật khẩu và xác nhận mật khẩu không khớp";
        if (strlen($password) < 6) $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";

        if (empty($errors)) {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Lưu vào database
            require_once './models/UserModel.php';
            $userModel = new UserModel();
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $hashed_password,
                'role' => 'user' // Giá trị mặc định cho role
            ];
            $result = $userModel->addUser($data);

            if ($result) {
                // Đăng ký thành công, lưu session và chuyển hướng
                $_SESSION['user_id'] = $result;
                $_SESSION['user_name'] = $name;
                header('Location: index.php?act=user-dashboard');
                exit;
            } else {
                $errors[] = "Đăng ký thất bại. Vui lòng thử lại.";
            }
        }

        // Lưu dữ liệu cũ và lỗi để hiển thị lại form
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
        }
    }

    $title = "Shop Online - Đăng ký";
    $view = 'auth/register.php';
    require_once './views/layout.php';
}

    public function logout()
    {
        session_destroy();
        $_SESSION['success'] = "Đăng xuất thành công!";
        header('Location: index.php');
        exit;
    }

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

    public static function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['errors'] = ["Vui lòng đăng nhập để tiếp tục"];
            header('Location: index.php?act=login');
            exit;
        }
    }

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