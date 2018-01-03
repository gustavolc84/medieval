<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Deliveries_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    public function getAllDeliveries() {
        try{
            $date = date('Y-m-d');        
            $this->db->select('deliveries.*,employees.first_name,customers.name')            
            ->join('employees' , 'deliveries.employee_id = employees.id' , 'left')
            ->join('customers' , 'deliveries.customer_id = customers.id')
            ->join('sales'     , 'deliveries.sale_id = sales.id')
            ->where('deliveries.created = ',$date);

            $q = $this->db->get('deliveries'); 
            if($q->num_rows() > 0) {                
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return [];
        }catch(Exception $e){
            echo 'Error: ' . $e->getMessage(); die;
        }
    }

    public function getAllToday() {
        $q = $this->db->get('employees');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function addDelivery($data) {
        if ($this->db->insert('deliveries', $data)) {
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

    public function update($data){
        try{
            $this->db->where('id', $data['id']);
            if(isset($data['status'])){
                $this->db->set('status', $data['status']);    
            }else{
                $this->db->set('employee_id', $data['employee_id']);
            }
            
            //se o motoqueiro voltou a loja, atualiza data e hora
            if(isset($data['dt_hr_exit'])){
                $this->db->set('dt_hr_exit', $data['dt_hr_exit']);
            }elseif(isset($data['dt_hr_return'])){
                $this->db->set('dt_hr_return', $data['dt_hr_return']);
            }            
            $this->db->update('deliveries');
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}
