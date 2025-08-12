<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4 class="mb-0">Đăng nhập</h4>
                </div>
                <div class="card-body">
                    <form action="index.php?act=auth-login" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo $_SESSION['old_data']['email'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                    </form>
                    
                    <hr>
                    
                    <div class="text-center">
                        <p class="mb-0">Chưa có tài khoản? 
                            <a href="index.php?act=register" class="text-decoration-none">Đăng ký ngay</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Xóa dữ liệu cũ sau khi hiển thị form
unset($_SESSION['old_data']);
?> 