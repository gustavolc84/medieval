<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_types extends MY_Controller
{

    function __construct() {
        parent::__construct();


        if (!$this->loggedIn) {
            redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('payment_types_model');
    }

    function index() {

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['categories'] = $this->site->getAllCategories();
        $this->data['page_title'] = 'Formas de Pagamento';
        $bc = array(array('link' => '#', 'page' => 'Formas de Pagamento'));
        $meta = array('page_title' => 'Formas de Pagamento', 'bc' => $bc);
        $this->page_construct('payment_types/index', $this->data, $meta);

    }

    function get_payment_types() {

        $this->load->library('datatables');
        $this->datatables->select("id, icon, name, tax, fix_tax,");
        $this->datatables->from('payment_types');
        $this->datatables->add_column("Actions", "<div class='text-center'><div class='btn-group'><a href='" . site_url('payment_types/edit/$1') . "' title='Editar' class='tip btn btn-warning btn-xs'><i class='fa fa-edit'></i></a> <a href='" . site_url('payment_types/delete/$1') . "' onClick=\"return confirm('" . lang('alert_x_category') . "')\" title='Excluir' class='tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></div></div>", "id, icon, name, tax, fix_tax");
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();

    }

    function add() {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }

        $this->form_validation->set_rules('name', lang('category_name'), 'required');

        if ($this->form_validation->run() == true) {
            $data = array('icon' => $this->input->post('icon'), 'name' => $this->input->post('name'), 'tax' => $this->input->post('tax'), 'fix_tax' => $this->input->post('fix_tax'), 'reorder' => $this->input->post('reorder'));

        }

        if ($this->form_validation->run() == true && $this->payment_types_model->addCategory($data)) {

            $this->session->set_flashdata('message', lang('category_added'));
            redirect("payment_types");

        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = 'Adicionar Forma de Pagamento';
            $bc = array(array('link' => site_url('categories'), 'page' => lang('categories')), array('link' => '#', 'page' => 'Adicionar Forma de Pagamento'));
            $meta = array('page_title' => 'Adicionar Forma de Pagamento', 'bc' => $bc);
            $this->page_construct('payment_types/add', $this->data, $meta);
        }
    }

    function edit($id = NULL) {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $this->form_validation->set_rules('name', lang('category_name'), 'required');

        if ($this->form_validation->run() == true) {
            $data = array('icon' => $this->input->post('icon'), 'name' => $this->input->post('name'), 'tax' => $this->input->post('tax'), 'fix_tax' => $this->input->post('fix_tax'), 'reorder' => $this->input->post('reorder'));

        }

        if ($this->form_validation->run() == true && $this->payment_types_model->updateCategory($id, $data)) {

            $this->session->set_flashdata('message', lang('category_updated'));
            redirect("payment_types");

        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['category'] = $this->site->getPaymentsByID($id);
            $this->data['page_title'] = lang('new_category');
            $bc = array(array('link' => site_url('categories'), 'page' => lang('categories')), array('link' => '#', 'page' => lang('edit_category')));
            $meta = array('page_title' => lang('edit_category'), 'bc' => $bc);
            $this->page_construct('payment_types/edit', $this->data, $meta);

        }
    }

    function delete($id = NULL) {
        if(DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->payment_types_model->deleteCategory($id)) {
            $this->session->set_flashdata('message', lang("category_deleted"));
            redirect('payment_types');
        }
    }

    function import() {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            if (DEMO) {
                $this->session->set_flashdata('warning', lang("disabled_in_demo"));
                redirect('pos');
            }

            if (isset($_FILES["userfile"])) {

                $this->load->library('upload');

                $config['upload_path'] = 'uploads/';
                $config['allowed_types'] = 'csv';
                $config['max_size'] = '500';
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("categories/import");
                }


                $csv = $this->upload->file_name;

                $arrResult = array();
                $handle = fopen("uploads/" . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                array_shift($arrResult);

                $keys = array('code', 'name');

                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }

                if (sizeof($final) > 1001) {
                    $this->session->set_flashdata('error', lang("more_than_allowed"));
                    redirect("categories/import");
                }

                foreach ($final as $csv_pr) {
                    if($this->site->getCategoryByCode($csv_pr['code'])) {
                        $this->session->set_flashdata('error', lang("check_category") . " (" . $csv_pr['code'] . "). " . lang("category_already_exist"));
                        redirect("categories/import");
                    }
                    $data[] = array('code' => $csv_pr['code'], 'name' => $csv_pr['name']);
                }
            }

        }

        if ($this->form_validation->run() == true && $this->payment_types_model->add_categories($data)) {

            $this->session->set_flashdata('message', lang("categories_added"));
            redirect('payment_types');

        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('import_categories');
            $bc = array(array('link' => site_url('products'), 'page' => lang('products')), array('link' => site_url('categories'), 'page' => lang('categories')), array('link' => '#', 'page' => lang('import_categories')));
            $meta = array('page_title' => lang('import_categories'), 'bc' => $bc);
            $this->page_construct('categories/import', $this->data, $meta);

        }
    }

}
