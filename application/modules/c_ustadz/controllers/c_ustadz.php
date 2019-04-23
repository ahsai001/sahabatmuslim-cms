<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_ustadz extends SESSION_Controller
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
        $this->load->library('lib_ustadz');
        $this->load->helper('datatables_ustadz');
    }
    
    public function index()
    {
        $data['header']          = $this->layout->header();
        $data['sidebar']         = $this->layout->sidebar();
        $data['path_sbadmin2']   = $this->config->item('sbadmin2');
        $data['path_app']        = $this->config->item('app');
        $data['path_sweetalert2'] = $this->config->item('sweetalert2');
        $data['head_title']      = $this->config->item('head_title');
        
        // link insert, update & refresh ustadz
        $data['link_ustadz_refresh'] = $this->config->item('ustadz_refresh');
        $data['link_ustadz_create']  = $this->config->item('ustadz_create');
        $data['link_ustadz_update']  = $this->config->item('ustadz_update');
        
        // modal ustadz
        $data['view_modal_ustadz'] = $this->load->view('view_modal_ustadz', NULL, TRUE);
        
        $this->load->view('view_ustadz', $data);
    }
    
    function datatable()
    {
        
        $this->load->database();
        $this->load->library('Datatables');
        $this->datatables->select('id,name,email,phone,address')->unset_column('id')->add_column('Actions', get_button_actions('$1'), 'id')->from('ustadz')->where('status', 'approved');
        echo $this->datatables->generate();
    }

    function datatableUstadz() {

        $this->load->database();
        $this->load->library('Datatables');
        $this->datatables->select('id,name')->from('ustadz')->where('status', 'approved');
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
                'name' => 'required|max_len,70'
                //'email' => 'valid_email',
                //'phone' => 'numeric|max_len,13',
                //'address' => ''
            );
            
            $filter_rules = array(
                'name' => 'trim|sanitize_string',
                'email' => 'trim|sanitize_string',
                'phone' => 'trim|sanitize_string',
                'address' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);
            
            /*
            |--------------------------------------------------------------------------
            | Set data ustadz
            |--------------------------------------------------------------------------
            */
            
            date_default_timezone_set("Asia/Jakarta");
            $this->lib_ustadz->setName($this->input->post('name'));
            $this->lib_ustadz->setEmail($this->input->post('email'));
            $this->lib_ustadz->setPhone($this->input->post('phone'));
            $this->lib_ustadz->setAddress($this->input->post('address'));
            $this->lib_ustadz->setCreatedAt(date("Y-m-d H:i:s"));
            $this->lib_ustadz->setUpdatedAt(date("Y-m-d H:i:s"));
            
            // set user id
            $user_session = $this->session->all_userdata();
            $this->lib_ustadz->setUserId($user_session['user_logged_in']['user_id']);
            
            // set status
            $status = $user_session['user_logged_in']['level'] == 'guest editor' ? "need approval" : "approved";
            $this->lib_ustadz->setStatus($status);
            
            /*
            |--------------------------------------------------------------------------
            | save data ustadz
            |--------------------------------------------------------------------------
            */
            
            $this->lib_ustadz->beforeStore();
            $this->lib_ustadz->store();
            
            $result = $this->lib_ustadz->getStatus() == 'approved' ? array(
                'status' => TRUE,
                'message' => 'Save Ustadz'
            ) : array(
                'status' => TRUE,
                'message' => 'Save Utadz, but need approval to be displayed'
            );



            if($this->lib_ustadz->getStatus() == 'need approval'){
                $this->load->helper('message');
                $dataEmail = array("email"=>"ahsai002@gmail.com",
                                    "subject"=>$user_session['user_logged_in']['user_id']." need approval for adding ustadz salim",
                                    "message"=>"nama ustadz : ".$this->lib_ustadz->getName());
                sentEmail($dataEmail);
            }
            
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
        |
        |
        */
        
        if (!$this->input->is_ajax_request()) {
            
            exit('No direct script access allowed');
        }
        
        try {
            
            $validation_rules = array(
                'id' => 'required|integer',
                'name' => 'required|max_len,70'
                //'email' => 'required|valid_email',
                //'phone' => 'required|numeric|max_len,13',
                //'address' => 'required'
            );
            
            $filter_rules = array(
                'id' => 'trim|sanitize_string',
                'name' => 'trim|sanitize_string',
                'email' => 'trim|sanitize_string',
                'phone' => 'trim|sanitize_string',
                'address' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);
            
            /*
            |--------------------------------------------------------------------------
            | Set data ustadz
            |--------------------------------------------------------------------------
            */
            
            date_default_timezone_set("Asia/Jakarta");
            $this->lib_ustadz->setId($this->input->post('id'));
            $this->lib_ustadz->setName($this->input->post('name'));
            $this->lib_ustadz->setEmail($this->input->post('email'));
            $this->lib_ustadz->setPhone($this->input->post('phone'));
            $this->lib_ustadz->setAddress($this->input->post('address'));
            $this->lib_ustadz->setUpdatedAt(date("Y-m-d H:i:s"));



            $user_session = $this->session->all_userdata();
            // set status
            $status = $user_session['user_logged_in']['level'] == 'guest editor' ? "need approval" : "approved";
            $this->lib_ustadz->setStatus($status);

            
            /*
            |--------------------------------------------------------------------------
            | update data ustadz
            |--------------------------------------------------------------------------
            */
            
            $this->lib_ustadz->findBy('id');
            $this->lib_ustadz->checkPrivilege('admin&user');
            $this->lib_ustadz->beforeUpdate();
            $this->lib_ustadz->update();


             if($this->lib_ustadz->getStatus() == 'need approval'){
                $this->load->helper('message');
                $dataEmail = array("email"=>"ahsai002@gmail.com",
                                    "subject"=>$user_session['user_logged_in']['user_id']." need approval for updating ustadz salim",
                                    "message"=>"nama ustadz : ".$this->lib_ustadz->getName());
                sentEmail($dataEmail);
            }


            $result = array(
                'status' => TRUE,
                'message' => 'Update Ustadz'
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
        
        // set id ustadz
        $this->lib_ustadz->setId($id);
        
        try {
            
            /*
            |--------------------------------------------------------------------------
            | delete data ustadz
            |--------------------------------------------------------------------------
            */
            
            $this->lib_ustadz->findBy('id');
            $this->lib_ustadz->checkPrivilege('admin&user');
            $this->lib_ustadz->destroy();
            
            $result = array(
                'status' => TRUE,
                'message' => 'Delete Ustadz'
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
    
}

/* End of file c_ustadz.php */
/* Location: ./application/modules/c_ustadz/controllers/c_ustadz.php */