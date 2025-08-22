<?php
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

    public function countUsers($keyword = '')
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username LIKE :keyword OR email LIKE :keyword";
        $stmt = $this->conn->prepare($sql);
        $searchKeyword = "%$keyword%";
        $stmt->bindParam(':keyword', $searchKeyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($data) {
    try {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':role' => $data['role'] 
        ]);
        return $this->conn->lastInsertId();
    } catch (PDOException $e) {
        error_log("Lỗi thêm user: " . $e->getMessage());
        return false;
    }
}

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

    public function login($email, $password)
    {
        error_log("Kiểm tra đăng nhập: Email=$email"); 
        $user = $this->getUserByEmail($email);
        if ($user) {
            error_log("Tìm thấy user: ID={$user['id']}, Password (hashed)={$user['password']}"); 
            if (password_verify($password, $user['password'])) {
                error_log("Mật khẩu khớp, đăng nhập thành công");
                return $user;
            } else {
                error_log("Mật khẩu không khớp");
            }
        } else {
            error_log("Không tìm thấy user với email: $email");
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