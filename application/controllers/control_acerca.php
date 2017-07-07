<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_acerca extends CI_Controller {


	public function index(){
		if(!$this->session->userdata("minombre")){
        redirect(base_url('home'));
        }
		$this->load->view('bodega/header');
		$this->load->view("bodega/nav");
		$this->load->view("bodega/vista_acerca/view_acerca");
		$this->load->view("bodega/vista_acerca/footer2");
	}

	
} 

