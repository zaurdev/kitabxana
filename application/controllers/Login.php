

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	public function __construct() {
		parent:: __construct();
		$this->load->model("general_model");
	}
	public function index(){
		if(empty($this->session->userdata("user_id"))){
      $has_error=false;
      $error= "";
      if($this->input->method() == "post"){
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        if(!empty($email) && !empty($password)){
          $user = $this->general_model->get_user($email, $password);
          if($user){
            $this->session->set_userdata("user_id",$user->id);
						$this->user = $user;
						header("Location: /");
          }else{
            $has_error=true;
            $error = "İstifadəçi tapılmadı!";
          }
        }else{
          $has_error=true;
          $error = "Email və ya şifrə boş olmamalıdır!";
        }
      }
      $this->load->view('header');
      $this->load->view('login', [
        "has_error" => $has_error,
        "error" => $error,
      ]);
      $this->load->view('footer');
		}
		else{
      header("Location: /");
		}
	}
}
