<?php
  class General_model  extends CI_Model{
    public function get_user($email, $password){
      return $this->db->where("email", $email)->where("password", md5($password))->get("users")->row();
    }
    public function get_books() {
      return $this->db->get("books")->result();
    }
    public function get_user_with_id($id) {
      return $this->db->where("id", $id)->get("users")->row();
    }
    public function get_book($id){
      return $this->db->where("id", $id)->get("books")->row();
    }
    public function update_book($id, $data){
      return $this->db->where("id", $id)->update("books", $data);
    }
    public function count_books($search)
    {
        return $this->db->or_like('description', $search, 'both')->like('name', $search, 'both')->count_all_results('books');
    }
    public function get_books_paginated($search="",$limit, $offset)
    {
        return $this->db
            ->limit($limit, $offset)
            ->order_by('id', 'DESC')
            ->or_like('name', $search, 'both')
            ->or_like('description', $search, 'both')
            ->get('books')
            ->result();
    }
    public function count_users()
    {
        return $this->db->count_all('users');
    }
    public function get_users_paginated($limit, $offset)
    {
        return $this->db
            ->limit($limit, $offset)
            ->order_by('id', 'DESC')
            ->get('users')
            ->result();
    }
    public function delete_book($id){
      return $this->db->where("id", $id)->delete("books");
    }

    public function delete_user($id) {
      return $this->db->where('id', $id)->delete('users');
    }

    public function check_email_exists($email){
      return $this->db->where("email", $email)->get("users")->row();
    }

    public function add_user($data) {
      return $this->db->insert("users", $data);
    }
    public function update_user($id, $data) {
      return $this->db->where('id', $id)->update("users", $data);
    }
    public function check_email($email, $id) {
      return $this->db->where('email', $email)->where('id !=', $id)->get('users')->row();
    }
    public function set_role($user_id, $role_id) {
      return $this->db->where('id',$id)->update('users', ['is_admin'=>$role_id]);
    }
    public function insert_book($book) {
      return $this->db->insert('books', $book);
    }
  }
?>
 