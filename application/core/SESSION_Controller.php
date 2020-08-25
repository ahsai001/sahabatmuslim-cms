<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . "third_party/MX/Controller.php";

class SESSION_Controller extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        # check user session
        
        if (array_key_exists('user_logged_in', $this->session->all_userdata())) {
            
            return 'valid';
            
        } else {
            
            // redirect to page login
            redirect('auth');
        }
        
    }
    
}


/* End of file SESSION_Controller.php */
/* Location: ./application/core/SESSION_Controller.php */