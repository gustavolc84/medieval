<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Deliveries extends MY_Controller
{
    function __construct() {
        parent::__construct();

        if (! $this->loggedIn) {
            redirect('login');
        }

        $this->load->model('deliveries_model');
        $this->load->model('employees_model');
        $this->load->model('customers_model');
        $this->load->library('form_validation');
    }

    function index() {          
        $this->data['dados']  = $this->deliveries_model->getAllDeliveries();
        $this->data['status'] = $this->getStatus();
        $this->data['employees']  = $this->employees_model->getAllEmployeesCombo();
        $this->data['page_title'] = lang('deliveries');
        $bc = array(array('link' => '#', 'page' => lang('deliveries')));
        $meta = array('page_title' => lang('deliveries'), 'bc' => $bc);
        $this->page_construct('deliveries/index', $this->data, $meta);
    }

    function atualiza(){  
        $param['id'] = $this->input->post('id');

        if($this->input->post('type') == 'status'){
            $param['status'] = $this->input->post('status');
        }else{
            $param['employee_id'] = $this->input->post('employee');
        }        
        
        //atualiza as horas dos estados sair e retorno
        if($this->input->post('status') == '2'){
            $param['dt_hr_exit'] = date('Y-m-d H:i:s');
        }elseif($this->input->post('status') == '3'){
            $param['dt_hr_return'] = date('Y-m-d H:i:s');
        }

        if($this->deliveries_model->update($param)){
            $this->session->set_flashdata('message', lang('delivery_updated'));
            echo json_encode(['sucesso' => true]);    
        }else{
            $this->session->set_flashdata('error', lang('delivery_error'));
           echo json_encode(['sucesso' => false]);
        }
    }

    function add(){
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }

        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $this->form_validation->set_rules('sale_id', lang("sale"), 'trim|required');
            $this->form_validation->set_rules('employee_id', lang("employees"), 'required');
            $this->form_validation->set_rules('customer_id', lang("customers"), 'required');
            $this->form_validation->set_rules('status', lang("status"), 'required');            

            if ($this->form_validation->run() == true) {                
                //guarda o array com os dados do formulario
                $data = $this->input->post();
                
                //se o status da entrega for igual a "saiu" registra a hora da saida
                if($this->input->post('status')){
                    $data['dt_hr_exit'] = date('Y-m-d H:i:s');
                }

                // se o campo troco estiver preenchido
                if(!empty($this->input->post('change_money'))){
                    $data['change_money'] = str_replace(['.',','] , ['','.'] , $this->input->post('change_money'));
                }

                //limpa o indice
                unset($data['add_delivery']);

                if($this->deliveries_model->addDelivery($data)) {
                    $this->session->set_flashdata('message', lang("delivery_added"));
                    redirect('deliveries/index');
                }else{
                    //mensagem de erro no insert
                    $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));        
                }
            }
        }
         
        $this->data['page_title'] = lang('add_delivery'); 

        //cria valores para o formulario add                
        $this->data['status']     = $this->getStatus();
        $this->data['customers']  = (array) $this->customers_model->getAllCombo();
        $this->data['employees']  = (array) $this->employees_model->getAllEmployeesCombo();
        
        $bc = array(array('link' => site_url('deliveries'), 'page' => lang('deliveries')), array('link' => '#', 'page' => lang('add_delivery')));
        $meta = array('page_title' => lang('add_delivery'), 'bc' => $bc);
        $this->page_construct('deliveries/add', $this->data, $meta);
    }

    private function getStatus(){
        return[
            0 => 'Selecione o Status',
            1 => 'Aguardando',
            2 => 'Saiu',
            3 => 'Retornou'
        ];
    }
}
