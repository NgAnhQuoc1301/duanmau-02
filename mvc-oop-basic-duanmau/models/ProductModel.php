<?php 
// Class chứa các function thực thi tương tác với cơ sở dữ liệu 
class ProductModel 
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
        if (!$this->conn) {
            throw new Exception("Không thể kết nối database");
        }
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts($limit = null, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :offset, :limit";
        }
        
        $stmt = $this->conn->prepare($sql);
        
        if ($limit !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Lấy sản phẩm theo danh mục
    public function getProductsByCategory($category_id, $limit = null, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id 
                ORDER BY p.id DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :offset, :limit";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id);
        
        if ($limit !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Đếm tổng số sản phẩm
    public function countProducts($category_id = null)
    {
        $sql = "SELECT COUNT(*) as total FROM products";
        
        if ($category_id !== null) {
            $sql .= " WHERE category_id = :category_id";
        }
        
        $stmt = $this->conn->prepare($sql);
        
        if ($category_id !== null) {
            $stmt->bindParam(':category_id', $category_id);
        }
        
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Thêm sản phẩm mới
    public function addProduct($name, $price, $image, $category_id)
    {
        $sql = "INSERT INTO products (name, price, image, category_id) 
                VALUES (:name, :price, :image, :category_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $category_id);
        return $stmt->execute();
    }
    
    // Cập nhật sản phẩm
    public function updateProduct($id, $name, $price, $sale_price, $description, $category_id, $status, $image = null)
{
    if ($image) {
        $sql = "UPDATE products 
                SET name = :name, price = :price, sale_price = :sale_price, description = :description, category_id = :category_id, status = :status, image = :image
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':image', $image);
    } else {
        $sql = "UPDATE products 
                SET name = :name, price = :price, sale_price = :sale_price, description = :description, category_id = :category_id, status = :status
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
    }

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':sale_price', $sale_price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':status', $status);
    return $stmt->execute();
}
    
    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        // Lấy thông tin sản phẩm để xóa hình ảnh nếu có
        $product = $this->getProductById($id);
        
        // Xóa sản phẩm trong database
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        
        // Nếu xóa thành công và có hình ảnh thì xóa file hình ảnh
        if ($result && $product['image']) {
            deleteFile($product['image']);
        }
        
        return $result;
    }
    
    // Tìm kiếm sản phẩm
    public function searchProducts($keyword, $limit = null, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE :keyword 
                ORDER BY p.id DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :offset, :limit";
        }
        
        $stmt = $this->conn->prepare($sql);
        $searchKeyword = "%$keyword%";
        $stmt->bindParam(':keyword', $searchKeyword);
        
        if ($limit !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy sản phẩm mới (không dùng trường status)
    public function getNewProducts($limit = 6)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC 
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy sản phẩm mà user đã comment (bỏ điều kiện status)
    public function getProductsByUserComments($user_id, $limit = 6)
    {
        $sql = "SELECT DISTINCT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                INNER JOIN comments cm ON p.id = cm.product_id 
                WHERE cm.user_id = :user_id 
                ORDER BY cm.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
