<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employees_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    public function getAllEmployees() {
        $q = $this->db->get('employees');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function addEmployees($data) {
        if ($this->db->insert('employees', $data)) {
            return true;
        }
        return false;
    }

    public function deleteEmployee($id) {
        /*
        if ($this->db->delete('products', array('id' => $id))) {
            return true;
        }
        return FALSE;
        */
    }

    public function getAllEmployeesCombo() {
        $q = $this->db->select('id,first_name')
                      ->get_where('employees', [
                                            'type_employee' => 'motoqueiro', 
                                            'status'        => 1]);
        if ($q->num_rows() > 0) {
            $data[0] = 'Selecione o Motoboy';
            foreach (($q->result()) as $row) {
                $data[$row->id] = $row->first_name;
            }
            return $data;
        }
        return [0 => 'Sem Registros'];
    }
}
