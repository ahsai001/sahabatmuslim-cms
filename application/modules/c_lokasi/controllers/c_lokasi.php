<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_lokasi extends SESSION_Controller
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
        $this->load->library('lib_lokasi');
        $this->load->helper('datatables_lokasi');
    }

    public function index()
    {
        
        $data['header']          = $this->layout->header();
        $data['sidebar']         = $this->layout->sidebar();
        $data['path_sbadmin2']   = $this->config->item('sbadmin2');
        $data['path_app']        = $this->config->item('app');
        $data['path_sweetalert2'] = $this->config->item('sweetalert2');
        $data['head_title']      = $this->config->item('head_title');
        
        // link insert, update & refresh lokasi
        $data['link_lokasi_refresh'] = $this->config->item('lokasi_refresh');
        $data['link_lokasi_create']  = $this->config->item('lokasi_create');
        $data['link_lokasi_update']  = $this->config->item('lokasi_update');

        // modal lokasi
        $data['view_modal_lokasi'] = $this->load->view('view_modal_lokasi', NULL, TRUE);
        
        $this->load->view('view_lokasi', $data);
    }

    function datatable()
    {
        
        $this->load->database();
        $this->load->library('Datatables');
        $this->datatables->select('id,place,address,latitude,longitude')->unset_column('id')->add_column('Actions', get_button_actions('$1'), 'id')->from('lokasi')->where('status', 'approved');
        echo $this->datatables->generate();
    }

    function datatableLokasi() {

        $this->load->database();
        $this->load->library('Datatables');
        $this->datatables->select('id,place,address')->from('lokasi')->where('status', 'approved');
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
                'place' => 'required',
                'address' => 'required',
                'latitude' => 'required|valid_latitude',
                'longitude' => 'required|valid_longitude'
            );
            
            $filter_rules = array(
                'place' => 'trim|sanitize_string',
                'address' => 'trim|sanitize_string',
                'latitude' => 'trim|sanitize_string',
                'longitude' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);
            
            /*
            |--------------------------------------------------------------------------
            | Set data lokasi
            |--------------------------------------------------------------------------
            */
            
            date_default_timezone_set("Asia/Jakarta");
            $this->lib_lokasi->setPlace($this->input->post('place'));
            $this->lib_lokasi->setAddress($this->input->post('address'));
            $this->lib_lokasi->setLatitude($this->input->post('latitude'));
            $this->lib_lokasi->setLongitude($this->input->post('longitude'));
            $this->lib_lokasi->setCreatedAt(date("Y-m-d H:i:s"));
            $this->lib_lokasi->setUpdatedAt(date("Y-m-d H:i:s"));
            
            // set user id
            $user_session = $this->session->all_userdata();
            $this->lib_lokasi->setUserId($user_session['user_logged_in']['user_id']);
            
            // set status
            //$status = $user_session['user_logged_in']['level'] == 'guest editor' ? "need approval" : "approved";
            $status = "approved";
            $this->lib_lokasi->setStatus($status);
            
            /*
            |--------------------------------------------------------------------------
            | save data lokasi
            |--------------------------------------------------------------------------
            */
            
            $this->lib_lokasi->beforeStore();
            $this->lib_lokasi->store();
            
            $result = $this->lib_lokasi->getStatus() == 'approved' ? array(
                'status' => TRUE,
                'message' => 'Save Lokasi'
            ) : array(
                'status' => TRUE,
                'message' => 'Save Lokasi, but need approval to be displayed'
            );


            if($this->lib_lokasi->getStatus() == 'need approval'){
                $this->load->helper('message');
                $dataEmail = array("email"=>"ahsai002@gmail.com",
                                    "subject"=>$user_session['user_logged_in']['user_id']." need approval for creating lokasi salim",
                                    "message"=>"lokasi : ".$this->lib_lokasi->getPlace()."<br>"."address : ".$this->lib_lokasi->getAddress());
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
        */
        
        if (!$this->input->is_ajax_request()) {
            
            exit('No direct script access allowed');
        }
        
        try {
            
            $validation_rules = array(
                'id' => 'required|integer',
                'place' => 'required',
                'address' => 'required',
                'latitude' => 'required|valid_latitude',
                'longitude' => 'required|valid_longitude'
            );
            
            $filter_rules = array(
                'id' => 'trim|sanitize_string',
                'place' => 'trim|sanitize_string',
                'address' => 'trim|sanitize_string',
                'latitude' => 'trim|sanitize_string',
                'longitude' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);
            
            /*
            |--------------------------------------------------------------------------
            | Set data lokasi
            |--------------------------------------------------------------------------
            */
            
            date_default_timezone_set("Asia/Jakarta");
            $this->lib_lokasi->setId($this->input->post('id'));
            $this->lib_lokasi->setPlace($this->input->post('place'));
            $this->lib_lokasi->setAddress($this->input->post('address'));
            $this->lib_lokasi->setLatitude($this->input->post('latitude'));
            $this->lib_lokasi->setLongitude($this->input->post('longitude'));
            $this->lib_lokasi->setUpdatedAt(date("Y-m-d H:i:s"));



            $user_session = $this->session->all_userdata();
            // set status
            //$status = $user_session['user_logged_in']['level'] == 'guest editor' ? "need approval" : "approved";
            $status = "approved";
            $this->lib_lokasi->setStatus($status);
            
            /*
            |--------------------------------------------------------------------------
            | update data lokasi
            |--------------------------------------------------------------------------
            */
            
            $this->lib_lokasi->findBy('id');
            $this->lib_lokasi->checkPrivilege('admin&user');
            $this->lib_lokasi->beforeUpdate();
            $this->lib_lokasi->update();


             if($this->lib_lokasi->getStatus() == 'need approval'){
                $this->load->helper('message');
                $dataEmail = array("email"=>"ahsai002@gmail.com",
                                    "subject"=>$user_session['user_logged_in']['user_id']." need approval for updating lokasi salim",
                                    "message"=>"lokasi : ".$this->lib_lokasi->getPlace()."<br>"."address : ".$this->lib_lokasi->getAddress());
                sentEmail($dataEmail);
            }


            $result = array(
                'status' => TRUE,
                'message' => 'Update Lokasi'
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
        $this->lib_lokasi->setId($id);
        
        try {
            
            /*
            |--------------------------------------------------------------------------
            | delete data lokasi
            |--------------------------------------------------------------------------
            */
            
            $this->lib_lokasi->findBy('id');
            $this->lib_lokasi->checkPrivilege('admin&user');
            $this->lib_lokasi->destroy();
            
            $result = array(
                'status' => TRUE,
                'message' => 'Delete lokasi'
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

/* End of file c_lokasi.php */
/* Location: ./application/modules/c_lokasi/controllers/c_lokasi.php */