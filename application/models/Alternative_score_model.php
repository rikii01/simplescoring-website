<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alternative_score_model extends CI_Model {

    private $table = 'alternative_scores';

    public function upsert($alternative_id, $criteria_id, $score)
    {
        $exists = $this->db->get_where($this->table, [
            'alternative_id' => $alternative_id,
            'criteria_id'    => $criteria_id
        ])->row();

        if ($exists) {
            $this->db->where('id', $exists->id)->update($this->table, ['score' => $score]);
            return $exists->id;
        }

        $this->db->insert($this->table, [
            'alternative_id' => $alternative_id,
            'criteria_id'    => $criteria_id,
            'score'          => $score
        ]);
        return $this->db->insert_id();
    }

    public function delete_by_alternative($alternative_id)
    {
        return $this->db->delete($this->table, ['alternative_id' => $alternative_id]);
    }

    public function delete_by_criteria($criteria_id)
{
    return $this->db->delete($this->table, ['criteria_id' => (int)$criteria_id]);
}

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }
}
