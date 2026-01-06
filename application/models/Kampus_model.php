<?php
class Kampus_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function simpan_alternatif($data) {
        return $this->db->insert('alternatif', $data);
    }
}