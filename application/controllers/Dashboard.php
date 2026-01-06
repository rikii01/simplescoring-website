<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // kalau ada auth middleware, taruh di sini
        // if (!$this->session->userdata('user_id')) redirect('login');

        $this->load->model('Alternative_model', 'alternative');
        $this->load->model('Criteria_model', 'criteria');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';

        // ================== DATA MONITORING ==================
        $data['total_alternatif'] = $this->db->count_all('alternatives');
        $data['total_kriteria']   = $this->db->count_all('criterias');

        // kalau mau pakai model (lebih rapi), bisa juga:
        // $data['total_alternatif'] = count($this->alternative->get_all());
        // $data['total_kriteria']   = count($this->criteria->all());

        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('layout/footer');
    }
}
