<?php
class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('target_model');
        $this->load->model('data_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['targets'] = $this->target_model->get_targets();
        $data['title'] = PAGE_TITLE.' - Administration';
        $data['target_data'] = $this->data_model->get_data();
        $data['categories'] = $this->target_model->get_categories();
        $data['removeFooterLinks'] = true;

        $this->load->view('templates/header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
}