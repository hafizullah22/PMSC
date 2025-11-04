
<?php
class Enrollment_model extends CI_Model {
    protected $table = 'enrollments';

    public function insert_batch($data) {
        if (!empty($data)) {
            $this->db->insert_batch($this->table, $data);
        }
    }
}
