<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	public function __construct() {
		parent:: __construct();
		$this->load->model("general_model");
	}
	public function index($page = 0)
	{
    	$this->load->library('pagination');

		$limit = 40;

		$search = $this->input->get('search')??'';

		$config['base_url'] = '/books';
		$config['total_rows'] = $this->general_model->count_books($search);
		$config['per_page'] = $limit;
		$config['uri_segment'] = 2;
		
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

		$books = $this->general_model->get_books_paginated($search, $limit, $page);

		$this->load->view('header');
		$this->load->view('home', [
			"books" => $books,
			"pagination" => $this->pagination->create_links(),
			"user" => $this->user,
			"search"=>$search,
			"count" => $config['total_rows']
		]);
		$this->load->view('footer');
	}
	public function logout() {
		session_destroy();
		header("Location:/");
	}
	public function get_book($id){
		$book = $this->general_model->get_book($id);
		$this->output
        ->set_content_type('application/json')
				->set_output(json_encode($book));
	}
	public function edit_book($id){
		$book = $this->general_model->get_book($id);
		$filePath = $book ? $book->file : null;

		if(isset($_FILES['book_file']) && $_FILES['book_file']['size'] > 0){
				$config['upload_path']   = FCPATH.'uploads/';
				$config['allowed_types'] = 'pdf';
				$config['max_size']      = 102400;
				$config['encrypt_name']  = TRUE;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('book_file')) {
					$this->output
					->set_status_header(422)
					->set_content_type('application/json')
					->set_output(json_encode([
						'error' => true,
						'message' => $this->upload->display_errors('', '')
					]));
					return;
				}
				$data = $this->upload->data();
				$filePath = 'uploads/'.$data['file_name'];
		}
		$info = [
			"file" => $filePath,
			"name" => $this->input->post("book_name"),
			"description" => $this->input->post("book_description")
		];
		$this->general_model->update_book($id, $info);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(['error' => false]));
	}

	public function add_book(){
		if(!isset($_FILES['add_book_file']) || $_FILES['add_book_file']['size'] <= 0){
			$this->output
				->set_status_header(422)
				->set_content_type('application/json')
				->set_output(json_encode([
					'error' => true,
					'message' => 'PDF fayli secmek mecburidir.'
				]));
			return;
		}
		$config['upload_path']   = FCPATH.'uploads/';
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = 102400;
		$config['encrypt_name']  = TRUE;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('add_book_file')) {
			$this->output
				->set_status_header(422)
				->set_content_type('application/json')
				->set_output(json_encode([
					'error' => true,
					'message' => $this->upload->display_errors('', '')
				]));
			return;
		}
		$data = $this->upload->data();
		$info = [
			"file" => 'uploads/'.$data['file_name'],
			"name" => $this->input->post("add_book_name"),
			"description" => $this->input->post("add_book_description")
		];

		$this->general_model->insert_book($info);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(['error' => false]));
	}

	public function delete_book($id){
		$book = $this->general_model->delete_book($id);
	}
}
