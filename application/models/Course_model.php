<?php
class Course_model extends CI_Model {

  public function get_all() {
    $this->db->select('c.*, b.batch_name, c.semester_id'); // select course, batch, and semester info
    $this->db->from('courses c');
    $this->db->join('batches b', 'b.batch_id = c.batch_id');
    return $this->db->get()->result();
}




public function admit_card($batch_id, $semester_id, $exam_year) {
    $this->db->select('course_id,course_name, semester_id,mid_exam_date,final_exam_date,mid_student_list'); // include semester_id if you want to filter by it
    $this->db->from('courses');
    $this->db->where([
        'batch_id' => $batch_id,
        'semester_id' => $semester_id,
        'exam_year' => $exam_year
    ]);

    return $this->db->get()->result(); // returns array of objects
}

public function insert($data) {
        return $this->db->insert('courses', $data);
    }

    public function get_by_id($course_id) {
        return $this->db->get_where('courses', ['course_id' => $course_id])->row();
    }


public function get_all_by_batch_id($batch_id)
{
    $result = $this->db
        ->where('batch_id', $batch_id)
        ->order_by('semester_id')
        ->get('courses')
        ->result();

    $grouped = [];

    foreach ($result as $row) {
        $grouped[$row->semester_id][] = $row;
    }

    return $grouped; // array[semester_id] => array of course objects
}



    public function update($course_id, $data) {
        $this->db->where('course_id', $course_id);
        return $this->db->update('courses', $data);
    }

    public function delete($course_id) {
        $this->db->where('course_id', $course_id);
        return $this->db->delete('courses');
    }
}
