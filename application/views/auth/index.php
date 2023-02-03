<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ABAI - Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Sweet Alert 2 -->
    <script src="<?php echo base_url('sw/'); ?>dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('sw/'); ?>dist/sweetalert2.min.css">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><strong>A</strong>JUKAN PER<strong>BAI</strong>KAN ADM</h1>
                                    </div>
                                    <?php echo form_open('auth/login', ['class' => 'user']);
                                    ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputUsername" aria-describedby="emailHelp" placeholder="Enter Username..." name="username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="inputPassword" placeholder="Password" name="password">
                                    </div>
                                    <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div> -->
                                    <hr>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                    <!-- <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> -->
                                    <?php echo form_close();
                                    ?>
                                    <!-- <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.user').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {

                            $(".invalid-feedback").remove();

                            if (response.username_invalid != '') {
                                $("#inputUsername").addClass("is-invalid");
                                $("#inputUsername").after(response.username_invalid)
                            } else {
                                $("#inputUsername").removeClass("is-invalid");
                                $(".invalid-feedback.username").remove();
                            }

                            if (response.password_invalid != '') {
                                $("#inputPassword").addClass("is-invalid");
                                $("#inputPassword").after(response.password_invalid)
                            } else {
                                $("#inputPassword").removeClass("is-invalid");
                                $(".invalid-feedback.password").remove();
                            }
                        }

                        if (response.failed) {
                            Swal.fire({
                                text: response.failed,
                                icon: 'error'
                            });
                        }

                        if (response.sukses) {
                            window.location.href = response.url;
                        }
                    },
                    error: function(xhr, ajaxOptions, throwError) {
                        alert(xhr.status + "\n" + xhr.responText + "\n" + throwError);
                    }
                });
            });
        });
    </script>

</body>

</html>