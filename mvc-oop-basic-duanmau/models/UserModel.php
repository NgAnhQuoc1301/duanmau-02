<?php
// Class chứa các function thực thi tương tác với cơ sở dữ liệu cho người dùng
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

    // Lấy tất cả người dùng
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy người dùng theo ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Lấy người dùng theo email
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Thêm người dùng mới
    public function addUser($username, $email, $password, $role = 'user')
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password, role, created_at) VALUES (:username, :email, :password, :role, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    // Cập nhật người dùng
    public function updateUser($id, $username, $email, $role = 'user')
    {
        $sql = "UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    // Xóa người dùng
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
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
}
?> 