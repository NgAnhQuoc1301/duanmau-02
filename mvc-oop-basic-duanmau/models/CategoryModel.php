<?php
// Class chứa các function thực thi tương tác với cơ sở dữ liệu cho danh mục
class CategoryModel 
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
        if (!$this->conn) {
            throw new Exception("Không thể kết nối database");
        }
    }

    // Lấy tất cả danh mục với phân trang và tìm kiếm
    public function getAllCategories($keyword = '', $page = 1, $limit = 10)
    {
        // Tính offset cho phân trang
        $offset = ($page - 1) * $limit;
        
        // Chuẩn bị câu truy vấn với điều kiện tìm kiếm nếu có
        $sql = "SELECT * FROM categories WHERE 1=1";
        $params = [];
        
        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
            $params[':keyword'] = "%$keyword%";
        }
        
        // Thêm sắp xếp và phân trang
        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
        
        $stmt = $this->conn->prepare($sql);
        
        // Bind các tham số
        foreach ($params as $key => $value) {
            if ($key == ':limit' || $key == ':offset') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Đếm tổng số danh mục (cho phân trang)
    public function countCategories($keyword = '')
    {
        $sql = "SELECT COUNT(*) FROM categories WHERE 1=1";
        $params = [];
        
        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
            $params[':keyword'] = "%$keyword%";
        }
        
        $stmt = $this->conn->prepare($sql);
        
        // Bind các tham số
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Thêm danh mục mới
    public function addCategory($name)
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    // Cập nhật danh mục
    public function updateCategory($id, $name)
    {
        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        // Xóa danh mục trong database
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
