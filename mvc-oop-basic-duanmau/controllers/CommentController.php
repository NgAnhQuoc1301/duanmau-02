<?php
class CommentController
{
    public $modelComment;
    public $modelProduct;
    public $modelUser;

    public function __construct()
    {
        $this->modelComment = new CommentModel();
        $this->modelProduct = new ProductModel();
        $this->modelUser = new UserModel();
    }
    public function index()
    {
        $comments = $this->modelComment->getAllComments();
        $title = "Quản lý bình luận";
        $view = './views/admin/comment/index.php';
        require_once './views/admin/layout.php';
    }
    public function pending()
    {
        $comments = $this->modelComment->getPendingComments();
        $title = "Bình luận chưa duyệt";
        $view = './views/admin/comment/pending.php';
        require_once './views/admin/layout.php';
    }
    public function approve()
{
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id > 0) {
        $result = $this->modelComment->approveComment($id); 
        if ($result) {
            $_SESSION['success'] = "Đã duyệt bình luận thành công!";
        } else {
            $_SESSION['errors'] = ["Không thể duyệt bình luận!"];
        }
    }
    header('Location: index.php?act=admin-comments');
    exit;
}
    public function reject()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $result = $this->modelComment->rejectComment($id);
            if ($result) {
                $_SESSION['success'] = "Đã từ chối bình luận thành công!";
            } else {
                $_SESSION['errors'] = ["Không thể từ chối bình luận!"];
            }
        }
        header('Location: index.php?act=admin-comments');
        exit;
    }
    public function delete()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $result = $this->modelComment->deleteComment($id); 
            if ($result) {
                $_SESSION['success'] = "Đã xóa bình luận thành công!";
            } else {
                $_SESSION['errors'] = ["Không thể xóa bình luận!"];
            }
        }
        header('Location: index.php?act=admin-comments');
        exit;
    }
    public function edit()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $comment = $this->modelComment->getCommentById($id);
            if ($comment) {
                $title = "Chỉnh sửa bình luận";
                $view = './views/admin/comment/edit.php';
                require_once './views/admin/layout.php';
                return;
            }
        }
        $_SESSION['errors'] = ["Không tìm thấy bình luận!"];
        header('Location: index.php?act=admin-comments');
        exit;
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $content = trim($_POST['content'] ?? '');
            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
            $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

            $errors = [];
            if (empty($content)) $errors[] = "Nội dung bình luận không được để trống!";
            if ($rating < 1 || $rating > 5) $errors[] = "Đánh giá phải từ 1-5 sao!";

            if (empty($errors)) {
                $result = $this->modelComment->updateComment($id, $content, $rating, $status);
                if ($result) {
                    $_SESSION['success'] = "Cập nhật bình luận thành công!";
                    header('Location: index.php?act=admin-comments');
                    exit;
                } else {
                    $errors[] = "Không thể cập nhật bình luận!";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $_POST;
                header('Location: index.php?act=admin-comment-edit&id=' . $id);
                exit;
            }
        }
        header('Location: index.php?act=admin-comments');
        exit;
    }
    public function add()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
                  && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        $response = ['success' => false, 'errors' => []];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'] ?? 0;
            $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $content = trim($_POST['content'] ?? '');
            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;

            if (empty($content)) $response['errors'][] = "Nội dung bình luận không được để trống!";
            if ($rating < 1 || $rating > 5) $response['errors'][] = "Đánh giá phải từ 1-5 sao!";

            if (empty($response['errors'])) {
                $result = $this->modelComment->addComment($user_id, $product_id, $content, $rating);
                if ($result) {
                    $response['success'] = true;
                    $response['user_name'] = $_SESSION['user_name'] ?? 'Người dùng';
                    $response['content'] = htmlspecialchars($content);
                    $response['rating'] = $rating;
                    $response['created_at'] = date('d/m/Y H:i');
                } else {
                    $response['errors'][] = "Không thể gửi bình luận!";
                }
            }
        }

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        $_SESSION['errors'] = $response['errors'];
        $product_id = $_POST['product_id'] ?? 0;
        header('Location: index.php?act=product-detail&id=' . $product_id);
        exit;
    }
}
?>
