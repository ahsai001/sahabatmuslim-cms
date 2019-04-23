<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_user extends ADMIN_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT+7');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        
        $this->load->config('salim_config');
        $this->load->module('layout');
        $this->load->library('lib_gump');
        $this->load->library('lib_user');
        $this->load->helper('datatables_user');
    }
    
    public function index()
    {
        $data['header']          = $this->layout->header();
        $data['sidebar']         = $this->layout->sidebar();
        $data['path_sbadmin2']   = $this->config->item('sbadmin2');
        $data['path_app']        = $this->config->item('app');
        $data['path_sweetalert2'] = $this->config->item('sweetalert2');
        $data['head_title']      = $this->config->item('head_title');
        
        // link insert & refresh user
        $data['link_user_refresh'] = $this->config->item('user_refresh');
        $data['link_user_create']  = $this->config->item('user_create');
        $data['link_user_update']  = $this->config->item('user_update');
        
        // modal user
        $data['view_modal_user'] = $this->load->view('view_modal_user', NULL, TRUE);
        
        $this->load->view('view_user', $data);
    }
    
    function datatable()
    {
        
        $this->load->database();
        $this->load->library('Datatables');
        $this->datatables->select('id,username,level')->unset_column('id')->add_column('Actions', get_button_actions('$1'), 'id')->from('user');
        echo $this->datatables->generate();
    }
    
    function create()
    {
        
        /*
        |--------------------------------------------------------------------------
        | Detect Ajax
        |--------------------------------------------------------------------------
        */
        
        if (!$this->input->is_ajax_request()) {
            
            exit('No direct script access allowed');
        }
        
        try {
            
            $validation_rules = array(
                'username' => 'required',
                'password' => 'required',
                'level' => 'required'
            );
            
            $filter_rules = array(
                'username' => 'trim|sanitize_string',
                'password' => 'trim|sanitize_string',
                'level' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);
            
            /*
            |--------------------------------------------------------------------------
            | Set data user
            |--------------------------------------------------------------------------
            */
            
            date_default_timezone_set("Asia/Jakarta");
            $this->lib_user->setUsername($this->input->post('username'));
            $this->lib_user->setPassword($this->encrypt->encode($this->input->post('password')));
            $this->lib_user->setLevel($this->input->post('level'));
            $this->lib_user->setCreatedAt(date("Y-m-d H:i:s"));
            $this->lib_user->setUpdatedAt(date("Y-m-d H:i:s"));
            
            /*
            |--------------------------------------------------------------------------
            | save data user
            |--------------------------------------------------------------------------
            */
            
            $this->lib_user->checkPrivilege('admin');
            $this->lib_user->beforeStore();
            $this->lib_user->store();
            
            $result = array(
                'status' => TRUE,
                'message' => "Save User"
            );
            
        }
        catch (Exception $e) {
            
            $result = array(
                'status' => FALSE,
                'message' => $e->getMessage()
            );
        }
        
        echo json_encode($result);
    }
    
    function update()
    {
        
        /*
        |--------------------------------------------------------------------------
        | Detect Ajax
        |--------------------------------------------------------------------------
        */
        
        if (!$this->input->is_ajax_request()) {
            
            exit('No direct script access allowed');
        }
        
        try {
            
            $validation_rules = array(
                'username' => 'required',
                'id' => 'required|integer',
                'level' => 'required'
            );
            
            $filter_rules = array(
                'username' => 'trim|sanitize_string',
                'id' => 'trim|sanitize_string',
                'level' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);
            
            /*
            |--------------------------------------------------------------------------
            | Set data user
            |--------------------------------------------------------------------------
            */
            
            if ($this->input->post('password') == NULL) {
                
                $status_update = 'without_password';

            } else {
                
                $this->lib_user->setPassword($this->encrypt->encode($this->input->post('password')));
                $status_update = 'with_password';
            }

            date_default_timezone_set("Asia/Jakarta");
            $this->lib_user->setUsername($this->input->post('username'));
            $this->lib_user->setLevel($this->input->post('level'));
            $this->lib_user->setId($this->input->post('id'));
            $this->lib_user->setUpdatedAt(date("Y-m-d H:i:s"));
            
            /*
            |--------------------------------------------------------------------------
            | update data user
            |--------------------------------------------------------------------------
            */
            
            $this->lib_user->findBy('id');
            $this->lib_user->checkPrivilege('admin');
            $this->lib_user->beforeUpdate();
            $this->lib_user->update($status_update);
            $result = array(
                'status' => TRUE,
                'message' => 'Update User'
            );
            
        }
        catch (Exception $e) {
            
            $result = array(
                'status' => FALSE,
                'message' => $e->getMessage()
            );
        }
        
        echo json_encode($result);
    }

    function delete($id)
    {
        
        // set id lokasi
        $this->lib_user->setId($id);
        
        try {
            
            /*
            |--------------------------------------------------------------------------
            | delete data user
            |--------------------------------------------------------------------------
            */
            
            $this->lib_user->findBy('id');
            $this->lib_user->checkPrivilege('admin');
            $this->lib_user->destroy();
            
            $result = array(
                'status' => TRUE,
                'message' => 'Delete Kajian'
            );
            
        }
        catch (Exception $e) {
            
            if ($e->getCode() == 23000) {

                $message = "Cannot delete or update a parent row";

            } else {

                $message = $e->getMessage();
            }
            
            $result = array(
                'status' => FALSE,
                'message' => $message
            );
            
        }
        
        echo json_encode($result);
    }
    
}

/* End of file c_user.php */
/* Location: ./application/modules/c_user/controllers/c_user.php */