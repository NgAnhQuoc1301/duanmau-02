<?php
// Class chứa các function tương tác với cơ sở dữ liệu cho người dùng
class UserModel 
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
        if (!$this->conn) {
            throw new Exception("Không thể kết nối database");
        }
    }

    // Lấy tất cả người dùng (có tìm kiếm và phân trang)
    public function getAllUsers($keyword = '', $page = 1, $limit = 5)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM users 
                WHERE username LIKE :keyword OR email LIKE :keyword
                ORDER BY id DESC
                LIMIT :offset, :limit";
        $stmt = $this->conn->prepare($sql);
        $searchKeyword = "%$keyword%";
        $stmt->bindParam(':keyword', $searchKeyword, PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm tổng số user (hỗ trợ tìm kiếm)
    public function countUsers($keyword = '')
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username LIKE :keyword OR email LIKE :keyword";
        $stmt = $this->conn->prepare($sql);
        $searchKeyword = "%$keyword%";
        $stmt->bindParam(':keyword', $searchKeyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Lấy người dùng theo ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy người dùng theo email
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm người dùng mới
    public function addUser($username, $email, $password, $role = 'user')
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password, role) 
            VALUES (:username, :email, :password, :role)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    return $stmt->execute();
}

    // Cập nhật người dùng
    public function updateUser($id, $username, $email, $role = 'user')
    {
        $sql = "UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        return $stmt->execute();
    }
    // Đăng nhập
    public function login($email, $password)
    {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    public function getUserByUsername($username)
{
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
?>
