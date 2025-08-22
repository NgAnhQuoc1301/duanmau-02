<div class="row mb-4">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Banner liên hệ -->
<div class="mb-4">
    <div class="position-relative">
        <div class="bg-dark text-white p-5 rounded shadow">
            <div class="text-center">
                <h1 class="display-4 fw-bold">Liên hệ với chúng tôi</h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php echo implode('<br>', $errors); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?act=contact" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $_POST['name'] ?? ''; ?>" required>
                <div class="invalid-feedback">
                    Vui lòng nhập họ và tên.
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                <div class="invalid-feedback">
                    Vui lòng nhập email hợp lệ.
                </div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $_POST['phone'] ?? ''; ?>" required>
                <div class="invalid-feedback">
                    Vui lòng nhập số điện thoại hợp lệ (10-11 số).
                </div>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Nội dung <span class="text-danger">*</span></label>
                <textarea class="form-control" id="message" name="message" rows="5" required><?php echo $_POST['message'] ?? ''; ?></textarea>
                <div class="invalid-feedback">
                    Vui lòng nhập nội dung liên hệ.
                </div>
            </div>
            <button type="submit" class="btn btn-dark">Gửi liên hệ</button>
        </form>
    </div>
</div>

<script>
    // Bootstrap validation
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>