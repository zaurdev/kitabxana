<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $user = null;
    public function __construct(){
      parent:: __construct();
      $this->load->model("general_model");
      if(empty($this->session->userdata("user_id"))) {
        $path = $this->uri->segment(1);
        if(empty($path) || $path != "login"){
          header("Location: /login");
        }
      }
      if(!empty($this->session->userdata("user_id"))) {
        if(!empty($path) && $path == "login"){
          header("Location: /");
        }
      }
      $this->user = $this->general_model->get_user_with_id($this->session->userdata("user_id"));
    }
}
