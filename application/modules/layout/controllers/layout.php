<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Layout extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->config('salim_config');
    }
    
    
    function header()
    {
        
        /*
        |--------------------------------------------------------------------------
        | Config Page
        |--------------------------------------------------------------------------
        |
        |
        */
        
        $data['logout']         = $this->config->item('logout');
        $data['title']          = $this->config->item('head_title');
        $data['page_dashboard'] = $this->config->item('page_dashboard');

        # retrieve all data in session
        $all_data_in_session = $this->session->all_userdata();
        $data['username'] = $all_data_in_session['user_logged_in']['username'];
        
        /* Grab layout Header */
        return $this->load->view('view_header', $data, TRUE);
    }
    
    function sidebar()
    {
        
        /*
        |--------------------------------------------------------------------------
        | Config Page
        |--------------------------------------------------------------------------
        |
        |
        */
        
        # link menu in sidebar
        $data['page_dashboard'] = $this->config->item('page_dashboard');
        $data['page_ustadz']    = $this->config->item('page_ustadz');
        $data['page_kajian']    = $this->config->item('page_kajian');
        $data['page_lokasi']    = $this->config->item('page_lokasi');
        $data['page_user']      = $this->config->item('page_user');
        $data['page_approval_ustadz']  = $this->config->item('approval_ustadz');
        $data['page_approval_lokasi']  = $this->config->item('approval_lokasi');
        $data['page_approval_kajian']  = $this->config->item('approval_kajian');
        
        /* Grab layout Sidebar */
        return $this->load->view('view_sidebar', $data, TRUE);
    }
    
}

/* End of file layout.php */
/* Location: ./application/modules/layout/controllers/layout.php */
