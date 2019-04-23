<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notfound extends SESSION_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT+7');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        
        $this->load->config('salim_config');
    }
    
    public function index()
    {
        
        /*
        |--------------------------------------------------------------------------
        | Config assets
        |--------------------------------------------------------------------------
        |
        |
        */
        
        $data['path_template_404'] = $this->config->item('notfound');
        $data['title']             = $this->config->item('head_title');
        $data['dashboard']         = $this->config->item('page_dashboard');
        
        $this->load->view('view_notfound', $data);
    }
}

/* End of file notfound.php */
/* Location: ./application/module/notfound/controllers/notfound.php */