    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="pixelstrap">

        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/x-icon">
        <title>Login</title>

        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">

        <!-- Vendor CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fontawesome.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/icofont.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/themify.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/flag-icon.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/feather-icon.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/bootstrap.css'); ?>">

        <!-- App CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
        <link id="color" rel="stylesheet" href="<?php echo base_url('assets/css/color-1.css'); ?>" media="screen">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/responsive.css'); ?>">
    </head>

    <body>
        <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
            <div class="login-card login-dark">
                <div class="login-main">
                    <!-- Form CI3 -->
                    <form class="theme-form" method="post" action="<?php echo site_url('login'); ?>">
                    <h1>Login ke Simple Scoring</h1>
                    <p>Pilih Kampus Swasta Terbaik di Indonesia !</p>

                    <!-- Error dari controller -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo html_escape($error); ?></div>
                    <?php endif; ?>

                    <!-- Error dari form_validation -->
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label class="col-form-label">Email Address</label>
                        <input class="form-control email"
                            type="email"
                            name="email"
                            value="<?php echo set_value('email'); ?>"
                            required
                            placeholder="emailkamu@gmail.com">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <div class="form-input position-relative">
                        <input class="form-control pwd"
                                type="password"
                                name="password"
                                required
                                placeholder="*********">
                        </div>
                    </div>

                        <div class="text-end">
                        <button class="btn btn-primary btn-block w-100 mt-3" id="btn-login" type="submit">
                            Sign in
                        </button>
                        </div>
                    </div>
                    <!-- <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2" href="#">Create Account</a></p> -->
                    </form>
                </div>

                </div>
            </div>
            </div>
        </div>

        <!-- JS -->
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/icons/feather-icon/feather.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/icons/feather-icon/feather-icon.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/config.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/script1.js'); ?>"></script>

        <script>
            // validasi ringan di front-end (optional)
            $(document).on('click', '#btn-login', function(e) {
            if ($('.email').val() === '' || $('.pwd').val() === '') {
                e.preventDefault();
                alert('Email dan password wajib diisi.');
            }
            });
        </script>
        </div>
    </body>
    </html>
