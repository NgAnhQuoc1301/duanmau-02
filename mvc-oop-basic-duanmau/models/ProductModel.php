<?php
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
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $stmt->bindValue(':category_id', (int)$category_id, PDO::PARAM_INT);

        if ($limit !== null) {
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $stmt->bindValue(':category_id', (int)$category_id, PDO::PARAM_INT);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    // Thêm sản phẩm mới
    public function addProduct($name, $price, $sale_price, $imagePath, $description, $category_id, $status)
    {
        if ($category_id === '' || $category_id === null) $category_id = null;

        $sql = "INSERT INTO products (name, price, sale_price, image, description, category_id, status) 
                VALUES (:name, :price, :sale_price, :image, :description, :category_id, :status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':sale_price', $sale_price);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $name, $price, $sale_price, $description, $category_id, $status, $imagePath)
    {
        if ($category_id === '' || $category_id === null) $category_id = null;

        $sql = "UPDATE products 
                SET name = :name, price = :price, sale_price = :sale_price, description = :description,
                    category_id = :category_id, status = :status, image = :image
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':sale_price', $sale_price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':image', $imagePath);
        return $stmt->execute();
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $product = $this->getProductById($id);

        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $result = $stmt->execute();

        if ($result && $product['image'] && file_exists($product['image'])) {
            unlink($product['image']);
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
        $stmt->bindValue(':keyword', "%$keyword%");
        if ($limit !== null) {
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm mới
    public function getNewProducts($limit = 6)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm mà user đã comment
    public function getProductsByUserComments($user_id, $limit = 6)
    {
        $sql = "SELECT DISTINCT p.*, c.name AS category_name, cm.id AS comment_id
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                INNER JOIN comments cm ON p.id = cm.product_id
                WHERE cm.user_id = :user_id
                ORDER BY comment_id DESC
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
