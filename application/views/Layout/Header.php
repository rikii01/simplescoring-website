<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/x-icon">
  <title><?php echo isset($title) ? html_escape($title) : 'Dashboard'; ?></title>

  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fontawesome.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/icofont.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/themify.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/flag-icon.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/feather-icon.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendors/bootstrap.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
  <link id="color" rel="stylesheet" href="<?php echo base_url('assets/css/color-1.css'); ?>" media="screen">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/responsive.css'); ?>">
</head>
<style>
    /* Menyesuaikan jarak agar tidak menabrak header */
    .page-body {
        margin-top: 120px !important;
    }
    
</style>

<body>
  <!-- loader starts-->
  <div class="loader-wrapper">
    <div class="loader-index"><span></span></div>
    <svg>
      <defs></defs>
      <filter id="goo">
        <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
        <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></fecolormatrix>
      </filter>
    </svg>
  </div>
  <!-- loader ends-->

  <div class="tap-top"><i data-feather="chevrons-up"></i></div>

  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <div class="page-header">
      <div class="header-wrapper row m-0 align-items-center">

        <div class="nav-right col ms-auto p-0">
          <ul class="nav-menus justify-content-end">
            <li class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-4"><?php echo html_escape($this->session->userdata('user_name')); ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                  <a class="dropdown-item" href="<?php echo site_url('logout'); ?>">
                    <i data-feather="log-out" class="me-2"></i> Logout
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Page Header Ends-->

    <!-- Page Body Start -->
    <div class="page-body-wrapper">
      <?php $this->load->view('layout/sidebar'); ?>
      
      <div class="page-body">
        <!-- Konten halaman mulai di sini -->