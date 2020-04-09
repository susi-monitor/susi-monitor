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
        $this->db->where('category IS NOT NULL');
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

    public function get_target_by_id($targetId = NULL)
    {
        if ($targetId !== NULL)
        {
            $query = $this->db->get_where('targets', array('id' => $targetId));
            return $query->result_array();
        }

        return null;
    }

    public function get_24hrs_for_target($targetId = NULL)
    {
        if ($targetId !== NULL)
        {
            $dateLimitInThePast = date('U', strtotime('-24 hours'));
            $query = $this->db->order_by('datetime', 'DESC')->get_where('data', array('target_id' => $targetId, 'datetime >' => $dateLimitInThePast));
            return $query->result_array();
        }

        return null;
    }

    public function add()
    {

        $data = array(
            'name' => $this->input->post('inputName'),
            'url' => $this->input->post('inputURL'),
            'type' => $this->input->post('inputType'),
            'category' => $this->input->post('inputCategory')
        );

        return $this->db->insert('targets', $data);
    }

    public function delete($targetId = null)
    {
        return $this->db->delete('targets', array('id' => $targetId));
    }
}