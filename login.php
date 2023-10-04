<?php
require('backend/function.php');

session_start();

if ( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
    $id  = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM admin WHERE id = '$id'");

    $row = mysqli_fetch_array($result);

    if ( $key === hash('sha256', $row['username']) ) {
        $_SESSION['login'] = true;
    }
}


if ( isset($_SESSION['login']) ) {
    header('location:index.php');
    exit;
}



if ( isset($_POST['login']) ) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

    // mengecek username 
    if ( mysqli_num_rows($result) === 1 ) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if ( password_verify($password, $row['password']) ) {

            // cek remember me
            if ( isset($_POST['remember']) ) {
                // buat cookie
                setcookie('id', $row['id'], strtotime('today 23:59'), '/');
                setcookie('key', hash('sha256', $row['username']), strtotime('today 23:59'), '/');
            }

            // set session 
            $_SESSION['login'] = true;

            header('location:home.php');
            exit;
        }
    }

    $error = true;


}

?>

<?php

if ( isset($error) ) {
    echo "<script>
            alert('Username / Password salah')
        </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="username" type="username"
                                                placeholder="Username" name="username" />
                                            <label for="username">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password"
                                                placeholder="Kata Sandi" name="password" />
                                            <label for="inputPassword">Kata Sandi</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                                name="remember" />
                                            <label for="#flexCheckDefault" class="form-check-label">Remember Me</label>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="registrasi.php">Belum Punya Akun? Silahkan Daftar!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Muhammad Rafi 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>