<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enrollment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Enrollment_model');
        $this->load->library('session');
    }

    public function save() {
        // --- 1️⃣ Get URL query data ---
        $batch_id    = $this->input->get('batch_id');
        $session_id  = $this->input->get('session_id');
        $semester_id = $this->input->get('semester_id');
        $exam_year   = $this->input->get('exam_year');
        $exam_type   = $this->input->get('exam_type');

        $student_ids = $this->input->post('student_ids');
        $enrollments = $this->input->post('enrollments');

$data = [];

foreach ($student_ids as $std_id) {
    if (!empty($enrollments[$std_id])) {

        // Remove duplicates and convert all courses to JSON
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

// Insert batch (one row per student)
if (!empty($data)) {
    $this->Enrollment_model->insert_batch($data);
}



        // --- 4️⃣ Save into DB ---
        if (!empty($data)) {
            $this->Enrollment_model->insert_batch($data);
            $this->session->set_flashdata('success', 'Enrollments saved successfully!');
        } else {
            $this->session->set_flashdata('error', 'No courses selected!');
        }

        // Redirect back with same parameters
        redirect('admitcard/registration_report?' . http_build_query($_GET));
    }
}
