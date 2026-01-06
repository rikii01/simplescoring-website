    <div class="container-fluid dashboard-2">

    <div class="row">
        <div class="col-12">
        <div class="page-title bg-primary text-white rounded p-3 mb-3">
            <div class="row">
            <div class="col-6">
                <h1 class="text-white" class="mb-0">Kelola Kriteria</h1>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo site_url('dashboard'); ?>" class="text-white text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active text-white">Edit Kriteria</li>
                </ol>
            </div>
            </div>
        </div>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- FORM -->
        <div class="col-xl-5 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
            <?php if (!empty($edit)): ?>
                <h5 class="mb-0">Edit Kriteria</h5>
                <span class="f-light">Ubah data kriteria, bobot dan tipe akan mempengaruhi perhitungan ranking.</span>
            <?php else: ?>
                <h5 class="mb-0">Tambah Kriteria</h5>
                <span class="f-light">Maksimal 10 kriteria. Bobot 1–5 dan tipe benefit/cost.</span>
            <?php endif; ?>
            </div>

            <div class="card-body">
            <?php
                $isEdit = !empty($edit);
                $action = $isEdit ? site_url('kriteria/update/'.(int)$edit->id) : site_url('kriteria/store');
            ?>
            <form method="post" action="<?php echo $action; ?>">
                <div class="mb-3">
                <label class="form-label">Nama Kriteria</label>
                <input type="text" name="name" class="form-control"
                        value="<?php echo $isEdit ? html_escape($edit->name) : ''; ?>"
                        placeholder="Contoh: Akreditasi / Biaya / Jarak" required>
                </div>

                <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Bobot (1–5)</label>
                    <select name="weight" class="form-select" required>
                    <?php for ($i=1; $i<=5; $i++): ?>
                        <option value="<?php echo $i; ?>"
                        <?php echo ($isEdit && (int)$edit->weight === $i) ? 'selected' : ''; ?>>
                        <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tipe</label>
                    <select name="type" class="form-select" required>
                    <option value="benefit" <?php echo ($isEdit && $edit->type === 'benefit') ? 'selected' : ''; ?>>Benefit</option>
                    <option value="cost" <?php echo ($isEdit && $edit->type === 'cost') ? 'selected' : ''; ?>>Cost</option>
                    </select>
                </div>
                </div>

                <div class="mt-3">
                <label class="form-label">Keterangan</label>
                <textarea name="description" class="form-control" rows="3"
                            placeholder="Contoh: Kriteria jarak: 5km / biaya: Rp 5-7jt"><?php echo $isEdit ? html_escape($edit->description) : ''; ?></textarea>
                </div>

                <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary d-flex align-items-center">
                    <i data-feather="save" class="me-1"></i>
                    <?php echo $isEdit ? 'Update Kriteria' : 'Simpan Kriteria'; ?>
                </button>

                <?php if ($isEdit): ?>
                    <a href="<?php echo site_url('kriteria'); ?>" class="btn btn-light">Batal</a>
                <?php endif; ?>
                </div>

                <div class="mt-3">
                <span class="badge badge-light-primary">
                    Total kriteria: <?php echo !empty($criterias) ? count($criterias) : 0; ?> / 10
                </span>
                </div>
            </form>
            </div>
        </div>
        </div>
        

        <!-- LIST -->
        <div class="col-xl-7 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
            <h5 class="mb-0">Daftar Kriteria</h5>
            <span class="f-light">Edit/hapus kriteria. Hapus akan menghapus skor alternatif pada kriteria tersebut.</span>
            </div>

            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                    <th style="width:90px;">Kode</th>
                    <th>Nama</th>
                    <th style="width:120px;">Tipe</th>
                    <th style="width:100px;">Bobot</th>
                    <th>Keterangan</th>
                    <th style="width:170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($criterias)): ?>
                    <?php foreach ($criterias as $c): ?>
                        <tr>
                        <td class="f-w-600"><?php echo html_escape($c->code); ?></td>
                        <td class="f-w-500"><?php echo html_escape($c->name); ?></td>
                        <td>
                            <span class="badge <?php echo ($c->type === 'benefit') ? 'badge-light-success' : 'badge-light-danger'; ?>">
                            <?php echo strtoupper($c->type); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-light-primary"><?php echo (int)$c->weight; ?></span>
                        </td>
                        <td><?php echo !empty($c->description) ? html_escape($c->description) : '-'; ?></td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-sm btn-warning d-flex align-items-center"
                            href="<?php echo site_url('kriteria?edit='.(int)$c->id); ?>">
                            <i data-feather="edit" class="me-1"></i> Edit
                            </a>

                            <a class="btn btn-sm btn-danger d-flex align-items-center"
                            href="<?php echo site_url('kriteria/delete/'.(int)$c->id); ?>"
                            onclick="return confirm('Hapus kriteria ini? Skor alternatif pada kriteria ini juga akan terhapus.');">
                            <i data-feather="trash-2" class="me-1"></i> Hapus
                            </a>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada kriteria.</td>
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

<?php if ($this->session->userdata('role') === 'admin'): ?>
                        <!-- ================= NORMALISASI BOBOT ================= -->
        <?php if (!empty($weight_norm)): ?>

        <div class="row g-4 mt-1 mb-4">

        <!-- ================= CHART (KIRI) ================= -->
        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card h-100">
            <div class="card-header card-no-border">
                <div class="header-top">
                <h5>Bobot Normalisasi</h5>
                </div>
            </div>
            <div class="card-body pt-0">
                <div id="weightNormChart"></div>
                <div class="mt-3 f-light">
                Total bobot = <b><?php echo (int)$total_weight; ?></b><br>
                </div>
            </div>
            </div>
        </div>

        <!-- ================= TABEL (KANAN) ================= -->
        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card h-100">
            <div class="card-header card-no-border">
                <div class="header-top">
                <h5>Tabel Bobot Normalisasi</h5>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle mb-0">
                    <thead class="table-primary">
                    <tr>
                        <th style="width:90px;">Kode</th>
                        <th>Nama</th>
                        <th style="width:70px;">w</th>
                        <th style="width:120px;">w'</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($weight_norm as $w): ?>
                    <tr>
                        <td class="f-w-600"><?php echo html_escape($w['code']); ?></td>
                        <td><?php echo html_escape($w['name']); ?></td>
                        <td class="text-center"><?php echo (int)$w['weight']; ?></td>
                        <td class="text-end"><?php echo number_format($w['norm'], 6); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-end">
                        <?php
                            $sum = 0;
                            foreach ($weight_norm as $w) $sum += $w['norm'];
                            echo number_format($sum, 6);
                        ?>
                        </th>
                    </tr>
                    </tfoot>
                </table>
                </div>
            </div>
            </div>
        </div>

        </div>
        <?php endif; ?>

        <?php endif; ?>
        <?php
        $labels = [];
        $series = [];
        foreach ($weight_norm as $w) {
            $labels[] = $w['code'].' - '.$w['name'];
            $series[] = (float)$w['norm'];
        }
        ?>

        <script>
        document.addEventListener("DOMContentLoaded", function () {

        if (typeof ApexCharts === "undefined") {
            console.warn("ApexCharts belum di-load");
            return;
        }

        const options = {
            chart: {
            type: 'donut',
            height: 300
            },
            labels: <?php echo json_encode($labels); ?>,
            series: <?php echo json_encode($series); ?>,
            dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val.toFixed(1) + "%";
            }
            },
            tooltip: {
            y: {
                formatter: function (value) {
                return "w' = " + Number(value).toFixed(6);
                }
            }
            },
            legend: {
            position: 'bottom'
            }
        };

        new ApexCharts(
            document.querySelector("#weightNormChart"),
            options
        ).render();

        });
        </script>


            <?php if (!empty($criterias) && count($criterias) >= 10): ?>
                <div class="alert alert-warning mb-0">
                Kamu sudah mencapai batas maksimal 10 kriteria.
                </div>
            <?php endif; ?>
            </div>
        </div>
        </div>

    </div>
    </div>
    </div>
            <!-- Konten halaman selesai di sini -->
          </div>
        </div>
      </div>