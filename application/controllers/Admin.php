<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_user_model');
        $this->load->model('Batch_model');
         $this->load->model('Student_model');
         $this->load->model('Course_model');
         $this->load->model('Course_Bank_model');
        $this->load->library('form_validation');
       $this->load->library(['upload', 'session']);
        $this->load->helper('url');
    }

   
    // Login form
    public function login() {
        $this->load->view('admin/login');
    }

    // Process login
    public function login_process() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $admin = $this->Admin_user_model->get_by_email($email);

        if ($admin && password_verify($password, $admin->password)) {
            $this->session->set_userdata('admin_id', $admin->id);
            $this->session->set_userdata('admin_name', $admin->name);
            redirect('admin/dashboard');
        } else {
            $data['error'] = 'Invalid login credentials';
            $this->load->view('admin/login', $data);
        }
    }

    // Dashboard
   public function dashboard()
{
    // Load necessary models
    $this->load->model(['Batch_model', 'Student_model', 'Transaction_model']);

    // Fetch data
    $data['total_batches'] = $this->Batch_model->count_all();
    $data['total_students'] = $this->Student_model->count_all();
    $data['total_transactions'] = $this->Transaction_model->count_all();
    
    $data['title'] = 'PMSC';
    $data['content'] = 'admin/dashboard';
    $this->load->view('admin/template', $data);
}


    // Logout
    public function logout() {
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    // === BATCH CRUD ===

    public function batches() {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');

    $data = [
        'title' => 'Batches',
        'batches' => $this->Batch_model->get_all(),
        'content' => 'batch/list'  // your batch list content view
    ];
    $this->load->view('admin/template', $data);
}

   // Add batch form + submit
public function add_batch() {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');

    if ($this->input->method() == 'post') {
        $data = [
            'batch_name' => $this->input->post('batch_name'),
            'session' => $this->input->post('session')
        ];
       
    
        if ($this->Batch_model->insert($data)) {
            $this->session->set_flashdata('success', 'Batch added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to add batch.');
        }
        redirect('admin/batches');
    } else {
        $data = [
            'title' => 'Add Batch',
            'content' => 'batch/add'
        ];
        
        $this->load->view('admin/template', $data);
    }
}

// Edit batch form + submit
public function edit_batch($id) {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');

    if ($this->input->method() == 'post') {
        $data = [
            'batch_name' => $this->input->post('batch_name'),
            'session' => $this->input->post('session')
        ];
        $this->Batch_model->update($id, $data);
        if($this->Batch_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Batch updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update batch.');
        }
         // Redirect to batches list
        redirect('admin/batches');
    } else {
        $batch = $this->Batch_model->get_by_id($id);
        $data = [
            'title' => 'Edit Batch',
            'batch' => $batch,
            'content' => 'batch/edit'
        ];
        $this->load->view('admin/template', $data);
    }
}

// Delete batch
public function delete_batch($id) {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');

    $this->Batch_model->delete($id);
    redirect('admin/batches');
}


// Show all students
    public function students() {
        $data['students'] = $this->Student_model->get_all();
        $data['batches'] = $this->Batch_model->get_all();
        $data['title'] = 'Student List';
        $batch_id = $this->input->get('batch_id');
         // Get batch name
        $this->db->where('batch_id', $batch_id);
        $query = $this->db->get('batches');
        $batch = $query->row();
        $data['batch_name'] = $batch ? $batch->batch_name : 'NA';
        
        $data['student_by_batch_id'] = $this->Student_model->get_by_batch($batch_id);
        $data['content'] = 'student/list';
        $this->load->view('admin/template', $data);
    }

    // Single insert form
    public function add_student() {
        if ($this->input->method() === 'post') {
            $data = [
                'std_id' => $this->input->post('std_id'),
                'name' => $this->input->post('name'),
                'batch_id' => $this->input->post('batch_id'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'image' => null
            ];

            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/students/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = time();
                $this->upload->initialize($config);
                if ($this->upload->do_upload('image')) {
                    $data['image'] = $this->upload->data('file_name');
                }
            }

            if($this->Student_model->insert($data)){
              $this->session->set_flashdata('success', 'Student added successfully.');
            redirect('admin/students');  
            }

            

            

        } else {
            $data['batches'] = $this->Batch_model->get_all();
            $data['title'] = 'Add Student';
            $data['content'] = 'student/add';
            $this->load->view('admin/template', $data);
        }
    }
    public function edit_student($id) {
    $data['student'] = $this->Student_model->get_by_id($id);

    if ($this->input->method() === 'post') {
        $data = [
            'std_id' => $this->input->post('std_id'),
            'name' => $this->input->post('name'),  
            'batch_id' => $this->input->post('batch_id'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email')
        ];

        $this->Student_model->update($id, $data);
        $this->session->set_flashdata('success', 'Student Updated Successfully.');

        // Get batch_id for redirection
        $batch_id = $this->input->post('batch_id');
        redirect("admin/students/student?batch_id={$batch_id}");
    } 
    else {
        $data['batches'] = $this->Batch_model->get_all();
        $data['title'] = 'Edit Student';
        $data['content'] = 'student/edit';
        $this->load->view('admin/template', $data);
    }
}

    public function delete_student($id) {
        $this->Student_model->delete($id);
        $this->session->set_flashdata('success', 'Student deleted successfully.');
        redirect('admin/students');
    }

    // Bulk CSV upload
    public function bulk_upload_students() {
    $data['batches'] = $this->Batch_model->get_all();
    $batch_id = $this->input->post('batch_id');

    if ($this->input->method() === 'post' && isset($_FILES['csv_file']) && is_uploaded_file($_FILES['csv_file']['tmp_name'])) {

        $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
        if ($file === false) {
            die('Failed to open uploaded CSV file.');
        }

        // Read header row
        $header = fgetcsv($file);
        if (!$header) {
            die('CSV file header not found or empty.');
        }

        // Optional: Validate header names here
        // e.g. check if $header matches ['std_id', 'name', 'phone', 'email']

        $students = [];
        while (($line = fgetcsv($file)) !== FALSE) {
            if (count($line) >= 4) {
                $students[] = [
                    'std_id' => trim($line[0]),
                    'name' => trim($line[1]),
                    'phone' => trim($line[2]),
                    'email' => trim($line[3]),
                    'batch_id' => $batch_id,
                ];
            }
        }
        fclose($file);

        if (!empty($students)) {
            $this->Student_model->insert_batch($students);
            $this->session->set_flashdata('success', 'Students uploaded successfully!');
        } else {
            $this->session->set_flashdata('error', 'No valid student data found in CSV.');
        }

        redirect('admin/students');

    } else {
        $data['title'] = 'Bulk Upload Students';
        $data['content'] = 'student/bulk_upload';
        $this->load->view('admin/template', $data);
    }
}



    // Bulk image upload form
    public function image_upload_form() {
        $data['batches'] = $this->Batch_model->get_all();
        $data['title'] = 'Bulk Upload Images';
        $data['content'] = 'student/image_upload';
        $this->load->view('admin/template', $data);
    }

    // Handle bulk image upload by batch
    public function upload_student_images() {
        $batch_id = $this->input->post('batch_id');
        $folder_name = 'batch-' . $batch_id;
        $upload_path = './uploads/students/' . $folder_name . '/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['overwrite'] = TRUE;

        $files = $_FILES['images'];
        $count = count($files['name']);

        for ($i = 0; $i < $count; $i++) {
            $_FILES['single']['name']     = $files['name'][$i];
            $_FILES['single']['type']     = $files['type'][$i];
            $_FILES['single']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['single']['error']    = $files['error'][$i];
            $_FILES['single']['size']     = $files['size'][$i];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('single')) {
                $file_name = $this->upload->data('file_name');
                $std_id = pathinfo($file_name, PATHINFO_FILENAME);
                $this->db->where('std_id', $std_id);
                $this->db->where('batch_id', $batch_id);
                $this->db->update('students', ['image' => $folder_name . '/' . $file_name]);
            }
        }

        $this->session->set_flashdata('success', 'Images uploaded successfully.');
        redirect('admin/students');
    }

    public function semesters() {
    $this->load->model('Semester_model');
    $this->load->model('Batch_model');

    $data['semesters'] = $this->Semester_model->get_all();
    $data['batches'] = $this->Batch_model->get_all();

    $batch_id = $this->input->get('batch_id');
    $data['semester_by_batch_id'] = $this->Semester_model->get_semesters_by_batch($batch_id);
     
    // Get batch name
    $this->db->where('batch_id', $batch_id);
    $query = $this->db->get('batches');
    $batch = $query->row();
    $data['batch_name'] = $batch ? $batch->batch_name : 'NA';

    $data['title'] = 'Semesters';
    $data['content'] = 'semester/list';
    $this->load->view('admin/template', $data);
}

public function add_semester() {
    $this->load->model('Batch_model');
    if ($this->input->method() == 'post') {
        $data = [
            'semester_id' => $this->input->post('semester_id'),
            'batch_id' => $this->input->post('batch_id'),
            'JnU_Amount' => $this->input->post('JnU_Amount'),
            'Miscellaneous_amount' => $this->input->post('miscellaneous_amount'),
            'Seminar_amount' => $this->input->post('Seminar_amount'),
        ];
        $this->load->model('Semester_model');
        
        if($this->Semester_model->insert($data)) {
            $this->session->set_flashdata('success', 'Semester added successfully.');
        }
        redirect('admin/semesters');
    } else {
        $data['batches'] = $this->Batch_model->get_all();
        $data['title'] = 'Add Semester';
        $data['content'] = 'semester/add';
        $this->load->view('admin/template', $data);
    }
}

public function edit_semester($id) {
    $this->load->model('Batch_model');
    $this->load->model('Semester_model');
    if ($this->input->method() == 'post') {
        $data = [
            'semester_id' => $this->input->post('semester_id'),
            'batch_id' => $this->input->post('batch_id'),
            'jnu_amount' => $this->input->post('jnu_amount'),
            'miscellaneous_amount' => $this->input->post('miscellaneous_amount'),
            'seminar_amount' => $this->input->post('seminar_amount'),
        ];
        $this->Semester_model->update($id, $data);
        $this->session->set_flashdata('success', 'Semester Updated Successfully.');
        // redirect('admin/semesters');
         $batch_id = $this->input->post('batch_id');
        redirect("admin/semesters/semesters?batch_id={$batch_id}");
    } else {
        $data['semester'] = $this->Semester_model->get_by_id($id);
        $data['batches'] = $this->Batch_model->get_all();
        $data['title'] = 'Edit Semester';
        $data['content'] = 'semester/edit';
        $this->load->view('admin/template', $data);
    }
}

public function delete_semester($id) {
    $this->load->model('Semester_model');
    $this->Semester_model->delete($id);
    redirect('admin/semesters');
}


  public function courses() {
    $this->load->model('Course_model');
    $this->load->model('Batch_model');
    $data['courses'] = $this->Course_model->get_all();
    $data['batches'] = $this->Batch_model->get_all();
    
    $batch_id = $this->input->get('batch_id');
    $data['course_by_batch_id'] = $this->Course_model->get_all_by_batch_id($batch_id);
    // Get batch name
    $this->db->where('batch_id', $batch_id);
    $query = $this->db->get('batches');
    $batch = $query->row();
    $data['batch_name'] = $batch ? $batch->batch_name : 'NA';

    $data['title'] = 'Courses';
    $data['content'] = 'course/list';
    $this->load->view('admin/template', $data);
}

public function add_course() {
    $this->load->model('Batch_model');
    if ($this->input->method() == 'post') {
        $data = [
            'batch_id' => $this->input->post('batch_id'),
            'semester_id' => $this->input->post('semester_id'),
            'exam_year' => $this->input->post('exam_year'),
            'course_name' => $this->input->post('course_name')
        ];
        $this->load->model('Course_model');
        // $this->Course_model->insert($data);
        
        // Redirect to courses list
        if($this->Course_model->insert($data)) {
            $this->session->set_flashdata('success', 'Course added successfully.');
            redirect('admin/courses');
        }
    } else {
        $data['batches'] = $this->Batch_model->get_all();
        $data['title'] = 'Add Course';
        $data['content'] = 'course/add';
        $this->load->view('admin/template', $data);
    }
}

public function edit_course($id) {
    $this->load->model('Batch_model');
    $this->load->model('Course_model');

    if ($this->input->method() == 'post') {
        $data = [
            'batch_id' => $this->input->post('batch_id'),
            'semester_id' => $this->input->post('semester_id'),
            'exam_year' => $this->input->post('exam_year'),
            'course_name' => $this->input->post('course_name'),
            'mid_exam_date'=>$this->input->post('mid_exam_date'),
            'final_exam_date'=>$this->input->post('final_exam_date')
        ];
        $this->Course_model->update($id, $data);
        $batch_id = $this->input->post('batch_id');
        $this->session->set_flashdata('success', 'Course Updated Successfully.');
        redirect("admin/courses/courses?batch_id={$batch_id}");
        
    } 
    else {
        $data['course'] = $this->Course_model->get_by_id($id);
        $data['batches'] = $this->Batch_model->get_all();
        $data['title'] = 'Edit Course';
        $data['content'] = 'course/edit';
        $this->load->view('admin/template', $data);
    }
}

public function delete_course($id) {
    $this->load->model('Course_model');
    $this->Course_model->delete($id);
    redirect('admin/courses');
}


// // Course Bank For Retake
public function course_bank() {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');

    $data = [
        'title' => 'Course Bank',
        'courses' => $this->Course_Bank_model->get_all(),
        'content' => 'course_bank/list'
    ];
    $this->load->view('admin/template', $data);
}
 


   // Add batch form + submit
public function add_course_bank() {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');

    if ($this->input->method() == 'post') {
        $data = [
            'course_name' => $this->input->post('course_name'),
        ];

        if ($this->Course_Bank_model->insert($data)) {
            $this->session->set_flashdata('success', 'Course added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to add course.');
        }
        redirect('admin/course_bank');
    } else {
        $data = [
            'title' => 'Add Course',
            'content' => 'course_bank/add'
        ];
        
        $this->load->view('admin/template', $data);
    }
}

// Edit batch form + submit
public function edit_course_bank($id) {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');

    if ($this->input->method() == 'post') {
        $data = [
            'course_name' => $this->input->post('course_name'),
            'status' => $this->input->post('status') 
        ];
        $this->Course_Bank_model->update($id, $data);
        if($this->Course_Bank_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Course info Updated Successfully in Course Bank.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update course info.');
        }
         // Redirect to courses list
        redirect('admin/course_bank');
    } else {
        $course = $this->Course_Bank_model->get_by_id($id);
        $data = [
            'title' => 'Edit Course',
            'course' => $course,
            'content' => 'course_bank/edit'
        ];
        $this->load->view('admin/template', $data);
    }
}

// Delete course Bank
public function delete_course_bank($id) {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');

    $this->Course_Bank_model->delete($id);
    redirect('admin/course_bank');
}

   // Add batch form + submit
public function retake_entry() {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');
    $this->load->model('Course_Bank_model');
    $this->load->model('Retake_list_model');
    $courses = $this->Course_Bank_model->get_all_active();
    if ($this->input->method() == 'post') {
        $data = [
            'course_id' => $this->input->post('course_id'),
            'student_list' => $this->input->post('student_list'),
            'exam_year' => $this->input->post('exam_year')
        ];

        if ($this->Retake_list_model->insert($data)) {
            $this->session->set_flashdata('success', 'Student added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to add student.');
        }
        redirect('admin/retake_list');
    } else {
        $data = [
            'title' => 'Add  Retake Student',
            'content' => 'retake/add',
            'courses' => $courses
        ];

        $this->load->view('admin/template', $data);
    }
}
public function retake_list() {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');
   $this->load->model('Retake_list_model');
    $data = [
        'title' => 'Retake List',
        'content' => 'retake/list',
        'retakes' => $this->Retake_list_model->get_list()
    ];
    $this->load->view('admin/template', $data);
}

public function edit_retake($id) {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');
    $this->load->model('Retake_list_model');
    $retake = $this->Retake_list_model->get_list_id($id);

    if ($this->input->method() == 'post') {
        $data = [
            'course_id' => $this->input->post('course_id'),
            'student_list' => $this->input->post('student_list'),
            'exam_year' => $this->input->post('exam_year')
        ];

        if ($this->Retake_list_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Retake updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update retake.');
        }
        redirect('admin/retake_list');
    } else {
        $data = [
            'title' => 'Edit Retake',
            'content' => 'retake/edit',
        
            'retake' => $retake
        ];
        $this->load->view('admin/template', $data);
    }
}

public function delete_retake($id) {
    if (!$this->session->userdata('admin_id')) redirect('admin/login');
$this->load->model('Retake_list_model');
    $retake = $this->Retake_list_model->get_by_id($id);
    $this->Retake_list_model->delete($id);
    redirect('admin/retake_list');
}



  public function makeup_mid() {
    $this->load->model('Course_model');
    $this->load->model('Batch_model');
    $data['courses'] = $this->Course_model->get_all();
    $data['batches'] = $this->Batch_model->get_all();
    
    $batch_id = $this->input->get('batch_id');
    $data['course_by_batch_id'] = $this->Course_model->get_all_by_batch_id($batch_id);
    // Get batch name
    $this->db->where('batch_id', $batch_id);
    $query = $this->db->get('batches');
    $batch = $query->row();
    $data['batch_name'] = $batch ? $batch->batch_name : 'NA';

    $data['title'] = 'Makeup Mid Exam';
    $data['content'] = 'makeup-mid/list';
    $this->load->view('admin/template', $data);
}


public function set_makeup_mid($id) {
    $this->load->model('Batch_model');
    $this->load->model('Course_model');

    if ($this->input->method() == 'post') {
        $data = [
            'batch_id' => $this->input->post('batch_id'),
            'semester_id' => $this->input->post('semester_id'),
            'exam_year' => $this->input->post('exam_year'),
            'course_name' => $this->input->post('course_name'),
            'mid_student_list'=>$this->input->post('mid_student_list')
        ];
        $this->Course_model->update($id, $data);
        $batch_id = $this->input->post('batch_id');
        $this->session->set_flashdata('success', 'Course Updated Successfully.');
        redirect("admin/makeup_mid?batch_id={$batch_id}");
        
    } 
    else {
        $data['course'] = $this->Course_model->get_by_id($id);
        $data['batches'] = $this->Batch_model->get_all();
        $data['title'] = 'Edit Course';
        $data['content'] = 'makeup-mid/edit';
        $this->load->view('admin/template', $data);
    }
}

}