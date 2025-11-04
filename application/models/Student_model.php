<?php
class Student_model extends CI_Model {
    

    public function get_all() {
        $this->db->select('s.*, b.batch_name');
        $this->db->from('students s');
        $this->db->join('batches b', 'b.batch_id = s.batch_id');
        return $this->db->get()->result();
    }

    public function insert($data) {
        return $this->db->insert('students', $data);
    }

    public function insert_batch($data) {
    return $this->db->insert_batch('students', $data);
    }


    public function get_by_id($id) {
        return $this->db->get_where('students', ['id' => $id])->row();
    }
    public function get_by_std_id($std_id)
{
    return $this->db->get_where('students', ['std_id' => $std_id])->row();
}

 
public function get_student_by_id($std_id)
{
    return $this->db->where('std_id', $std_id)->get('students')->row();
}


    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('students', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('students');
    }

public function get_by_batch($batch_id) {
    return $this->db
                ->where('batch_id', $batch_id)
                ->get('students')
                ->result();
}
    public function count_all()
{
    return $this->db->count_all('students');
}

}
