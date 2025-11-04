<?php
class Transaction_model extends CI_Model {

    public function get_all() {
        $this->db->select('t.*, s.name AS student_name');
        $this->db->from('transactions t');
        $this->db->join('students s', 's.std_id = t.student_id');
        $this->db->order_by('t.transaction_id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('transactions', ['transaction_id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('transactions', $data);
    }

    public function update($id, $data) {
        $this->db->where('transaction_id', $id);
        return $this->db->update('transactions', $data);
    }

    public function delete($id) {
        $this->db->where('transaction_id', $id);
        return $this->db->delete('transactions');
    }

    public function get_by_student_and_semester($student_id, $semester_id)
{
    $this->db->select('t.*, sem.JnU_Amount AS total_jnu, sem.miscellaneous_amount AS total_misc, sem.Seminar_amount AS total_seminar');
    $this->db->from('transactions t');
    $this->db->join('semester sem', 'sem.semester_id = t.semester_id');
    $this->db->where('t.student_id', $student_id);

    if (!empty($semester_id)) {
        $this->db->where('t.semester_id', $semester_id);
    }

    return $this->db->get()->result();
}

public function get_by_student_and_semesters($student_id, $semester_ids)
{
   return $this->db->get_where('transactions', [
        'student_id'   => $student_id,
        'semester_id'  => $semester_id
    ])->result();

}
// Transaction_model.php

public function get_student_by_std_id($std_id)
{
    return $this->db->get_where('students', ['std_id' => $std_id])->row();
}

public function get_batch_by_id($batch_id)
{
    return $this->db->get_where('batches', ['batch_id' => $batch_id])->row();
}

public function get_semester_by_id($semester_id)
{
    return $this->db->get_where('semester', ['semester_id' => $semester_id])->row();
}



public function get_transactions_up_to_semester($std_id, $semester_id)
{
    return $this->db->where('student_id', $std_id)
                    ->where('semester_id <=', $semester_id)
                    ->order_by('semester_id', 'asc')
                    ->get('transactions')
                    ->result();
}


public function get_upto_selected_semester($student_id, $batch_id, $selected_semester_id)
{
    // First, get the selected semester's internal ID
    $selected_semester = $this->db->get_where('semester', [
        'batch_id' => $batch_id,
        'semester_id' => $selected_semester_id
    ])->row();

    if (!$selected_semester) {
        return []; // No semester found
    }

    return $this->db->select('t.*, s.semester_id')
        ->from('transactions t')
        ->join('semester s', 's.id = t.semester_id', 'left')
        ->where('t.student_id', $student_id)
        ->where('s.batch_id', $batch_id)
        ->where('s.id <=', $selected_semester->id)
        ->order_by('s.id', 'asc')
        ->get()
        ->result();
}

public function get_semester_wise_dues($std_id, $batch_id, $up_to_semester_id)
{
    // Get all semesters for the student's batch up to selected semester
    $semesters = $this->db->where('batch_id', $batch_id)
                          ->where('id <=', $up_to_semester_id)
                          ->order_by('id', 'asc')
                          ->get('semester')
                          ->result();

    $dues = [];

    foreach ($semesters as $sem) {
        // Get total paid
        $paid_data = $this->db->select_sum('seminar_amount')
                              ->select_sum('jnu_amount')
                              ->select_sum('miscellaneous_amount')
                              ->where('student_id', $std_id)
                              ->where('semester_id', $sem->id)
                              ->get('transactions')
                              ->row();

        $total_paid = ($paid_data->seminar_amount ?: 0) + ($paid_data->jnu_amount ?: 0) + ($paid_data->miscellaneous_amount ?: 0);

        // Calculate semester fee from semester table
        $semester_fee = ($sem->seminar_amount ?: 0) + ($sem->jnu_amount ?: 0) + ($sem->miscellaneous_amount ?: 0);

        // Calculate due
        $dues[] = [
            'semester_id'   => $sem->id,
            // 'title'         => $sem->title,
            'semester_fee'  => $semester_fee,
            'paid'          => $total_paid,
            'due'           => $semester_fee - $total_paid,
        ];
    }

    return $dues;
}


// In Transaction_model.php
public function get_transactions_upto_semester($std_id, $up_to_semester_id)
{
    // Fetch semesters up to the selected semester for this student’s batch
    $this->load->model('Student_model');
    $student = $this->Student_model->get_student_by_id($std_id);
    if (!$student) return [];

    $batch_id = $student->batch_id;

    $semesters = $this->db
        ->select('semester_id')
        ->where('batch_id', $batch_id)
        ->where('semester_id <=', $up_to_semester_id)
        ->get('semester')
        ->result();

    $semester_ids = array_column($semesters, 'semester_id');

    if (empty($semester_ids)) return [];

    return $this->db
        ->where('student_id', $std_id)
        ->where_in('semester_id', $semester_ids)
        ->order_by('semester_id', 'asc')
        ->get('transactions')
        ->result();
}



public function get_by_date_range($start_date, $end_date)
{
    $this->db->select('t.*, s.name AS student_name, s.batch_id, b.batch_name');
    $this->db->from('transactions t');
    $this->db->join('students s', 's.std_id = t.student_id', 'left');
    $this->db->join('batches b', 'b.batch_id = s.batch_id', 'left');

    if (!empty($start_date)) {
        $this->db->where('t.entry_date >=', $start_date);
    }

    if (!empty($end_date)) {
        $this->db->where('t.entry_date <=', $end_date);
    }

    $this->db->order_by('t.transaction_date', 'ASC');
    
    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->result() : [];
}




public function count_all()
{
    return $this->db->count_all('transactions');
}

public function by_month($month = null, $year = null)
{
    if (!$month) $month = date('m');
    if (!$year) $year = date('Y');

    $this->db->where('MONTH(transaction_date)', $month);
    $this->db->where('YEAR(transaction_date)', $year);
    return $this->db->get('transactions')->result();
}



}