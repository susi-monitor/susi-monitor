<?php
class Target extends CI_Controller {

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

        $data['title'] = 'SuSi Monitor';

        $data['target_data'] = $this->data_model->get_data();

        $this->load->view('templates/header', $data);
        $this->load->view('target/index', $data);
        $this->load->view('templates/footer');
    }

    public function view_category($category = NULL)
    {
        $data['targets'] = $this->target_model->get_targets($category);

        if (empty($data['targets']))
        {
            show_404();
        }

        $data['title'] = 'SuSi Monitor - '.$category;

        $this->load->view('templates/header', $data);
        $this->load->view('target/index', $data);
        $this->load->view('templates/footer');
    }
}