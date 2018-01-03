<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends MY_Controller
{

    function __construct() {
        parent::__construct();

        if (! $this->loggedIn) {
            redirect('login');
        }

        $this->load->model('employees_model');        
        $this->load->library('form_validation');
    }

    function index() {        
        $this->data['dados'] = $this->employees_model->getAllEmployees();
        $this->data['page_title'] = lang('employees');
        $bc = array(array('link' => '#', 'page' => lang('employees')));
        $meta = array('page_title' => lang('employees'), 'bc' => $bc);
        $this->page_construct('employees/index', $this->data, $meta);
    }

    function add(){

        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }

        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $this->form_validation->set_rules('first_name', lang("product_code"), 'trim|max_length[40]|required');
            $this->form_validation->set_rules('last_name', lang("product_name"), 'trim|max_length[40]|required');
            $this->form_validation->set_rules('type_employee', lang("category"), 'required');            

            if ($this->form_validation->run() == true) {
                //guarda o array com os dados do formulario
                $data = $this->input->post();
                unset($data['add_employees']);
                if($this->employees_model->addEmployees($data)) {
                    $this->session->set_flashdata('message', lang("employee_added"));
                    redirect('employees/index');
                }else{
                    //mensagem de erro no insert
                    $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));        
                }
            }
        }
         
        $this->data['page_title'] = lang('add_employees'); 
        $this->data['status']     = ['Inativo','Ativo'];       
        $this->data['tipos_func'] = [
                            'default'    => 'Selecione',
                            'atendente'  => 'Atendente',
                            'balconista' => 'Balconista',
                            'cozinheiro' => 'Cozinheiro',
                            'motoqueiro' => 'Motoqueiro',
                            'caixa'      => 'Caixa',
                    ];
        $bc = array(array('link' => site_url('employees'), 'page' => lang('employees')), array('link' => '#', 'page' => lang('add_employees')));
        $meta = array('page_title' => lang('add_employees'), 'bc' => $bc);
        $this->page_construct('employees/add', $this->data, $meta);
    }
}
