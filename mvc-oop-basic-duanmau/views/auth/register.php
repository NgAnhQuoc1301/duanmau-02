<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4 class="mb-0">Đăng ký</h4>
                </div>
                <div class="card-body">
                    <form action="index.php?act=register" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo $_SESSION['old_data']['name'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo $_SESSION['old_data']['email'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   minlength="6" required>
                            <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="confirm_password" 
                                   name="confirm_password" minlength="6" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                        </div>
                    </form>
                    
                    <hr>
                    
                    <div class="text-center">
                        <p class="mb-0">Đã có tài khoản? 
                            <a href="index.php?act=login" class="text-decoration-none">Đăng nhập</a>
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