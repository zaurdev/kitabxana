<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
	public function __construct() {
		parent:: __construct();
		$this->load->model("general_model");

	}
    public function get_users($page =1){
        $this->load->library('pagination');
		$limit = 40;
		$config['base_url'] = '/users/get_users';
		$config['total_rows'] = $this->general_model->count_users();
		$config['per_page'] = $limit;
        $config['uri_segment'] = $page;
        
		$config['first_link'] = 'Birinci';
		$config['last_link']  = 'Sonuncu';
		$config['next_link']  = 'Növbəti';
		$config['prev_link']  = 'Əvvəlki';

		$config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul></nav>';

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';

		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['attributes'] = ['class' => 'page-link'];

		$this->pagination->initialize($config);

		$users = $this->general_model->get_users_paginated($limit, $page);

        $table = '
            <a href="javascript:void(0)" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userInfoModal" >
                Əlavə et
            </a>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col" class="text-nowrap text-truncate">#</th>
                        <th scope="col" class="text-nowrap text-truncate">Email</th>
                        <th scope="col" class="text-nowrap text-truncate">Tam ad</th>
                        <th scope="col" class="text-nowrap text-truncate">Admin icazəsi</th>
                        <th scope="col" class="text-nowrap text-truncate">Əməliyyatlar</th>
                        </tr>
                    </thead>
                    <tbody>
                    
        ';


        for($i=0;$i<count($users);$i++){
            $table .= '
                <tr>
                    <th scope="row">'.($i+1).'</th>
                    <td class="text-nowrap text-truncate">'.($users[$i]->email).'</td>
                    <td class="text-nowrap text-truncate">'.($users[$i]->full_name).'</td>
                    <td class="text-nowrap text-truncate">
                        <select '.($users[$i]->id == $this->user->id ? 'disabled' : '').' data-id="'.($users[$i]->id).'" class="form-control form-control-sm userRoleSwitcher">
                            <option value="1" '.($users[$i]->is_admin ==1 ? 'selected' : '').'>Admin</option>
                            <option value="0" '.($users[$i]->is_admin ==0 ? 'selected' : '').'>İstifadəçi</option>
                        </select>
                    </td>
                    '.($users[$i]->id == $this->user->id ? '' : '
                    
                        <td class="text-nowrap text-truncate">
                            <a  href="javascript:void(0)" data-id="'.$users[$i]->id.'"  class="btn btn-primary btn-sm edit-user-btn" data-bs-toggle="modal" data-bs-target="#userInfoEditModal" > Düzəlt </a>
                            <a  href="javascript:void(0)" data-id="'.$users[$i]->id.'" class="btn btn-danger btn-sm del-user-btn" data-bs-toggle="modal" data-bs-target="#userDeleteModal" > Sistemdən sil </a>
                        </td>
        
                    ').'
                    
                </tr>
            ';
        }


        $table .= '
                </tbody>
                </table>
            </div>

        ';

        $table .=  $this->pagination->create_links();


        $data = [
            "table" => $table,
            "user" => $this->user,
        ];


       $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function delete($id) {
        $this->general_model->delete_user($id);
    }


    public function get_user($id) {
        $user = $this->general_model->get_user_with_id($id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($user));
    }

    public function add_user(){
        $user_email = $this->input->post("user_email");
        $user_full_name = $this->input->post("user_full_name");
        $user_password = $this->input->post("user_password");
        $user_role = $this->input->post("user_role");
        $data = [
            "email" => $user_email,
            "full_name" => $user_full_name,
            "password" => $user_password,
            "is_admin" => $user_role,
        ];

        // $this->general_model->add_user($data);
        if(!empty($data["email"]) && !empty($data["full_name"]) && !empty($data["password"])){
            $user = $this->general_model->check_email_exists($data["email"]);
            if(!$user) {
                $html = '<div class="alert alert-success" role="alert">  İstifadəçi məlumatları yeniləndi !</div>';
                $data["password"] = md5($data["password"]);
                $user = $this->general_model->add_user($data);
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        "error" => false,
                        "html" => $html,
                    ]));
            }else{
                $html = '<div class="alert alert-danger" role="alert"> Bu e-poçt adresi ilə istifadəçi mövcuddur!</div>';
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        "html" => $html,
                        "error" => true,
                    
                    ]));
            }
        }else{
            $html = '
                <div class="alert alert-danger" role="alert">
            ';
            if(empty($data["email"])){
                echo "E-poçt boş ola bilməz";
            }
            if(empty($data["full_name"])){
                echo "Tam ad boş ola bilməz";
            }
            if(empty($data["password"])){
                echo "Şifrəniz boş ola bilməz";
            }
            $html .= '
                </div>
            ';
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([

                    "html" => $html,
                    "error" => true,
                
                ]));
        }
    }
    
    public function set_role($id){
        $role_id = $this->input->post('role_id') ?? 0;
        $this->general_model->set_role($id, $role_id);
    }


    public function edit_user($user_id){
        $user_email = $this->input->post("user_email");
        $user_full_name = $this->input->post("user_full_name");
        $user_password = $this->input->post("user_password");
        $user_role = $this->input->post("user_role");
        $data = [
            "email" => $user_email,
            "full_name" => $user_full_name,
            "password" => $user_password,
            "is_admin" => $user_role,
        ];

        if(empty($data["password"])){
            unset($data["password"]);
        }else{
            $data["password"] = md5($data["password"]);
        }


        // $this->general_model->add_user($data);
        if(!empty($data["email"]) && !empty($data["full_name"]) && !empty($data["is_admin"])){
            $user = $this->general_model->check_email_exists($data["email"]);
            $user_email = $this->general_model->check_email($data['email'], $this->user->id);
            if(!$user_email){
                $html = '<div class="alert alert-success" role="alert">  İstifadəçi məlumatları yeniləndi !</div>';
                $this->general_model->update_user($user_id, $data);
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    "html" => $html,
                    "error" => false,
                
                ]));
            }else{
                $html = ' <div class="alert alert-danger" role="alert"> Bu e-poçt adresi artıq istifadə olunur.</div>';
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    "html" => $html,
                    "error" => true,
                
                ]));
            }
        }else{
            $html = '
                <div class="alert alert-danger" role="alert">
            ';
            if(empty($data["email"])){
                echo "E-poçt boş ola bilməz";
            }
            if(empty($data["full_name"])){
                echo "Tam ad boş ola bilməz";
            }
            if(empty($data["password"])){
                echo "Şifrəniz boş ola bilməz";
            }
            $html .= '
                </div>
            ';

             $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([

                    "html" => $html,
                    "error" => true,
                
                ]));
        }
    }
}
