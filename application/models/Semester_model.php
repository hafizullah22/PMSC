<?php
class Semester_model extends CI_Model {

    public function get_all() {
        $this->db->select('s.*, b.batch_name');
        $this->db->from('semester s');
        $this->db->join('batches b', 'b.batch_id = s.batch_id');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('semester', ['id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('semester', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('semester', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('semester');
    }
    
public function get_semesters_by_batch($batch_id)
{
    return $this->db->where('batch_id', $batch_id)->get('semester')->result();
}

// Get all semester IDs up to the selected semester (based on serial_no)
public function get_previous_semesters($semester_id)
{
    $semester = $this->get_by_id($semester_id);
    if (!$semester) return [];

    $this->db->select('semester_id');
    $this->db->where('id <=', $semester->id); // id defines order
    $this->db->order_by('id', 'asc');
    $query = $this->db->get('semester');

    return array_column($query->result_array(), 'semester_id');
}
// Get full semester objects by IDs
public function get_semesters_by_ids($semester_ids)
{
    if (empty($semester_ids)) return [];

    $this->db->where_in('semester_id', $semester_ids);
    $this->db->order_by('id', 'asc');
    $query = $this->db->get('semester');

    $result = [];
    foreach ($query->result() as $row) {
        $result[$row->semester_id] = $row;
    }
    return $result;
}

public function get_semester_fees_by_batch($batch_id, $semester_ids)
{
    if (empty($semester_ids)) return [];

    $this->db->where('batch_id', $batch_id);
    $this->db->where_in('semester_id', $semester_ids);
    $query = $this->db->get('semester'); // or your actual table

    $result = [];
    foreach ($query->result() as $row) {
        $result[$row->semester_id] = $row;
    }
    return $result;
}
// In Semester_model.php
public function get_semesters_by_batch_up_to($batch_id, $up_to_semester_id)
{
    return $this->db
        ->where('batch_id', $batch_id)
        ->where('semester_id <=', $up_to_semester_id)
        ->order_by('semester_id', 'asc')
        ->get('semester')
        ->result();
}

public function get_semester_by_id($semester_id)
{
    return $this->db->get_where('semester', ['semester_id' => $semester_id])->row();
}

public function get_by_id_and_batch($semester_id, $batch_id)
{
    return $this->db->where('semester_id', $semester_id)
                    ->where('batch_id', $batch_id)
                    ->get('semester')
                    ->row();
}






public function get_semesters_by_ids_and_batch($ids, $batch_id)
{
    $result = $this->db
                   ->where_in('semester_id', $ids)
                   ->where('batch_id', $batch_id)
                   ->get('semester')
                   ->result();

    $output = [];
    foreach ($result as $row) {
        $output[$row->semester_id] = $row;
    }
    return $output;
}

}
