<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class AdmitCard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_user_model');
        $this->load->model('Batch_model');
         $this->load->model('Student_model');
         $this->load->model('Course_model');
        $this->load->library('form_validation');
       $this->load->library(['upload', 'session']);
        $this->load->helper('url');
        $this->load->model('Enrollment_model');
    }

  public function form()
{
    $this->load->model('Batch_model');
    $this->load->model('Semester_model');

    $data['title'] = 'Admit Card';
    $data['batches'] = $this->Batch_model->get_all(); // optional
    $data['semesters'] = $this->Semester_model->get_all(); // optional
    $data['content'] = 'admitcard/admit_card_form';
    $this->load->view('admin/template', $data);
}

// Admit Card Genarate function
 public function generate_all()
{
    // Get data from POST or GET
    $batch_id   = $this->input->post('batch_id') ?? $this->input->get('batch_id');
    $semester_id = $this->input->post('semester_id') ?? $this->input->get('semester_id');
    $exam_year  = $this->input->post('exam_year') ?? $this->input->get('exam_year');
    $session = $this->input->post('session_id') ?? $this->input->get('session_id');
    $exam_type = $this->input->post('exam_type') ?? $this->input->get('exam_type');

    // Load models
    $this->load->model('Batch_model');
    $this->load->model('Course_model');
    $this->load->model('Student_model');

    // Fetch required data
    $students = $this->Student_model->get_by_batch($batch_id);
    $courses  = $this->Course_model->admit_card($batch_id, $semester_id,$exam_year);
    $batch    = $this->Batch_model->get_by_id($batch_id);
    $batch_name = str_replace(' ', '_', $batch->batch_name);
    

    // Check if data is found
    if (empty($students) || empty($courses)) {
        show_error("No students or courses found for this batch and semester.");
        return;
    }

    if($exam_type==0)
    {
        $exam_type="Mid-Term";
    }
    elseif($exam_type==1)
    {
         $exam_type="Final";
    }

    // Prepare data array with consistent keys
    $data = [
        'batch_id'    => $batch_id,
        'semester_id' => $semester_id,
        'exam_year'   => $exam_year,
        'exam_type'   => $exam_type,
        'students'    => $students,
        'courses'     => $courses,
        'batch'       => $batch,
        'session_id'  => $session,
        'batch_name' =>$batch_name
    ];

    // Load your view as string for PDF generation or normal rendering
    $html = $this->load->view('admitcard/admit_card_template', $data, true);

    // ... your PDF generation or output code here ...

    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
    $options = new \Dompdf\Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("admit_cards_{$batch_name}_{$exam_type}.pdf", ["Attachment" => false]);
}

 public function attendance_form()
{
    $this->load->model('Batch_model');
    $this->load->model('Semester_model');

    $data['title'] = 'Attendance Sheet';
    $data['batches'] = $this->Batch_model->get_all(); // optional
    $data['semesters'] = $this->Semester_model->get_all(); // optional

    $data['content'] = 'admitcard/attendance_form';
    $this->load->view('admin/template', $data);
}

public function attendance_sheet()
{
    // Get data from POST or GET
    $batch_id   = $this->input->post('batch_id') ?? $this->input->get('batch_id');
    $semester_id = $this->input->post('semester_id') ?? $this->input->get('semester_id');
    $exam_year  = $this->input->post('exam_year') ?? $this->input->get('exam_year');
    $session = $this->input->post('session_id') ?? $this->input->get('session_id');
    $exam_type = $this->input->post('exam_type') ?? $this->input->get('exam_type');
 
    // Load models
    $this->load->model('Batch_model');
    $this->load->model('Course_model');
    $this->load->model('Student_model');

    // Fetch required data
    $students = $this->Student_model->get_by_batch($batch_id);
    $courses  = $this->Course_model->admit_card($batch_id, $semester_id,$exam_year);
    $batch    = $this->Batch_model->get_by_id($batch_id);
    $batch_name = str_replace(' ', '_', $batch->batch_name);


    // Check if data is found
    if (empty($students) || empty($courses)) {
        show_error("No students or courses found for this batch and semester.");
        return;
    }
    if($exam_type==0)
    {
        $exam_type="Mid-Term";
    }
    elseif($exam_type==1)
    {
         $exam_type="Final";
    }
    // Prepare data array with consistent keys
    $data = [
        'batch_id'    => $batch_id,
        'semester_id' => $semester_id,
        'exam_year'   => $exam_year,
        'exam_type'   => $exam_type,
        'students'    => $students,
        'courses'     => $courses,
        'batch'       => $batch,
        'session_id'  => $session,
        'batch_name' => $batch_name 
    ];

    // Load your view as string for PDF generation or normal rendering
    $html = $this->load->view('admitcard/attendance_sheet', $data, true);

    // ... your PDF generation or output code here ...

    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
    $options = new \Dompdf\Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream("attendance_sheet_{$batch_name}_{$exam_type}.pdf", ["Attachment" => false]);
}

  public function seat_plan_form()
{
    $this->load->model('Batch_model');
    $this->load->model('Semester_model');

    $data['title'] = 'Seat Plan';
    $data['batches'] = $this->Batch_model->get_all(); // optional
    $data['semesters'] = $this->Semester_model->get_all(); // optional

    $data['content'] = 'admitcard/seat_plan_form';
    $this->load->view('admin/template', $data);
}

public function seat_plan()
{
    // Get data from POST or GET
    $batch_id   = $this->input->post('batch_id') ?? $this->input->get('batch_id');
    $semester_id = $this->input->post('semester_id') ?? $this->input->get('semester_id');
    $exam_year  = $this->input->post('exam_year') ?? $this->input->get('exam_year');
    $session = $this->input->post('session_id') ?? $this->input->get('session_id');
    $exam_type = $this->input->post('exam_type') ?? $this->input->get('exam_type');
 
    // Load models
    $this->load->model('Batch_model');
    $this->load->model('Course_model');
    $this->load->model('Student_model');

    // Fetch required data
    $students = $this->Student_model->get_by_batch($batch_id);
    $batch    = $this->Batch_model->get_by_id($batch_id);
    $batch_name = str_replace(' ', '_', $batch->batch_name);
    // Check if data is found
    if (empty($students)) {
        show_error("No students or courses found for this batch and semester.");
        return;
    }
    if($exam_type==0)
    {
        $exam_type="Mid-Term";
    }
    elseif($exam_type==1)
    {
         $exam_type="Final";
    }
    // Prepare data array with consistent keys
    $data = [
        'batch_id'    => $batch_id,
        'semester_id' => $semester_id,
        'exam_year'   => $exam_year,
        'exam_type'   => $exam_type,
        'students'    => $students,
        'batch'       => $batch,
        'session_id'  => $session,
        'batch_name' => $batch_name 
    ];

    // Load your view as string for PDF generation or normal rendering
    $html = $this->load->view('admitcard/seat_plan', $data, true);

    // ... your PDF generation or output code here ...

    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
    $options = new \Dompdf\Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream("seat_plan_{$batch_name}_{$exam_type}.pdf", ["Attachment" => false]);
}
    
    public function top_sheet_form()
{
    $this->load->model('Batch_model');
    $this->load->model('Semester_model');

    $data['title'] = 'Top Sheet';
    $data['batches'] = $this->Batch_model->get_all(); // optional
    $data['semesters'] = $this->Semester_model->get_all(); // optional

    $data['content'] = 'admitcard/top_sheet_form';
    $this->load->view('admin/template', $data);
}

    public function top_sheet()
{
    // Get data from POST or GET
    $batch_id   = $this->input->post('batch_id') ?? $this->input->get('batch_id');
    $semester_id = $this->input->post('semester_id') ?? $this->input->get('semester_id');
    $exam_year  = $this->input->post('exam_year') ?? $this->input->get('exam_year');
    $session = $this->input->post('session_id') ?? $this->input->get('session_id');
    $exam_type = $this->input->post('exam_type') ?? $this->input->get('exam_type');
 
    // Load models
    $this->load->model('Batch_model');
    $this->load->model('Course_model');
    $this->load->model('Student_model');

    // Fetch required data
    $students = $this->Student_model->get_by_batch($batch_id);
    $courses  = $this->Course_model->admit_card($batch_id, $semester_id,$exam_year);
    $batch    = $this->Batch_model->get_by_id($batch_id);
    $batch_name = str_replace(' ', '_', $batch->batch_name);
    // Check if data is found
    if (empty($students) || empty($courses)) {
        show_error("No students or courses found for this batch and semester.");
        return;
    }
    if($exam_type==0)
    {
        $exam_type="Mid-Term";
    }
    elseif($exam_type==1)
    {
         $exam_type="Final";
    }
    // Prepare data array with consistent keys
    $data = [
        'batch_id'    => $batch_id,
        'semester_id' => $semester_id,
        'exam_year'   => $exam_year,
        'exam_type'   => $exam_type,
        'students'    => $students,
        'courses'     => $courses,
        'batch'       => $batch,
        'session_id'  => $session,
        'batch_name' => $batch_name,
    ];

    // Load your view as string for PDF generation or normal rendering
    $html = $this->load->view('admitcard/top_sheet', $data, true);

    // ... your PDF generation or output code here ...

    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
    $options = new \Dompdf\Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream("top_sheet_{$batch_name}_{$exam_type}.pdf", ["Attachment" => false]);
}

public function retake_form()
{
    $this->load->model('Retake_List_model');
    $this->load->model('Course_Bank_model');

    $data['title'] = 'Retake Form';
    $data['list'] = $this->Retake_List_model->get_all(); // optional

    $data['content'] = 'retake/retake_form';
    $this->load->view('admin/template', $data);
}

    public function retake_sheet()
{
    // Get data from POST or GET
    
    $exam_year  = $this->input->post('exam_year') ?? $this->input->get('exam_year');
    $report_type = $this->input->post('report_type') ?? $this->input->get('report_type');
 
    // Load models

    $this->load->model('Retake_List_model');

    $courses  = $this->Retake_List_model->sheet($exam_year);

    // Check if data is found
    if ( empty($courses)) {
        show_error("No students or courses found for this batch and semester.");
        return;
    }
    
    // Prepare data array with consistent keys
    $data = [
        
        'exam_year'   => $exam_year,
        'courses'     => $courses,
        'report_type' => $report_type,
    ];
    if($report_type == 0) {
        // Load your view as string for PDF generation or normal rendering
        $html = $this->load->view('retake/retake_sheet', $data, true);
    }
    else if($report_type == 1) {
        // Load your view as string for PDF generation or normal rendering
        $html = $this->load->view('retake/retake_attendance', $data, true);
    }
    // ... your PDF generation or output code here ...

    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
    $options = new \Dompdf\Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->render();
    if($report_type == 0) {
        $dompdf->stream("retake_report_{$exam_year}.pdf", ["Attachment" => false]);
    }
    else if($report_type == 1) { 
        $dompdf->stream("retake_attendance_{$exam_year}.pdf", ["Attachment" => false]);
    }
   
}

    public function makeup_mid_form()
{
    $this->load->model('Batch_model');
    $this->load->model('Semester_model');

    $data['title'] = 'Makeup Mid Form';
    $data['batches'] = $this->Batch_model->get_all(); // optional
    $data['semesters'] = $this->Semester_model->get_all(); // optional

    $data['content'] = 'makeup-mid/makeup_mid_form';
    $this->load->view('admin/template', $data);
}

public function makeup_mid_sheet()
{
    // Get data from POST or GET
    $batch_id   = $this->input->post('batch_id') ?? $this->input->get('batch_id');
    $semester_id = $this->input->post('semester_id') ?? $this->input->get('semester_id');
    $exam_year  = $this->input->post('exam_year') ?? $this->input->get('exam_year');
    $session = $this->input->post('session_id') ?? $this->input->get('session_id');
    $report_type = $this->input->post('report_type') ?? $this->input->get('report_type');
 
    // Load models
    $this->load->model('Batch_model');
    $this->load->model('Course_model');
    $this->load->model('Student_model');

    // Fetch required data
    // $students = $this->Student_model->get_by_batch($batch_id);
    $courses  = $this->Course_model->admit_card($batch_id, $semester_id,$exam_year);
    $batch    = $this->Batch_model->get_by_id($batch_id);
    $batch_name = str_replace(' ', '_', $batch->batch_name);
    // Check if data is found
    if (empty($courses)) {
        show_error("No students or courses found for this batch and semester.");
        return;
    }
   
    // Prepare data array with consistent keys
    $data = [
        'batch_id'    => $batch_id,
        'semester_id' => $semester_id,
        'exam_year'   => $exam_year, 
        // 'students'    => $students,
        'courses'     => $courses,
        'batch'       => $batch,
        'session_id'  => $session,
        'batch_name' => $batch_name,
    ];

    
   
if($report_type == 0) {
        // Load your view as string for PDF generation or normal rendering
         $html = $this->load->view('makeup-mid/makeup_mid_sheet', $data, true);
    }
    else if($report_type == 1) {
        // Load your view as string for PDF generation or normal rendering
        $html = $this->load->view('makeup-mid/makeup_mid_attendance', $data, true);
    }
    // ... your PDF generation or output code here ...

    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
    $options = new \Dompdf\Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->render();
    if($report_type == 0) {
        $dompdf->stream("makeup_mid_report_{$batch_name}.pdf", ["Attachment" => false]);
    }
    else if($report_type == 1) { 
        $dompdf->stream("makeup_mid_attendance_{$batch_name}.pdf", ["Attachment" => false]);
    }
}

public function course_registration_form()
{
    $this->load->model('Batch_model');
    $this->load->model('Semester_model');
    $data['title'] = 'Course Registration Form';
    $data['batches'] = $this->Batch_model->get_all(); // optional
    $data['semesters'] = $this->Semester_model->get_all(); // optional
    $data['content'] = 'course_registration/course_registration_form';
    $this->load->view('admin/template', $data);

}


// Registration Report
public function registration_report()
{
    // Get data from POST or GET
    $batch_id    = $this->input->post('batch_id') ?? $this->input->get('batch_id');
    $semester_id = $this->input->post('semester_id') ?? $this->input->get('semester_id');
    $exam_year   = $this->input->post('exam_year') ?? $this->input->get('exam_year');
    $session     = $this->input->post('session_id') ?? $this->input->get('session_id');
    $exam_type   = $this->input->post('exam_type') ?? $this->input->get('exam_type');

    // Load models
    $this->load->model('Batch_model');
    $this->load->model('Course_model');
    $this->load->model('Student_model');

   
 // Fetch required data
    $students = $this->Student_model->get_by_batch($batch_id);
    $courses  = $this->Course_model->admit_card($batch_id, $semester_id,$exam_year);
    $batch    = $this->Batch_model->get_by_id($batch_id);
    $batch_name = str_replace(' ', '_', $batch->batch_name);
    if (empty($students) || empty($courses)) {
        show_error("No students or courses found for this batch and semester.");
        return;
    }

    // Format exam type
    if ($exam_type == 0) {
        $exam_type = "Mid-Term";
    } elseif ($exam_type == 1) {
        $exam_type = "Final";
    }

    // Data for view


    $data = [
        'batch_id'    => $batch_id,
        'semester_id' => $semester_id,
        'exam_year'   => $exam_year,
        'exam_type'   => $exam_type,
        'students'    => $students,
        'courses'     => $courses,
        'batch'       => $batch,
        'session_id'  => $session,
    ];

    // Load enrollment form view
    $this->load->view('course_registration/registration_report', $data);
}


public function Course_Registration() {
    // 1️⃣ Get URL parameters if needed
    $batch_id    = $this->input->get('batch_id');
    $session_id  = $this->input->get('session_id');
    $semester_id = $this->input->get('semester_id');
    $exam_year   = $this->input->get('exam_year');
    $exam_type   = $this->input->get('exam_type');

    // 2️⃣ Get form data
    $student_ids = $this->input->post('student_ids');
    $enrollments = $this->input->post('enrollments');

    $data = [];

    foreach ($student_ids as $std_id) {
        if (!empty($enrollments[$std_id])) {
            // Convert selected courses to JSON string
            $course_ids_json = json_encode(array_unique($enrollments[$std_id]));

            $data[] = [
                'batch_id'    => $batch_id,
                'session_id'  => $session_id,
                'semester_id' => $semester_id,
                'exam_year'   => $exam_year,
                'exam_type'   => $exam_type,
                'student_id'  => $std_id,
                'course_id'   => $course_ids_json,  // store JSON
                'created_at'  => date('Y-m-d H:i:s')
            ];
        }
    }

    // 3️⃣ Insert into DB (one row per student)
    if (!empty($data)) {
        $this->Enrollment_model->insert_batch($data);
        $this->session->set_flashdata('success', 'Enrollments saved successfully!');
    } else {
        $this->session->set_flashdata('error', 'No courses selected!');
    }

    // 4️⃣ Redirect back
    redirect('admitcard/registration_report?' . http_build_query($_GET));
}


} //End of Controller 
?>
