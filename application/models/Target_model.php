<?php
class Target_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_targets($category = NULL)
    {
        if ($category === NULL)
        {
            $query = $this->db->get('targets');
            return $query->result_array();
        }

        $query = $this->db->get_where('targets', array('category' => $category));
        return $query->result_array();
    }

    public function get_categories()
    {
        $this->db->select('category');
        $this->db->distinct();
        $query = $this->db->get('targets');

        return $query->result_array();
    }

    public function get_data_for_target($targetId = NULL)
    {
        if ($targetId !== NULL)
        {
            $query = $this->db->get_where('data', array('target_id' => $targetId));
            return $query->result_array();
        }

        return null;
    }
}