<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approval extends ADMIN_Controller
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
        $this->load->helper('datatables_ustadz');
        $this->load->helper('datatables_lokasi');
        $this->load->helper('datatables_kajian');
    }
    
    function ustadz()
    {
        
        $data['header']           = $this->layout->header();
        $data['sidebar']          = $this->layout->sidebar();
        $data['path_sbadmin2']    = $this->config->item('sbadmin2');
        $data['path_app']         = $this->config->item('app');
        $data['path_sweetalert2'] = $this->config->item('sweetalert2');
        $data['head_title']       = $this->config->item('head_title');
        
        // link list ustadz
        $data['link_list_ustadz']   = $this->config->item('approval_ustadz_datatable');
        $data['link_action_ustadz'] = $this->config->item('approval_ustadz_action');
        
        $this->load->view('view_approval_ustadz', $data);
    }
    
    function ustadz_datatable()
    {
        
        $this->load->database();
        $this->load->library('Datatables');
        $this->datatables->select('ustadz.id,name,email,phone,address,user.username')->unset_column('id')->add_column('Actions', get_button_actions('$1'), 'id')->from('ustadz')->join('user','user_id = user.id')->where('ustadz.status', 'need approval');
        echo $this->datatables->generate();
    }
    
    function ustadz_action()
    {
        
        try {
            
            $action = $this->input->post('action');
            $id     = $this->input->post('id');
            
            $this->load->library('lib_ustadz');
            $this->lib_ustadz->setId($id);
            
            $this->lib_ustadz->findBy('id');
            $this->lib_ustadz->checkPrivilege('admin');
            
            switch ($action) {
                
                case 'approved':
                    
                    date_default_timezone_set("Asia/Jakarta");
                    
                    $ustadz             = Ustadz::find($id);
                    $ustadz->status     = $action;
                    $ustadz->updated_at = date("Y-m-d H:i:s");
                    $ustadz->save();
                    
                    $message = 'Approve Ustadz';
                    
                    break;
                
                case 'reject':
                    
                    $ustadz = Ustadz::find($id);
                    $ustadz->delete();
                    
                    $message = 'Reject Ustadz';
                    break;
                
                default:
                    throw new Exception("Action not found");
                    break;
            }
            
            $result = array(
                'status' => TRUE,
                'message' => $message
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
    
    function lokasi()
    {
        
        $data['header']           = $this->layout->header();
        $data['sidebar']          = $this->layout->sidebar();
        $data['path_sbadmin2']    = $this->config->item('sbadmin2');
        $data['path_app']         = $this->config->item('app');
        $data['path_sweetalert2'] = $this->config->item('sweetalert2');
        $data['head_title']       = $this->config->item('head_title');
        
        // link list lokasi
        $data['link_list_lokasi']   = $this->config->item('approval_lokasi_datatable');
        $data['link_action_lokasi'] = $this->config->item('approval_lokasi_action');
        
        $this->load->view('view_approval_lokasi', $data);
    }
    
    function lokasi_datatable()
    {
        
        $this->load->database();
        $this->load->library('Datatables');
        $this->datatables->select('id,place,address,latitude,longitude')->unset_column('id')->add_column('Actions', get_button_actions2('$1'), 'id')->from('lokasi')->where('status', 'need approval');
        echo $this->datatables->generate();
        
    }
    
    function lokasi_action()
    {
        
        try {
            
            $action = $this->input->post('action');
            $id     = $this->input->post('id');
            
            $this->load->library('lib_lokasi');
            $this->lib_lokasi->setId($id);
            
            $this->lib_lokasi->findBy('id');
            $this->lib_lokasi->checkPrivilege('admin');
            
            switch ($action) {
                
                case 'approved':
                    
                    date_default_timezone_set("Asia/Jakarta");
                    
                    $lokasi             = Lokasi::find($id);
                    $lokasi->status     = $action;
                    $lokasi->updated_at = date("Y-m-d H:i:s");
                    $lokasi->save();
                    
                    $message = 'Approve Lokasi';
                    
                    break;
                
                case 'reject':
                    
                    $lokasi = Lokasi::find($id);
                    $lokasi->delete();
                    
                    $message = 'Reject Lokasi';
                    break;
                
                default:
                    throw new Exception("Action not found");
                    break;
            }
            
            $result = array(
                'status' => TRUE,
                'message' => $message
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
    
    function kajian()
    {
        
        $data['header']           = $this->layout->header();
        $data['sidebar']          = $this->layout->sidebar();
        $data['path_sbadmin2']    = $this->config->item('sbadmin2');
        $data['path_app']         = $this->config->item('app');
        $data['path_sweetalert2'] = $this->config->item('sweetalert2');
        $data['head_title']       = $this->config->item('head_title');
        
        // link list kajian
        $data['link_list_kajian']   = $this->config->item('approval_kajian_datatable');
        $data['link_action_kajian'] = $this->config->item('approval_kajian_action');
        
        // link modal detail kajian
        $data['view_modal_kajian_detail'] = $this->load->view('view_modal_kajian_detail', NULL, TRUE);
        
        $this->load->view('view_approval_kajian', $data);
        
    }
    
    function kajian_datatable()
    {
        
        $this->load->database();
        $this->load->library('Datatables');
        $this->datatables->select('kajian.id,title,tanggal,starttime,endtime,ustadz.name, lokasi.place, user.username')->unset_column('id')->add_column('Actions', get_button_actions3('$1'), 'id')->from('kajian')->join('ustadz','ustadz_id = ustadz.id')->join('user','kajian.user_id = user.id')->join('lokasi','kajian.lokasi_id = lokasi.id')->where('kajian.status', 'need approval');
        echo $this->datatables->generate();
        
    }
    
    function kajian_action()
    {
        
        try {
            
            $action = $this->input->post('action');
            $id     = $this->input->post('id');
            
            $this->load->library('lib_kajian');
            $this->lib_kajian->setId($id);
            
            $this->lib_kajian->findBy('id');
            $this->lib_kajian->checkPrivilege('admin');
            
            switch ($action) {
                
                case 'approved':
                    
                    date_default_timezone_set("Asia/Jakarta");
                    
                    $kajian             = Kajian::find($id);
                    $kajian->status     = $action;
                    $kajian->updated_at = date("Y-m-d H:i:s");
                    $kajian->save();
                    
                    $message = 'Approve Kajian';
                    
                    break;
                
                case 'reject':
                    
                    $kajian = Kajian::find($id);
                    $kajian->delete();
                    
                    $message = 'Reject Kajian';
                    break;
                
                default:
                    throw new Exception("Action not found");
                    break;
            }
            
            $result = array(
                'status' => TRUE,
                'message' => $message
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

/* End of file approval.php */
/* Location: ./application/modules/approval/controllers/approval.php */