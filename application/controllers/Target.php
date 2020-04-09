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

        $data['categories'] = $this->target_model->get_categories();

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

        $data['target_data'] = $this->data_model->get_data();

        $data['categories'] = $this->target_model->get_categories();

        $this->load->view('templates/header', $data);
        $this->load->view('target/index', $data);
        $this->load->view('templates/footer');
    }

    public function details($targetId = NULL)
    {
        $data['target'] = $this->target_model->get_target_by_id($targetId)[0];

        $data['target_data'][$data['target']['id']] = $this->target_model->get_24hrs_for_target($targetId);

        $data['title'] = 'SuSi Monitor - last 24 hours of '.$data['target']['name'];

        $this->load->view('templates/header', $data);
        $this->load->view('target/details', $data);
        $this->load->view('templates/footer');
    }
}