<?php
class Admin_user_model extends CI_Model {
    public function get_by_email($email) {
        return $this->db->get_where('admin_users', ['email' => $email])->row();
    }
}
