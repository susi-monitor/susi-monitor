<?php

class Data_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_data()
    {
        $this->db->order_by('datetime', 'DESC');
        $this->db->limit(12);

        $query = $this->db->get('data');
        $result = $query->result_array();


        $resultSorted = array();

        foreach ($result as $res) {
            $resultSorted[$res['target_id']][] = $res;
        }

        return array_reverse($resultSorted);
    }
}