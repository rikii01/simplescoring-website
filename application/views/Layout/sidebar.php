<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
    <div class="logo-wrapper">
        <a href="<?php echo site_url('dashboard'); ?>">
            <img class="img-fluid for-light" src="<?php echo base_url('assets/images/logo/logo.png'); ?>" alt="">
            <img class="img-fluid for-dark" src="<?php echo base_url('assets/images/logo/logo_dark.png'); ?>" alt="">
        </a>
    </div>

    <nav class="sidebar-main">
        <div id="sidebar-menu">
<ul class="sidebar-links" id="simple-bar">
    <li class="sidebar-main-title">
        <div><h6> </h6></div>
    </li>

    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title link-nav <?php echo ($this->uri->segment(1) == 'dashboard') ? 'active' : ''; ?>" href="<?php echo site_url('dashboard'); ?>">
            <svg class="stroke-icon">
                <use href="<?php echo base_url('assets/svg/icon-sprite.svg#stroke-home'); ?>"></use>
            </svg>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title link-nav <?php echo ($this->uri->segment(1) == 'alternatif') ? 'active' : ''; ?>" href="<?php echo site_url('alternatif'); ?>">
            <svg class="stroke-icon">
                <use href="<?php echo base_url('assets/svg/icon-sprite.svg#stroke-table'); ?>"></use>
            </svg>
            <span>Data Kampus</span>
        </a>
    </li>

    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title link-nav <?php echo ($this->uri->segment(1) == 'kriteria') ? 'active' : ''; ?>" href="<?php echo site_url('kriteria'); ?>">
            <svg class="stroke-icon">
                <use href="<?php echo base_url('assets/svg/icon-sprite.svg#stroke-task'); ?>"></use>
            </svg>
            <span>Edit Kriteria</span>
        </a>
    </li>

    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title link-nav <?php echo ($this->uri->segment(1) == 'kampus') ? 'active' : ''; ?>" href="<?php echo site_url('kampus'); ?>">
            <svg class="stroke-icon">
                <use href="<?php echo base_url('assets/svg/icon-sprite.svg#stroke-learning'); ?>"></use>
            </svg>
            <span>Top 100 Kampus</span>
        </a>
    </li>
</ul>
        </div>
    </nav>
</div>