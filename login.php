<?php
session_start();

// destroy the session
session_destroy()
    ?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="./assets2/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="./assets2/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="./assets2/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <link rel="stylesheet" href="./assets2/dist/css/adminlte.min.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="shortcut icon" href="./assets/img/tpa11.png" />
</head>

<body class="hold-transition login-page">

    <div class="card">
        <div class="card-body login-card-body text-center">
            <div class="row mb-12">
                <div class="col-sm-12">
                    <img src="./assets/img/tpa11.png" class="brand-image img-circle img-fluid mb-4 img-circle mb-4 "
                        style="max-width: 80px;">
                    <h5 class="text-center text-blue">
                        PAMSIMAS
                    </h5>
                    <h3 class="text-bold text-center text-blue">
                        Tirta Pandan Ayu</h3>
                    <p class="text-center"></p>
                </div><!-- /.col -->
            </div>
            <h2 class="login-box-msg text-dark">Login</h2>
            <p class="login-box-msg text-dark">Masukkan Username dan Password Anda!</p>
            <form class="needs-validation" novalidate name="login" method="post" action="validate.php">
                <div class="input-group mb-3">
                    <input type="text" name="username" id="validationCustomUsername" class="form-control"
                        placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        Masukkan Username Anda !
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="validationCustomUsername" class="form-control"
                        placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback ml-3">
                        Masukkan Password Anda
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div>

                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
                            Login
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <h5 class="text-center mt-3">
        <a href=""><b class="text-dark">By</b> Abdus Shomad Nurrohman</a>
    </h5>
    </div>
    <script src="./assets2/plugins/jquery/jquery.min.js" type="c153c3eb08c577276a0358d8-text/javascript"></script>

    <script src="./assets2/plugins/bootstrap/js/bootstrap.bundle.min.js"
        type="c153c3eb08c577276a0358d8-text/javascript"></script>

    <script src="./assets2/dist/js/adminlte.min.js" type="c153c3eb08c577276a0358d8-text/javascript"></script>
    <script src="./cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="c153c3eb08c577276a0358d8-|49" defer></script>
    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/v8b253dfea2ab4077af8c6f58422dfbfd1689876627854"
        integrity="sha512-bjgnUKX4azu3dLTVtie9u6TKqgx29RBwfj3QXYt5EKfWM/9hPSAI/4qcV5NACjwAo8UtTeWefx6Zq5PHcMm7Tg=="
        data-cf-beacon='{"rayId":"8164170f9f025ea1","version":"2023.8.0","r":1,"token":"fddeef96bf4d478d94841d7576a88dea","si":100}'
        crossorigin="anonymous">
        </script>
    <!-- SweetAlert2 -->
    <script src="./assets2/plugins/sweetalert2/sweetalert2.min.js"></script>
    <?php if (@$_SESSION['salah']) { ?>
        <script>
            swal.fire("Gagal Login !", "Username atau Password Anda Salah", "error");
        </script>
        <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
        <?php unset($_SESSION['salah']);
    } ?>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>