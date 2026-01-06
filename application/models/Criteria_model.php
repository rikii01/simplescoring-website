<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Criteria_model extends CI_Model {

    private $table = 'criterias';

    public function all()
    {
        return $this->db
            ->order_by('id', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => (int)$id])->row();
    }

    public function count_all()
    {
        return (int)$this->db->count_all($this->table);
    }

    public function insert($data)
    {
        if (empty($data['code'])) {
            $next = $this->get_next_code_number();
            $data['code'] = 'C' . $next;
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', (int)$id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => (int)$id]);
    }

    private function get_next_code_number()
    {
        $row = $this->db->select('code')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get($this->table)
            ->row();

        if (!$row || empty($row->code)) return 1;

        $num = (int) preg_replace('/[^0-9]/', '', $row->code);
        return $num + 1;
    }
}
