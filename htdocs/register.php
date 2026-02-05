<?php
include "session.php";
redirect_if_logged_in();
include "koneksi.php";
include "templates/header.php";


$error = "";
$success = "";

if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    
    if(empty($username) || empty($email) || empty($password)) {
        $error = "Semua field harus diisi!";
    } elseif($password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        
        $check = "SELECT id FROM user WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($koneksi, $check);
        
        if(mysqli_num_rows($result) > 0) {
            $error = "Username atau email sudah terdaftar!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO user (username, email, password) 
                    VALUES ('$username', '$email', '$hashed_password')";
            
            if(mysqli_query($koneksi, $sql)) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Terjadi kesalahan: " . mysqli_error($koneksi);
            }
        }
    }
}
?>


<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Buat Akun Baru</h4>
                        </div>
                        <div class="card-body">
                            <?php if ($error): ?>
                                <div class="alert alert-danger" role="alert">
                                    <div><?= $error ?></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php elseif ($success): ?>
                                <div class="alert alert-success" role="alert">
                                    <div><?= $success ?></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="email">Masukkan Email</label>
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                                </div>
                                <div class="mb-3">
                                    <label for="username">Masukkan Username</label>
                                    <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                                </div>
                                <div class="mb-3">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Masukkan Password</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                </div>
                                <div class="mb-3">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Ulangi Password</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="confirm_password" tabindex="2" required>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" name="register" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Buat Akun
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Sudah Punya Akun? <a href="login.php">Masuk</a>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<?php include "templates/footer.php"; ?>