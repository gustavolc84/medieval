<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_types_model extends CI_Model
{

    public function __construct() {
        parent::__construct();

    }

    public function addCategory($data) {
        if ($this->db->insert('payment_types', $data)) {
            return true;
        }
        return false;
    }

    public function add_categories($data = array()) {
        if ($this->db->insert_batch('payment_types', $data)) {
            return true;
        }
        return false;
    }

    public function updateCategory($id, $data = NULL) {
        if ($this->db->update('payment_types', $data, array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function deleteCategory($id) {
        if ($this->db->delete('payment_types', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

}
