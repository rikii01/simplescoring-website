<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kampus extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Pastikan login jika diperlukan
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = "Top 100 Kampus Indonesia";
        

        $this->load->view('layout/header', $data);
        $this->load->view('kampus/top_100', $data);
        $this->load->view('layout/footer');
    }
}