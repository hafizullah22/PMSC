<?php
class Course_Bank_model extends CI_Model {

    public function get_all() {
        return $this->db->get('course_bank')->result();
    }

    public function insert($data) {
        return $this->db->insert('course_bank', $data);
    }

    public function get_by_id($course_id) {
        return $this->db->get_where('course_bank', ['course_id' => $course_id])->row();
    }
  
    
    public function get_all_active() {
        $this->db->where('status', 1);
        return $this->db->get('course_bank')->result();
    }


    public function update($id, $data) {
        return $this->db->where('course_id', $id)->update('course_bank', $data);
    }

    public function delete($id) {
        return $this->db->where('course_id', $id)->delete('course_bank');
    }
    public function count_all()
{
    return $this->db->count_all('course_bank');
}

}
