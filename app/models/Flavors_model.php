<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flavors_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    public function getAllCombo() {
        $q = $this->db->select('id,name')->get('flavors');                      
        if ($q->num_rows() > 0) {
            $data[0] = 'Selecione o sabor';
            foreach (($q->result()) as $row) {
                $data[$row->id] = $row->name;
            }
            return $data;
        }
        return [0 => 'Sem Registros'];
    }

    public function getAll(){
        $q = $this->db->select('id,name')->get('flavors');                      
        if ($q->num_rows() > 0) {            
            foreach (($q->result()) as $row) {
                $data[$row->id] = $row->name;
            }
            return $data;
        }
        return [];
    }
}
