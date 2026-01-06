<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Criteria_model', 'criteria');
        $this->load->model('Alternative_score_model', 'alt_score');
    }

public function index()
{
    $data['title'] = 'Kelola Kriteria';
    $data['criterias'] = $this->criteria->all();

    // ===== NORMALISASI BOBOT =====
    $totalWeight = 0;
    foreach ($data['criterias'] as $c) {
        $totalWeight += (int)$c->weight;
    }

    $data['weight_norm'] = [];
    if ($totalWeight > 0) {
        foreach ($data['criterias'] as $c) {
            $data['weight_norm'][] = [
                'code'   => $c->code,
                'name'   => $c->name,
                'weight' => (int)$c->weight,
                'norm'   => round(((int)$c->weight / $totalWeight), 6),
            ];
        }
    }
    $data['total_weight'] = $totalWeight;

    $edit_id = (int) $this->input->get('edit');
    $data['edit'] = null;
    if ($edit_id > 0) {
        $data['edit'] = $this->criteria->get_by_id($edit_id);
    }

    $this->load->view('layout/header', $data);
    $this->load->view('kriteria/index', $data);
    $this->load->view('layout/footer');
}


    public function store()
    {
        $name = trim($this->input->post('name', true));
        $weight = (int) $this->input->post('weight');
        $type = $this->input->post('type', true);
        $description = trim($this->input->post('description', true));

        if ($name === '' || $weight < 1 || $weight > 5 || !in_array($type, ['benefit', 'cost'])) {
            $this->session->set_flashdata('error', 'Input tidak valid. Pastikan nama, bobot 1-5, dan tipe benefit/cost benar.');
            redirect('kriteria');
        }

        if ($this->criteria->count_all() >= 10) {
            $this->session->set_flashdata('error', 'Maksimal kriteria adalah 10. Tidak bisa menambah kriteria lagi.');
            redirect('kriteria');
        }

        $this->criteria->insert([
            'name' => $name,
            'weight' => $weight,
            'type' => $type,
            'description' => $description,
        ]);

        $this->session->set_flashdata('success', 'Kriteria berhasil ditambahkan.');
        redirect('kriteria');
    }

    public function update($id)
    {
        $id = (int)$id;
        if ($id <= 0) redirect('kriteria');

        $name = trim($this->input->post('name', true));
        $weight = (int) $this->input->post('weight');
        $type = $this->input->post('type', true);
        $description = trim($this->input->post('description', true));

        if ($name === '' || $weight < 1 || $weight > 5 || !in_array($type, ['benefit', 'cost'])) {
            $this->session->set_flashdata('error', 'Input tidak valid. Pastikan nama, bobot 1-5, dan tipe benefit/cost benar.');
            redirect('kriteria?edit='.$id);
        }

        $this->criteria->update($id, [
            'name' => $name,
            'weight' => $weight,
            'type' => $type,
            'description' => $description,
        ]);

        $this->session->set_flashdata('success', 'Kriteria berhasil diupdate.');
        redirect('kriteria');
    }

    public function delete($id)
    {
        $id = (int)$id;
        if ($id <= 0) redirect('kriteria');

        $this->db->trans_start();
        $this->alt_score->delete_by_criteria($id);
        $this->criteria->delete($id);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Kriteria berhasil dihapus.');
        redirect('kriteria');
    }
}
