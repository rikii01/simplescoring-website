    <div class="container-fluid dashboard-2">

    <?php if ($this->session->userdata('role') === 'admin'): ?>
    <div class="row g-4 mb-4">
    <!-- Total Alternatif -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card bg-grad-purple">
        <div class="title">Total Alternatif</div>
        <div class="value"><?php echo (int)$total_alternatif; ?></div>
        <p class="desc">Alternatif Kampus</p>
        <i class="fa fa-university icon"></i>
        </div>
    </div>

    <!-- Total Kriteria -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card bg-grad-green">
        <div class="title">Total Kriteria</div>
        <div class="value"><?php echo (int)$total_kriteria; ?></div>
        <p class="desc">Kriteria aktif</p>
        <i class="fa fa-list-check icon"></i>
        </div>
    </div>

    <!-- Status Data SPK -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card bg-grad-orange">
        <div class="title">Status Data SPK</div>
        <div class="value" style="font-size:22px; margin-top:6px;">
            READY
        </div>
        <p class="desc">Siap dihitung</p>
        <i class="fa fa-circle-check icon"></i>
        </div>
    </div>

    <!-- Metode SPK -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card bg-grad-blue">
        <div class="title">Metode SPK</div>
        <div class="value" style="font-size:22px; margin-top:6px;">
            Simple Scoring
        </div>
        <p class="desc">Benefit &amp; Cost</p>
        <i class="fa fa-chart-pie icon"></i>
        </div>
    </div>
    </div>
<?php endif; ?>


    <!-- ================= ROW ATAS ================= -->
    <div class="row justify-content-center g-4 mb-4">

        <!-- CARD 1 : WELCOME -->
        <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12">
            <div class="card o-hidden welcome-card h-100">
                <div class="card-body">
                    <h4 class="mb-3 mt-2 f-w-500 f-22">
                        Hello <?php echo html_escape($this->session->userdata('user_name')); ?>
                        <span>
                            <img src="../assets/images/dashboard-3/hand.svg" alt="hand vector">
                        </span>
                    </h4>
                    <p>
                        Gunakan Sistem Pendukung Keputusan Anda untuk Memilih Kampus Swasta Terbaik !
                    </p>
                </div>
                <img class="welcome-img" src="../assets/images/dashboard-3/widget.svg" alt="widget">
            </div>
        </div>

        <!-- CARD 2 : ADD ALTERNATIF -->
        <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12">
            <div class="card profile-box h-100 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="f-w-600">Masukkan Data Kampus</h2>
                            <p class="mb-3">Masukkan Opsi Kampus yang Kamu Inginkan</p>

                            <!-- BUTTON -->
                            <a href="<?php echo site_url('alternatif'); ?>" class="btn btn-outline-white">
                                Mulai Input
                            </a>
                        </div>
                        <i class="fa fa-university fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- TUTUP ROW ATAS -->


    <!-- ================= ROW BAWAH ================= -->
    <div class="row justify-content-center g-4">

        <!-- CARD 3 : EDIT KRITERIA -->
        <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12">
            <div class="card profile-box h-100 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="f-w-600">Edit Kriteria</h2>
                            <p class="mb-3">Modifikasi Kriteria yang Anda Mau</p>

                            <!-- BUTTON -->
                            <a href="<?php echo site_url('kriteria'); ?>" class="btn btn-outline-white">
                                Kelola Kriteria
                            </a>
                        </div>
                        <i class="fa fa-list-check fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 4 : RANKING -->
        <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12">
            <div class="card profile-box h-100 bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="f-w-600">Top 100 Kampus</h2>
                            <p class="mb-3">Lihat Peringkat 100 Terbaik Kampus di Indonesia</p>

                            <!-- BUTTON -->
                            <a href="<?php echo site_url('kampus'); ?>" class="btn btn-outline-white">
                                Lihat Detail
                            </a>
                        </div>
                        <i class="fa fa-star fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- TUTUP ROW BAWAH -->

</div> 


    <style>
    .stat-card{
        border: 0;
        border-radius: 16px;
        color: #fff;
        padding: 22px 22px;
        position: relative;
        overflow: hidden;
        min-height: 140px;
        box-shadow: 0 10px 25px rgba(0,0,0,.08);
    }
    .stat-card .title{
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 8px;
        opacity: .95;
    }
    .stat-card .value{
        font-weight: 800;
        font-size: 34px;
        line-height: 1;
        margin-bottom: 6px;
    }
    .stat-card .desc{
        font-size: 13px;
        opacity: .9;
        margin: 0;
    }
    .stat-card .icon{
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 48px;
        opacity: .20;
    }

    .bg-grad-purple{ background: linear-gradient(135deg,#6d5dfc,#8f5bff); }
    .bg-grad-green{  background: linear-gradient(135deg,#2ecc71,#27ae60); }
    .bg-grad-orange{ background: linear-gradient(135deg,#ffb347,#ff7a59); }
    .bg-grad-blue{   background: linear-gradient(135deg,#4facfe,#00f2fe); }
    </style>
