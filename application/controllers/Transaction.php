<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

    public function __construct() {
        parent::__construct();    
        $this->load->model('Student_model');
        $this->load->model('Batch_model');
        $this->load->model('Semester_model');
        $this->load->model('Transaction_model');
        $this->load->library(['form_validation', 'session']);
        if (!$this->session->userdata('admin_id')) {
            redirect('admin/login');
        }
    }

    public function index() {
        $data['transactions'] = $this->Transaction_model->get_all();
        $data['title'] = 'Transactions';
        $data['content'] = 'transaction/list';
        $this->load->view('admin/template', $data);
    }

    public function add() {
        if ($this->input->method() == 'post') {
            $data = [
                'student_id' => $this->input->post('student_id'),
                'semester_id' => $this->input->post('semester_id'),
                'receipt_no_jnu' => $this->input->post('receipt_no_jnu'),
                'JnU_Amount' => $this->input->post('JnU_Amount'),
                'receipt_no_misc' => $this->input->post('receipt_no_misc'),
                'Miscellaneous_amount' => $this->input->post('miscellaneous_amount'),
                'receipt_no_seminar' => $this->input->post('receipt_no_seminar'),
                'Seminar_amount' => $this->input->post('Seminar_amount'),
                'transaction_date' => $this->input->post('transaction_date')
            ];
            $this->form_validation->set_rules('student_id', 'Student ID', 'required');
            $this->form_validation->set_rules('semester_id', 'Semester ID', 'required');
            $this->form_validation->set_rules('receipt_no_jnu', 'Receipt No (JNU)', 'is_unique[transactions.receipt_no_jnu]');
            $this->form_validation->set_rules('receipt_no_misc', 'Receipt No (Misc)', 'is_unique[transactions.receipt_no_misc]');
            $this->form_validation->set_rules('receipt_no_seminar', 'Receipt No (Seminar)', 'is_unique[transactions.receipt_no_seminar]');
           
            if ($this->form_validation->run() == TRUE) {
                $this->Transaction_model->insert($data);
                $this->session->set_flashdata('success', 'Transaction added successfully.');
                redirect('transaction');
            }
            else{
                $this->session->set_flashdata('error', validation_errors());
            }
        }
        
        $data['students'] = $this->Student_model->get_all();
        $data['title'] = 'Add Transaction';
        $data['content'] = 'transaction/add';
        $this->load->view('admin/template', $data);
    }

    public function edit($id) {
        if ($this->input->method() == 'post') {
            $data = [
                'student_id' => $this->input->post('student_id'),
                'semester_id' => $this->input->post('semester_id'),
                'receipt_no_jnu' => $this->input->post('receipt_no_jnu'),
                'JnU_Amount' => $this->input->post('JnU_Amount'),
                'receipt_no_misc' => $this->input->post('receipt_no_misc'),
                'miscellaneous_amount' => $this->input->post('miscellaneous_amount'),
                'receipt_no_seminar' => $this->input->post('receipt_no_seminar'),
                'Seminar_amount' => $this->input->post('Seminar_amount'),
                'waiver'=> $this->input->post('waiver'),
                'transaction_date' => $this->input->post('transaction_date')
            ];
            $this->Transaction_model->update($id, $data);
            $this->session->set_flashdata('success', 'Transaction updated successfully.');
            redirect('transaction');
        }

        $data['transaction'] = $this->Transaction_model->get_by_id($id);
        $data['students'] = $this->Student_model->get_all();
        $data['title'] = 'Edit Transaction';
        $data['content'] = 'transaction/edit';
        $this->load->view('admin/template', $data);
    }

    public function delete($id) {
        $this->Transaction_model->delete($id);
        redirect('transaction');
    }

    public function report()
{
    $this->load->model('Batch_model');

    $batch_id = $this->input->get('batch_id');
    $semester_id = $this->input->get('semester_id');
    $payment_status = $this->input->get('payment_status');

    $data['batches'] = $this->Batch_model->get_all();
    $data['selected_batch'] = $batch_id;
    $data['selected_semester'] = $semester_id;
    $data['title'] = 'Transaction Report';
    $data['content'] = 'transaction/report';

    if (!$batch_id || !$semester_id) {
        $data['transactions'] = [];
        $data['semester_list'] = [];
        $data['semester'] = null;
        $data['error'] = 'Select Batch and Semester to Get Transaction Report.';
        $this->load->view('admin/template', $data);
        return;
    }

    // Fetch all semesters up to selected semester
    $semester = $this->db->get_where('semester', [
        'batch_id' => $batch_id,
        'semester_id' => $semester_id
    ])->row();
    $data['semester'] = $semester;

    $semester_list = $this->db->select('*')
        ->from('semester')
        ->where('batch_id', $batch_id)
        ->where('id <=', $semester->id)
        ->order_by('id', 'asc')
        ->get()
        ->result();
    $data['semester_list'] = $semester_list;

    // Get cumulative transaction summary per student
    $this->db->select('
        s.std_id, s.name, s.batch_id,
        SUM(t.JnU_Amount) AS paid_jnu,
        SUM(t.miscellaneous_amount) AS paid_misc,
        SUM(t.seminar_amount) AS paid_seminar,
        SUM(t.waiver) AS waiver,

    ');
    $this->db->from('students s');
    $this->db->join('transactions t', 't.student_id = s.std_id', 'left');
    $this->db->where('s.batch_id', $batch_id);
    $this->db->where_in('t.semester_id', array_column($semester_list, 'semester_id'));
    $this->db->group_by('s.std_id');
    $transactions = $this->db->get()->result();
    $data['transactions'] = $transactions;

    foreach ($transactions as $student) {
    $std_id = $student->std_id;
    foreach ($semester_list as $sem) {
        $paid = $this->db->select_sum('JnU_Amount', 'jnu')
            ->select_sum('miscellaneous_amount', 'misc')
            ->select_sum('Seminar_amount', 'seminar')
            ->select_sum('waiver', 'waiver')
            ->where('student_id', $std_id)
            ->where('semester_id', $sem->semester_id)
            ->get('transactions')->row();

        // Ensure NULL values are treated as 0
        $actual_paid = ($paid->jnu ?? 0) + ($paid->misc ?? 0) + ($paid->seminar ?? 0) + ($paid->waiver ?? 0);

        // Always calculate due as full expected amount minus paid (even if paid is 0)
        $expected = $sem->jnu_amount + $sem->miscellaneous_amount + $sem->seminar_amount;

        // Save due (full expected if no transaction)
        $semester_due_map[$std_id][$sem->semester_id] = max($expected - $actual_paid, 0);
    }
}
    
    $data['semester_due_map'] = isset($semester_due_map) ? $semester_due_map : [];

    $this->load->view('admin/template', $data);
}



//Batch wise PDF report
 public function pdf_report()
{
    $this->load->model('Batch_model');

    $batch_id = $this->input->get('batch_id');
    $semester_id = $this->input->get('semester_id');
    $payment_status = $this->input->get('payment_status');

    $data['batches'] = $this->Batch_model->get_all();
    $data['selected_batch'] = $batch_id;
    $data['batch_name']=$this->Batch_model->get_by_id($batch_id);
    $data['selected_semester'] = $semester_id;
    $data['title'] = 'Transaction Report';
    $data['content'] = 'transaction/report';

    if (!$batch_id || !$semester_id) {
        $data['transactions'] = [];
        $data['semester_list'] = [];
        $data['semester'] = null;
        $data['error'] = 'Select Batch and Semester to Get Transaction Report.';
        $this->load->view('admin/template', $data);
        return;
    }

    // Fetch all semesters up to selected semester
    $semester = $this->db->get_where('semester', [
        'batch_id' => $batch_id,
        'semester_id' => $semester_id
    ])->row();
    $data['semester'] = $semester;

    $semester_list = $this->db->select('*')
        ->from('semester')
        ->where('batch_id', $batch_id)
        ->where('id <=', $semester->id)
        ->order_by('id', 'asc')
        ->get()
        ->result();
    $data['semester_list'] = $semester_list;

    // Get cumulative transaction summary per student
    $this->db->select('
        s.std_id, s.name,s.phone,s.batch_id,
        SUM(t.JnU_Amount) AS paid_jnu,
        SUM(t.miscellaneous_amount) AS paid_misc,
        SUM(t.seminar_amount) AS paid_seminar,
        SUM(t.waiver) AS waiver,

    ');
    $this->db->from('students s');
    $this->db->join('transactions t', 't.student_id = s.std_id', 'left');
    $this->db->where('s.batch_id', $batch_id);
    $this->db->where_in('t.semester_id', array_column($semester_list, 'semester_id'));
    $this->db->group_by('s.std_id');
    $transactions = $this->db->get()->result();
    $data['transactions'] = $transactions;

    foreach ($transactions as $student) {
    $std_id = $student->std_id;
    foreach ($semester_list as $sem) {
        $paid = $this->db->select_sum('JnU_Amount', 'jnu')
            ->select_sum('miscellaneous_amount', 'misc')
            ->select_sum('Seminar_amount', 'seminar')
            ->select_sum('waiver', 'waiver')
            ->where('student_id', $std_id)
            ->where('semester_id', $sem->semester_id)
            ->get('transactions')->row();

        // Ensure NULL values are treated as 0
        $actual_paid = ($paid->jnu ?? 0) + ($paid->misc ?? 0) + ($paid->seminar ?? 0) + ($paid->waiver ?? 0);

        // Always calculate due as full expected amount minus paid (even if paid is 0)
        $expected = $sem->jnu_amount + $sem->miscellaneous_amount + $sem->seminar_amount;

        // Save due (full expected if no transaction)
        $semester_due_map[$std_id][$sem->semester_id] = max($expected - $actual_paid, 0);
    }
}
    
    $data['semester_due_map'] = isset($semester_due_map) ? $semester_due_map : [];

    $html = $this->load->view('transaction/pdf_report', $data, true);

    $this->load->library('pdf');
    $this->pdf->createPDF($html, 'transaction_report', true);
}

//Single report 



public function single_report()
{
    $data['content'] = 'transaction/single_report';

    if ($this->input->method() == 'post') {
        $std_id = $this->input->post('std_id');
        $semester_id = $this->input->post('semester_id');

        // Load models
        $this->load->model('Student_model');
        $this->load->model('Semester_model');
        $this->load->model('Transaction_model');

        // Get student and semester info
        $student = $this->Student_model->get_student_by_id($std_id);
        $semester = $this->Semester_model->get_semester_by_id($semester_id);

        if (!$student || !$semester) {
            $data['error'] = 'Student or Semester not found.';
            $this->load->view('admin/template', $data);
            return;
        }

        $batch_id = $student->batch_id;

        // Transactions up to selected semester
        $data['transactions'] = $this->Transaction_model->get_transactions_upto_semester($std_id, $semester_id);

        // Fetch all semesters up to selected semester of the same batch
        $data['all_semesters'] = $this->Semester_model->get_semesters_by_batch_up_to($batch_id, $semester_id);

        // For table heading
        $data['student'] = $student;
        $data['semester'] = $semester;
        $data['batch'] = $this->Batch_model->get_by_id($batch_id);
        
    }

    $this->load->view('admin/template', $data);
}




public function single_report_pdf()
{
    if ($this->input->method() == 'get') {
        $std_id = $this->input->get('std_id');
        $semester_id = $this->input->get('semester_id');

        // Load models
        $this->load->model('Student_model');
        $this->load->model('Semester_model');
        $this->load->model('Transaction_model');
        $this->load->model('Batch_model');


        // Get student and semester info
        $student = $this->Student_model->get_student_by_id($std_id);
        $semester = $this->Semester_model->get_semester_by_id($semester_id);

        if (!$student || !$semester) {
            $data['error'] = 'Student or Semester not found.';
            $this->load->view('admin/template', $data);
            return;
        }

        $batch_id = $student->batch_id;

        // Transactions up to selected semester
        $data['transactions'] = $this->Transaction_model->get_transactions_upto_semester($std_id, $semester_id);

        // Fetch all semesters up to selected semester of the same batch
        $data['all_semesters'] = $this->Semester_model->get_semesters_by_batch_up_to($batch_id, $semester_id);

        // For table heading
        $data['student'] = $student;
        $data['semester'] = $semester;
        $data['batch'] = $this->Batch_model->get_by_id($batch_id);
        
    }

    $html = $this->load->view('transaction/pdf_single_report', $data, true);
    // Create PDF
    $this->load->library('pdf');
    $this->pdf->createPDF($html, "{$std_id}_transaction_report", true);

}





public function date_report_form()
{
    $data['title'] = 'Date Wise Transaction Report';
    $data['content'] = 'transaction/date_report_form';
    $this->load->view('admin/template', $data);
}
public function date_report()
{
    $this->load->model('Transaction_model');
    $this->load->model('Student_model');
    $this->load->helper('custom'); 
    $start_date = $this->input->get('start_date');
    $end_date = $this->input->get('end_date');

    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;
    $data['transactions'] = [];
    $data['title'] = 'Transaction Report by Date';

    // If both dates are provided, fetch data and generate PDF
    if ($start_date && $end_date) {
        $data['transactions'] = $this->Transaction_model->get_by_date_range($start_date, $end_date);
        // Generate PDF automatically
        $html = $this->load->view('transaction/date_report', $data, true);

        require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("datewise_transaction_report.pdf", ["Attachment" => false]);
        return;
    }

    // If no dates provided, load the page normally
    $data['content'] = 'transaction/date_report';
    $this->load->view('admin/template', $data);
}





}
// end class
