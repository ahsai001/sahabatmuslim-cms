<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forbidden extends SESSION_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT+7');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        
        /*
        |--------------------------------------------------------------------------
        | Load module layout & fitness first config
        |--------------------------------------------------------------------------
        |
        |
        */
        
        $this->load->config('salim_config');
        $this->load->module('layout');
        
    }
    
    function index()
    {
        
        $data['header']        = $this->layout->header();
        $data['sidebar']       = $this->layout->sidebar();
        $data['path_sbadmin2'] = $this->config->item('sbadmin2');
        $data['head_title']    = $this->config->item('head_title');
        $data['info']          = $this->config->item('info_forbidden');
        
        $this->load->view('view_forbidden', $data);
    }
    
    
}

/* End of file forbidden.php */
/* Location: ./application/modules/forbidden/controllers/forbidden.php */
