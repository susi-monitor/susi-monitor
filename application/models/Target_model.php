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
        if (strlen($this->input->post('inputCategory')) < 1) {
            $category = null;
        } else {
            $category = $this->input->post('inputCategory');
        }

        if ($this->input->post('inputTimeout') == '0' || strlen($this->input->post('inputTimeout')) < 1) {
            $timeout = null;
        } else {
            $timeout = $this->input->post('inputTimeout');
        }

        $data = array(
            'name' => $this->input->post('inputName'),
            'url' => $this->input->post('inputURL'),
            'type' => $this->input->post('inputType'),
            'category' => $category,
            'timeout' => $timeout,
        );

        return $this->db->insert('targets', $data);
    }

    public function delete($targetId = null)
    {
        return $this->db->delete('targets', array('id' => $targetId));
    }

    public function edit()
    {
        $this->db->set('name', $this->input->post('inputName'));
        $this->db->set('url', $this->input->post('inputURL'));
        $this->db->set('type', $this->input->post('inputType'));

        if (strlen($this->input->post('inputCategory')) < 1) {
            $category = null;
        } else {
            $category = $this->input->post('inputCategory');
        }

        if ($this->input->post('inputTimeout') == '0' || strlen($this->input->post('inputTimeout')) < 1) {
            $timeout = null;
        } else {
            $timeout = $this->input->post('inputTimeout');
        }

        $this->db->set('category', $category);
        $this->db->set('timeout', $timeout);

        $this->db->where('id', $this->input->post('inputId'));

        return $this->db->update('targets');
    }
}