<?php
include "session.php";
redirect_if_logged_in();

include "koneksi.php";

$error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi!";
    } else {
        // Cari user
        $sql = "SELECT id, username, password FROM user WHERE username = '$username' OR email = '$username'";
        $result = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Verifikasi password
            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                if (isset($_POST["remember"])) {
                    $cookie_name = "user_id";
                    $cookie_value = $user["id"];
                    $cookie_time = 60 * 60 * 24;
                    setcookie($cookie_name, $cookie_value, $cookie_time, "/");

                    $cookie_name = "username";
                    $cookie_value = $user["username"];
                    $cookie_time = 60;
                    setcookie($cookie_name, $cookie_value, $cookie_time, "/");
                }

                header("Location: index.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username/email tidak ditemukan!";
        }
    }
}
?>

<?php include "templates/header.php"; ?>

<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>User Login</h4>
                        </div>
                        <div class="card-body">
                            <?php if ($error): ?>
                                <div class="alert alert-danger" role="alert">
                                    <div><?= $error ?></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="email">Masukkan Username</label>
                                    <input id="username" type="text" class="form-control" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>" tabindex="1" required autofocus>
                                </div>
                                <div class="mb-3">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Masukkan Password</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Ingat Saya</label>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" name="login" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Masuk
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Belum Punya Akun? <a href="register.php">Daftar</a>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        <a href="sembarang.php">Halaman Sembarang</a>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>








<?php include "templates/footer.php"; ?>