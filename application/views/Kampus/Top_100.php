<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-12 col-md-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h5><i class="fa fa-university me-2"></i>Top 100 Kampus di Indonesia</h5>
                        <div class="card-header-right-icon">
                            <span class="badge badge-primary">Data Real-time</span>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0">
                    <div class="recent-table table-responsive custom-scrollbar" style="max-height: 500px; overflow-y: auto;">
                        <table class="table" id="table-top-kampus">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Universitas</th>
                                    <th>Website Resmi</th>
                                </tr>
                            </thead>
                            <tbody id="university-list">
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="loader-box"><div class="loader-3"></div> Memuat Data...</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tableBody = document.getElementById('university-list');

    // Data dari API Hipolabs
    fetch('http://universities.hipolabs.com/search?country=Indonesia')
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = '';

            const top100 = data.slice(0, 100);

            top100.forEach((uni, index) => {
                const row = `
                    <tr>
                        <td class="text-center f-w-600">${index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="f-w-500">${uni.name}</span>
                            </div>
                        </td>
                        <td>
                            <a href="${uni.web_pages[0]}" target="_blank" class="text-primary">
                                <i class="fa fa-external-link me-1"></i> Kunjungi Situs
                            </a>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(err => {
            tableBody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Gagal mengambil data dari API.</td></tr>';
        });
});

</script>