<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . "third_party/MX/Controller.php";

class ADMIN_Controller extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        # retrieve all data in session
        $all_data_in_session = $this->session->all_userdata();
        
        if (array_key_exists('user_logged_in', $all_data_in_session)) {
            
            // check level
            if ($all_data_in_session['user_logged_in']['level'] == 'admin') {
                
                return 'valid';
                
            } else {
                
                // redirect to page forbidden
                redirect('forbidden');
            }
            
        } else {
            
            // redirect to page login
            redirect('auth');
        }
        
    }
    
}


/* End of file ADMIN_Controller.php */
/* Location: ./application/core/ADMIN_Controller.php */