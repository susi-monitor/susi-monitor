<?php

class Admin extends CI_Controller
{

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

    public function add()
    {
        $data['title'] = PAGE_TITLE.' - Administration';
        $data['categories'] = $this->target_model->get_categories();
        $data['removeFooterLinks'] = true;

        $this->load->view('templates/header', $data);
        $this->load->view('admin/add', $data);
        $this->load->view('templates/footer');
    }

    public function edit($targetId = NULL)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['targetId'] = $targetId;

        $data['target'] = $this->target_model->get_target_by_id($targetId)[0];
        $data['title'] = PAGE_TITLE.' - Administration';
        $data['target_data'] = $this->data_model->get_data();
        $data['categories'] = $this->target_model->get_categories();
        $data['removeFooterLinks'] = true;

        $this->load->view('templates/header', $data);
        $this->load->view('admin/edit', $data);
        $this->load->view('templates/footer');
    }

    public function delete($targetId = NULL)
    {
        $data['target'] = $this->target_model->get_target_by_id($targetId)[0];
        $data['title'] = PAGE_TITLE.' - Administration';
        $data['target_data'] = $this->data_model->get_data();
        $data['removeFooterLinks'] = true;

        $this->load->view('templates/header', $data);
        $this->load->view('admin/delete', $data);
        $this->load->view('templates/footer');
    }

    public function add_action()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = PAGE_TITLE.' - Add monitoring target';

        $this->form_validation->set_rules('inputName', 'Name', 'required');
        $this->form_validation->set_rules('inputURL', 'URL', 'required');
        $this->form_validation->set_rules('inputType', 'Type', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/add');
            $this->load->view('templates/footer');

        }
        else
        {
            $this->target_model->add();
            $data['successMessage'] = 'Successfully added monitoring on target service';

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

    public function edit_action(){
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = PAGE_TITLE.' - Edit monitoring target';
        $data['targetId'] = $this->input->post('inputId');
        $data['target'] = array(
            'name' => $this->input->post('inputName'),
            'url' => $this->input->post('inputURL'),
            'type' => $this->input->post('inputType'),
            'category' => $this->input->post(
                'inputCategory'
            ),
        );

        $this->form_validation->set_rules('inputName', 'Name', 'required');
        $this->form_validation->set_rules('inputURL', 'URL', 'required');
        $this->form_validation->set_rules('inputType', 'Type', 'required');
        $this->form_validation->set_rules('inputId', 'ID', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit', $data);
            $this->load->view('templates/footer');

        }
        else
        {
            $this->target_model->edit();
            $data['successMessage'] = 'Successfully edited monitoring configuration';

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

    public function delete_action($targetId = NULL){
        $this->target_model->delete($targetId);
        $data['successMessage'] = 'Successfully deleted monitoring target';

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