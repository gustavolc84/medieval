<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model
{
	
	public function __construct() {
		parent::__construct();
	}
	
	public function updateSetting($data = array()) {
		
		if($this->db->update('settings', $data, array('setting_id' => 1))) {
			return true;
		}
		return false;
	}

	public function updateSlides($data){
		if(isset($data['id']) and $data['id'] != ''){			
			if($this->db->update('slides', $data , ['id' => $data['id']])) {
				return true;
			}
		}else{			
			if($this->db->insert('slides',$data)){
				return true;
			}
		}
		return false;
	}

	public function getAllSlides(){		
		$q = $this->db->get('slides');
		if($q->num_rows() > 0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return [];
	}

	public function existsSlidesName($name){		
		$this->db->where('name',$name);
		$q = $this->db->get('slides');
		if($q->num_rows() > 0){
			return true; 
		}
		return false;
	}

	public function getSlidesId($id){		
		$this->db->where('id',$id);
		$q = $this->db->get('slides');
		if($q->num_rows() > 0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
		}
		return [];
	}
}
