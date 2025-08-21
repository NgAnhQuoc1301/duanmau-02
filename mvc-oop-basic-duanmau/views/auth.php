<div class="row justify-content-center my-5">
    <div class="col-md-10">
        <div class="card shadow border-0 overflow-hidden">
            <div class="row g-0">
                <!-- Hình ảnh bên trái -->
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="bg-primary h-100 d-flex align-items-center justify-content-center p-5">
                        <div class="text-center text-white">
                            <i class="fas fa-shopping-cart fa-5x mb-4"></i>
                            <h2 class="fw-bold mb-4">UNI STU</h2>
                            <p class="lead">Chào mừng bạn đến với cửa hàng trực tuyến của chúng tôi!</p>
                            <p>Đăng nhập để trải nghiệm mua sắm tốt nhất và nhận nhiều ưu đãi hấp dẫn.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Form đăng nhập/đăng ký bên phải -->
                <div class="col-lg-6">
                    <div class="card-body p-4 p-lg-5">
                        <!-- Tab navigation -->
                        <ul class="nav nav-tabs mb-4" id="authTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Đăng nhập</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Đăng ký</button>
                            </li>
                        </ul>
                        
                        <!-- Tab content -->
                        <div class="tab-content" id="authTabContent">
                            <!-- Đăng nhập -->
                            <div class="tab-pane fade show active" id="login" role="tabpanel">
                                <h3 class="mb-4">Đăng nhập</h3>
                                <form action="index.php?act=login" method="post">
                                    <div class="mb-3">
                                        <label for="loginEmail" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Nhập email của bạn" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="loginPassword" class="form-label">Mật khẩu</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Nhập mật khẩu" required>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                            <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                                        </div>
                                        <a href="index.php?act=forgot-password" class="text-decoration-none">Quên mật khẩu?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mb-3" name="login">Đăng nhập</button>
                                    <div class="text-center mb-3">Hoặc đăng nhập với</div>
                                    <div class="d-flex gap-2 mb-3">
                                        <a href="#" class="btn btn-outline-primary w-50">
                                            <i class="fab fa-facebook-f me-2"></i> Facebook
                                        </a>
                                        <a href="#" class="btn btn-outline-danger w-50">
                                            <i class="fab fa-google me-2"></i> Google
                                        </a>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Đăng ký -->
                            <div class="tab-pane fade" id="register" role="tabpanel">
                                <h3 class="mb-4">Đăng ký tài khoản</h3>
                                <form action="index.php?act=register" method="post">
                                    <div class="mb-3">
                                        <label for="registerName" class="form-label">Họ và tên</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="registerName" name="fullname" placeholder="Nhập họ và tên" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerEmail" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="registerEmail" name="email" placeholder="Nhập email" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerPhone" class="form-label">Số điện thoại</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="tel" class="form-control" id="registerPhone" name="phone" placeholder="Nhập số điện thoại" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerPassword" class="form-label">Mật khẩu</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="registerPassword" name="password" placeholder="Nhập mật khẩu" required>
                                        </div>
                                        <div class="form-text">Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số</div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="registerConfirmPassword" class="form-label">Xác nhận mật khẩu</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="registerConfirmPassword" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                                        </div>
                                    </div>
                                    <div class="mb-4 form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" name="agree_terms" required>
                                        <label class="form-check-label" for="agreeTerms">
                                            Tôi đồng ý với <a href="#" class="text-decoration-none">Điều khoản dịch vụ</a> và <a href="#" class="text-decoration-none">Chính sách bảo mật</a>
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100" name="register">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lợi ích khi đăng ký tài khoản -->
<div class="row mt-5 mb-4">
    <div class="col-12 text-center">
        <h3>Lợi ích khi đăng ký tài khoản</h3>
        <p class="text-muted">Trở thành thành viên để nhận nhiều ưu đãi hấp dẫn</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-gift fa-2x"></i>
                </div>
                <h5>Ưu đãi độc quyền</h5>
                <p class="text-muted">Nhận các khuyến mãi và ưu đãi đặc biệt dành riêng cho thành viên</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-truck fa-2x"></i>
                </div>
                <h5>Miễn phí vận chuyển</h5>
                <p class="text-muted">Thành viên được miễn phí vận chuyển cho các đơn hàng từ 500.000đ</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-history fa-2x"></i>
                </div>
                <h5>Lịch sử đơn hàng</h5>
                <p class="text-muted">Theo dõi đơn hàng và xem lại lịch sử mua sắm của bạn</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-percent fa-2x"></i>
                </div>
                <h5>Tích điểm đổi quà</h5>
                <p class="text-muted">Tích lũy điểm thưởng cho mỗi đơn hàng và đổi lấy quà tặng hấp dẫn</p>
            </div>
        </div>
    </div>
</div>