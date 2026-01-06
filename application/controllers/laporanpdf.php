<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanPdf extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // optional: admin only
        // if ($this->session->userdata('role') !== 'admin') redirect('dashboard');

        $this->load->library('Dss_simple_scoring', null, 'dss');
        $this->load->model('Criteria_model', 'criteria');
        $this->load->model('Alternative_model', 'alternative');
    }

    public function index()
    {
        $dss = $this->dss->run();

        if (!empty($dss['errors'])) {
            $this->session->set_flashdata('error', implode(' | ', $dss['errors']));
            redirect('alternatif');
        }

        $data = [
            'ranking'    => $dss['ranking'],
            'criterias'  => $this->criteria->all(),
            'generated'  => date('d-m-Y H:i'),
            'title'      => 'Laporan Sistem Pendukung Keputusan',
            'subtitle'   => 'Metode Simple Scoring'
        ];

        // render HTML dari view khusus PDF
        $html = $this->load->view('laporan/pdf', $data, true);

        // ================= DOMPDF =================
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Times');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Laporan_SPK_SimpleScoring.pdf';

        $dompdf->stream($filename, [
            'Attachment' => true // true = download, false = preview
        ]);
        exit;
    }
}
