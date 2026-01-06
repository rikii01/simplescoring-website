<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alternative_model extends CI_Model {

    private $table = 'alternatives';

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function get_all_with_score_count()
    {
        $this->db->select('a.id, a.name, a.created_at, COUNT(s.id) AS filled_scores', false);
        $this->db->from('alternatives a');
        $this->db->join('alternative_scores s', 's.alternative_id = a.id', 'left');
        $this->db->group_by('a.id');
        $this->db->order_by('a.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all()
    {
        $this->db->order_by('id', 'ASC');
        return $this->db->get($this->table)->result();
        return $this->db->order_by('id','ASC')->get($this->table)->result();
    }
}
