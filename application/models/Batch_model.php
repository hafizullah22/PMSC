<?php
class Batch_model extends CI_Model {

    public function get_all() {
        return $this->db->get('batches')->result();
    }

    public function insert($data) {
        return $this->db->insert('batches', $data);
    }

    public function get_by_id($batch_id) {
        return $this->db->get_where('batches', ['batch_id' => $batch_id])->row();
    }
  

    public function update($id, $data) {
        return $this->db->where('batch_id', $id)->update('batches', $data);
    }

    public function delete($id) {
        return $this->db->where('batch_id', $id)->delete('batches');
    }
    public function count_all()
{
    return $this->db->count_all('batches');
}

}
