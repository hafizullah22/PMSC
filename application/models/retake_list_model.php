<?php
class Retake_List_model extends CI_Model {

    public function get_all() {
        return $this->db->get('retake_list')->result();
    }

    public function insert($data) {
        return $this->db->insert('retake_list', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('retake_list', ['id' => $id])->row();
    }
  
    public function sheet($exam_year) {
        $this->db->select('c.course_id, c.student_list,b.course_name'); // include semester_id if you want to filter by it
        $this->db->from('retake_list c');
        $this->db->join('course_bank b', 'b.course_id = c.course_id');
        $this->db->where([
            'exam_year' => $exam_year
        ]);

        return $this->db->get()->result(); // returns array of objects
    }
 public function get_list() {
        $this->db->select('c.id,c.course_id, c.student_list,c.exam_year,b.course_name'); // include semester_id if you want to filter by it
        $this->db->from('retake_list c');
        $this->db->join('course_bank b', 'b.course_id = c.course_id');
        $this->db->order_by('c.id', 'DESC'); // Order by ID in descending order

        return $this->db->get()->result(); // returns array of objects
    }
public function get_list_id($id) {
    $this->db->select('c.id, c.course_id, c.student_list, c.exam_year, b.course_name');
    $this->db->from('retake_list c');
    $this->db->join('course_bank b', 'b.course_id = c.course_id');
    $this->db->where('c.id', $id);
    $query = $this->db->get();
    return $query->row(); // single object or null if not found
}


    public function update($id, $data) {
        return $this->db->where('id', $id)->update('retake_list', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('retake_list');
    }
    public function count_all()
{
    return $this->db->count_all('retake_list');
}

}
