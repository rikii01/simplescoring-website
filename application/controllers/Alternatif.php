<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alternatif extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Criteria_model', 'criteria');
        $this->load->model('Alternative_model', 'alternative');
        $this->load->model('Alternative_score_model', 'alt_score');
        $this->load->library('Dss_simple_scoring', null, 'dss');
    }

    public function index()
    {
        $data['title'] = 'Input Alternatif';
        $data['criterias'] = $this->criteria->all();

        // list alternatif yang sudah diinput
        $data['alternatives'] = $this->alternative->get_all_with_score_count();

        // ================== TAMBAHAN: HITUNG RANKING ==================
$result = $this->dss->run();
$data['ranking']    = $result['ranking'];
$data['errors_dss'] = $result['errors'];

        // =============================================================

        $this->load->view('layout/header', $data);
        $this->load->view('alternatif/form', $data);
        $this->load->view('layout/footer');
    }

    public function store()
    {
        $name   = $this->input->post('alternative_name', true);
        $scores = $this->input->post('scores');

        if (!$name || empty($scores)) {
            $this->session->set_flashdata('error', 'Nama kampus dan nilai kriteria wajib diisi.');
            redirect('alternatif');
        }

        $this->db->trans_start();

        $alt_id = $this->alternative->insert([
            'name' => $name,
        ]);

        foreach ($scores as $criteria_id => $score) {
            $this->alt_score->upsert($alt_id, (int)$criteria_id, (int)$score);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menyimpan alternatif.');
        } else {
            $this->session->set_flashdata('success', 'Alternatif berhasil disimpan.');
        }

        redirect('alternatif');
    }

    public function delete($id)
    {
        $id = (int)$id;
        if ($id <= 0) redirect('alternatif');

        $this->db->trans_start();
        $this->alt_score->delete_by_alternative($id);
        $this->alternative->delete($id);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Alternatif berhasil dihapus.');
        redirect('alternatif');
    }
}
