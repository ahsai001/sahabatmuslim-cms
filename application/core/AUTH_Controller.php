<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . "third_party/MX/Controller.php";

class AUTH_Controller extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        /*
        |--------------------------------------------------------------------------
        | Get method yang diakses
        |--------------------------------------------------------------------------
        |
        |
        */
        
        if ($this->router->fetch_method() == 'logout') {
            
            return 'valid';
            
        } else {
            
            $all_data_in_session = $this->session->all_userdata();
            
            if (array_key_exists('user_logged_in', $all_data_in_session)) {
                
                // redirect to page dashboard
                redirect('dashboard');
                
            } else {
                
                return 'valid';
            }
            
        }
        
    }
    
}


/* End of file AUTH_Controller.php */
/* Location: ./application/core/AUTH_Controller.php */