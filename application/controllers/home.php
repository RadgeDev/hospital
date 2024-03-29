<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  public function __construct(){
    parent::__construct();

    $this->load->model('Usuario_model');
  }

  public function index(){

if(!$this->session->userdata("minombre")){
   $this->load->view('home');
   
}else{
    redirect(base_url('welcome'));
}
  }


  function ingresar(){
    $user = $this->input->post("username");
    $password= sha1($this->input->post("password"));

    $resp = $this->Usuario_model->login($user,$password);

    if($resp){
      $data = [
        "mirut" => $resp->rut,
        "minombre" => $resp->nombre,
        "usuario" => $resp->tipo_usuario,
        "login" => TRUE
      ];
print_r($data);
      $this->session->set_userdata($data);
    }
    else{
      echo "error";
    }
  }

 public function logout() {
   $this->session->sess_destroy();
   redirect('home');
   }
}