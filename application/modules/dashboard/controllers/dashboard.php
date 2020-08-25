<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends SESSION_Controller
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
    }
    
    public function index()
    {
        
        $data['header']        = $this->layout->header();
        $data['sidebar']       = $this->layout->sidebar();
        $data['path_sbadmin2'] = $this->config->item('sbadmin2');
        $data['head_title']    = $this->config->item('head_title');
        
        /*
        |--------------------------------------------------------------------------
        | Link menu in dashboard
        |--------------------------------------------------------------------------
        |
        |
        */
        
        $data['link_page_ustadz'] = $this->config->item('page_ustadz');
        $data['link_page_kajian'] = $this->config->item('page_kajian');
        $data['link_page_lokasi'] = $this->config->item('page_lokasi');
        
        $data['num_rows_ustadz'] = Ustadz::count();
        $data['num_rows_kajian'] = Kajian::count();
        $data['num_rows_lokasi'] = Lokasi::count();
        
        $this->load->view('view_dashboard', $data);
    }
    
}

/* End of file dashboard.php */
/* Location: ./application/modules/dashboard/controllers/dashboard.php */