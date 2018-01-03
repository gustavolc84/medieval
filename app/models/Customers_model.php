<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_model extends CI_Model
{
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getCustomerByID($id) 
	{
		$q = $this->db->get_where('customers', array('id' => $id), 1); 
		if( $q->num_rows() > 0 ) {
			return $q->row();
		} 
		return FALSE;
	}
	
	public function addCustomer($data = array())
	{
		if($this->db->insert('customers', $data)) {
			return $this->db->insert_id();
		}
		return false;
	}
	
	public function updateCustomer($id, $data = array())
	{
		if($this->db->update('customers', $data, array('id' => $id))) {
			return true;
		}
		return false;
	}
	
	public function deleteCustomer($id) 
	{
		if($this->db->delete('customers', array('id' => $id))) {
			return true;
		}
		return FALSE;
	}

	public function getAllCombo(){
		$q = $this->db->select('id,name')
					  ->get('customers');

        if ($q->num_rows() > 0) {
        	$data[0] = 'Selecione o Cliente';
            foreach (($q->result()) as $row) {
                $data[$row->id] = $row->name;
            }
            return $data;
        }
        return [0 => 'Sem Registros'];
	}
}
