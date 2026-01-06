<div class="container-fluid dashboard-2">

<div class="page-title bg-primary text-white rounded p-3 mb-3">
    <div class="row align-items-center">
        <div class="col-6">
            <h1 class="text-white" class="mb-0">
                Input Data Kampus (Alternatif)
            </h1>
        </div>
        <div class="col-6 text-end">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="<?php echo site_url('dashboard'); ?>" class="text-white text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active text-white">Input Alternatif</li>
            </ol>
        </div>
    </div>
</div>


    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <!-- ===== CARD FORM INPUT ===== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Input Alternatif</h5>
                    <span class="f-light">Isi nama kampus dan nilai 1–5 untuk setiap kriteria (default dari sistem).</span>
                </div>

                <div class="card-body">
                    <form method="post" action="<?php echo site_url('alternatif/store'); ?>">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Nama Kampus</label>
                                <input type="text" name="alternative_name" class="form-control" placeholder="Contoh: BINUS" required>
                            </div>

                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-primary">
                                            <tr>
                                                <th style="width: 12%;">Kode</th>
                                                <th>Nama Kriteria</th>
                                                <th style="width: 14%;">Tipe</th>
                                                <th style="width: 14%;">Bobot</th>
                                                <th style="width: 20%;">Nilai (1–5)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($criterias as $c): ?>
                                                <tr>
                                                    <td class="f-w-500"><?php echo html_escape($c->code); ?></td>
                                                    <td><?php echo html_escape($c->name); ?></td>

                                                    <td>
                                                        <span class="badge <?php echo ($c->type === 'benefit') ? 'badge-light-success' : 'badge-light-danger'; ?>">
                                                            <?php echo strtoupper($c->type); ?>
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <span class="badge badge-light-primary"><?php echo (int)$c->weight; ?></span>
                                                    </td>

                                                    <td>
                                                        <select name="scores[<?php echo (int)$c->id; ?>]" class="form-select" required>
                                                            <option value="5">5 (Sangat Baik)</option>
                                                            <option value="4">4 (Baik)</option>
                                                            <option value="3" selected>3 (Cukup)</option>
                                                            <option value="2">2 (Kurang)</option>
                                                            <option value="1">1 (Sangat Kurang)</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12 d-flex gap-2">
                                <button type="submit" class="btn btn-primary d-flex align-items-center">
                                    <i data-feather="save" class="me-1"></i> Simpan Alternatif
                                </button>
                                <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-light">Kembali</a>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- ===== CARD LIST ALTERNATIF ===== -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Alternatif Tersimpan</h5>
                    <span class="f-light">List kampus yang sudah kamu input.</span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width: 7%;">No</th>
                                    <th>Nama Kampus</th>
                                    <th style="width: 18%;">Kriteria Terisi</th>
                                    <th style="width: 20%;">Tanggal Input</th>
                                    <th style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($alternatives)): ?>
                                    <?php $no = 1; foreach ($alternatives as $a): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td class="f-w-500"><?php echo html_escape($a->name); ?></td>
                                            <td>
                                                <span class="badge badge-light-primary">
                                                    <?php echo (int)$a->filled_scores; ?> / <?php echo count($criterias); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo !empty($a->created_at) ? html_escape($a->created_at) : '-'; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo site_url('Alternatif/delete/'.(int)$a->id); ?>"
                                                    class="btn btn-sm btn-danger d-flex align-items-center" onclick="return confirm('Hapus alternatif ini?');">
                                                    <i data-feather="trash-2" class="me-1"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Belum ada alternatif yang diinput.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
    <!-- ================= LIST ALTERNATIF ================= -->
    <div class="row mt-4">
    <div class="col-12">
        <div class="card">
        <div class="card-header">
            <h5 class="mb-0">List Alternatif yang Sudah Diinput</h5>
            <span class="f-light">Menampilkan semua kampus yang sudah tersimpan.</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th style="width:70px;">No</th>
                    <th>Nama Kampus</th>
                    <th style="width:160px;">Skor Terisi</th>
                    <th style="width:200px;">Tanggal</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($alternatives)): $no=1; ?>
                    <?php foreach ($alternatives as $a): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td class="f-w-500"><?php echo html_escape($a->name); ?></td>
                        <td><?php echo (int)$a->filled_scores; ?></td>
                        <td><?php echo html_escape($a->created_at); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada alternatif.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
    </div>

<!-- ================= RANKING ================= -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">🏆 Hasil Peringkat Akhir</h5>
                <span class="f-light">Hasil rekomendasi kampus swasta terbaik berdasarkan kriteria Anda.</span>
            </div>
            <div class="card-body">

                <?php if (empty($ranking)): ?>
                <div class="alert alert-warning mb-0">
                    Ranking belum bisa dihitung. Pastikan semua alternatif sudah memiliki nilai.
                </div>
                <?php else: ?>

                    <div class="d-flex gap-2">
                    <a href="<?php echo site_url('laporan/excel'); ?>" class="btn btn-success px-3 mb-3">
  Export Laporan Excel
</a>
<a href="<?php echo site_url('laporan/pdf'); ?>" class="btn btn-danger">
    Export PDF
</a>
</div>


                <div class="table-responsive custom-scrollbar">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center" style="width:100px;">Rank</th>
                                <th>Nama Kampus</th>
                                <th class="text-center" style="width:200px;">Skor Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ranking as $r): 
                                $rank = (int)$r['rank'];
                                $rowClass = '';
                                $badgeClass = 'badge-light-dark text-dark';
                                $icon = '';

                                if ($rank === 1) {
                                    $rowClass = 'table-light-primary';
                                    $badgeClass = 'badge-primary';
                                    $icon = '🥇 '; 
                                } elseif ($rank === 2) {
                                    $rowClass = 'table-light-secondary';
                                    $badgeClass = 'badge-secondary';
                                    $icon = '🥈 ';
                                } elseif ($rank === 3) {
                                    $rowClass = 'table-light-warning';
                                    $badgeClass = 'badge-warning text-dark';
                                    $icon = '🥉 ';
                                }
                            ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <td class="text-center">
                                    <span class="badge rounded-pill <?php echo $badgeClass; ?> f-14 p-2" style="min-width: 40px;">
                                        <?php echo $rank; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="f-16 f-w-600"><?php echo $icon . html_escape($r['alternative']); ?></span>
                                        <?php if($rank <= 3): ?>
                                            <span class="ms-2 badge badge-light-success">Top Recomended</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="progress-showcase">
                                        <span class="f-w-700 font-primary"><?php echo number_format($r['score'], 4); ?></span>
                                        <div class="progress sm-progress-bar mt-1">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo ($r['score'] * 100); ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>