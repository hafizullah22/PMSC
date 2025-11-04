<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load necessary models, libraries, helpers here
        $this->load->model('Account_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        // Fetch all accounts from the model
        // $data['accounts'] = $this->Account_model->get_all_accounts();
        
        // Load the view and pass the accounts data
        $this->load->view('/accounts/index', $data);
    }

    public function create()
    {
        // Load the create account view
        $this->load->view('admin/accounts/create');
    }

    

}