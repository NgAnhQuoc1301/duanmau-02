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
    public function getProductsByCategory($category_id, $sort = 'newest', $limit = null, $offset = 0)
{
    // Xử lý sắp xếp
    $orderBy = "ORDER BY p.id DESC"; // mặc định: mới nhất

    switch ($sort) {
        case 'price-asc':
            $orderBy = "ORDER BY p.price ASC";
            break;
        case 'price-desc':
            $orderBy = "ORDER BY p.price DESC";
            break;
        case 'name-asc':
            $orderBy = "ORDER BY p.name ASC";
            break;
        case 'name-desc':
            $orderBy = "ORDER BY p.name DESC";
            break;
        case 'newest':
        default:
            $orderBy = "ORDER BY p.id DESC";
            break;
    }

    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.category_id = :category_id 
            $orderBy";

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
    public function deleteProduct($id){
    // Xóa bình luận trước
    $sql1 = "DELETE FROM comments WHERE product_id = :id";
    $stmt1 = $this->conn->prepare($sql1);
    $stmt1->execute(['id' => $id]);

    // Sau đó xóa sản phẩm
    $sql2 = "DELETE FROM products WHERE id = :id";
    $stmt2 = $this->conn->prepare($sql2);
    return $stmt2->execute(['id' => $id]);
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
    public function getNewProducts($limit = 6) {
    $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT :limit";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
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
    public function getFilteredProducts($categories = [], $priceRange = null, $rating = null, $limit = 12, $offset = 0) {
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    // Lọc theo danh mục
    if (!empty($categories)) {
        $placeholders = [];
        foreach ($categories as $index => $catId) {
            $key = ":cat$index";
            $placeholders[] = $key;
            $params[$key] = $catId;
        }
        $sql .= " AND category_id IN (" . implode(',', $placeholders) . ")";
    }

    // Lọc theo khoảng giá
    if ($priceRange) {
        switch ($priceRange) {
            case "1": $params[':minPrice'] = 0; $params[':maxPrice'] = 1000000; break;
            case "2": $params[':minPrice'] = 1000000; $params[':maxPrice'] = 3000000; break;
            case "3": $params[':minPrice'] = 3000000; $params[':maxPrice'] = 5000000; break;
            case "4": $params[':minPrice'] = 5000000; $params[':maxPrice'] = 10000000; break;
            case "5": $params[':minPrice'] = 10000000; $params[':maxPrice'] = 1000000000; break;
        }
        $sql .= " AND price BETWEEN :minPrice AND :maxPrice";
    }

    // // Lọc theo đánh giá
    // if ($rating) {
    //     $sql .= " AND rating >= :rating";
    //     $params[':rating'] = $rating;
    // }

    // Sắp xếp mặc định theo id mới nhất
    $sql .= " ORDER BY id DESC";

    // Phân trang (dùng trực tiếp số)
    $sql .= " LIMIT $limit OFFSET $offset";

    $stmt = $this->conn->prepare($sql);
    foreach ($params as $key => $value) {
        if (is_int($value)) {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($key, $value);
        }
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
