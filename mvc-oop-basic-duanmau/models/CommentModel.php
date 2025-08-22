<?php
class CommentModel 
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
        if (!$this->conn) {
            throw new Exception("Không thể kết nối database");
        }
    }
    public function getAllComments()
    {
        $sql = "SELECT c.*, p.name as product_name, u.username as user_name 
                FROM comments c 
                LEFT JOIN products p ON c.product_id = p.id 
                LEFT JOIN users u ON c.user_id = u.id 
                ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getPendingComments()
    {
        $sql = "SELECT c.*, p.name as product_name, u.username as user_name 
                FROM comments c 
                LEFT JOIN products p ON c.product_id = p.id 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.status = 0
                ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getCommentById($id)
    {
        $sql = "SELECT c.*, p.name as product_name, u.username as user_name 
                FROM comments c 
                LEFT JOIN products p ON c.product_id = p.id 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getCommentsByProduct($product_id)
    {
        $sql = "SELECT c.*, u.username as user_name 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.product_id = :product_id AND c.status = 1
                ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function addComment($user_id, $product_id, $content, $rating = 5)
    {
        $sql = "INSERT INTO comments (user_id, product_id, content, rating, status, created_at) 
                VALUES (:user_id, :product_id, :content, :rating, 0, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function updateComment($id, $content, $rating = 5, $status = 1)
    {
        $sql = "UPDATE comments 
                SET content = :content, rating = :rating, status = :status 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function deleteComment($id)
    {
        $sql = "DELETE FROM comments WHERE id = :id"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function approveComment($id)
    {
        $sql = "UPDATE comments SET status = 1 WHERE id = :id"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function rejectComment($id)
    {
        $sql = "UPDATE comments SET status = 2 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function countComments($product_id = null)
    {
        $sql = "SELECT COUNT(*) as total FROM comments";
        if ($product_id !== null) {
            $sql .= " WHERE product_id = :product_id";
        }
        $stmt = $this->conn->prepare($sql);
        if ($product_id !== null) {
            $stmt->bindParam(':product_id', $product_id);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    public function getCommentsByUser($user_id, $limit = 5)
    {
        $sql = "SELECT c.*, p.name as product_name 
                FROM comments c 
                LEFT JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = :user_id 
                ORDER BY c.created_at DESC 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function insert($data) {
        $sql = "INSERT INTO comments (product_id, user_id, content, rating, created_at)
                VALUES (:product_id, :user_id, :content, :rating, :created_at)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
}
?>
