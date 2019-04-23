<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends AUTH_Controller
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
        | Config Page
        |--------------------------------------------------------------------------
        */
        
        $data['path_gmail']       = $this->config->item('gmail');
        $data['head_title']       = $this->config->item('head_title');
        $data['path_app']         = $this->config->item('app');
        $data['path_sweetalert2'] = $this->config->item('sweetalert2');
        $data['path_craftpip']    = $this->config->item('craftpip');
        
        // link authenticate user
        $data['link_authenticate_user'] = $this->config->item('authenticate_user');
        
        $this->load->view('view_login', $data);
    }
    
    function authenticate_user()
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
            
            /*
            |--------------------------------------------------------------------------
            | Validate & Sanitize post data
            |--------------------------------------------------------------------------
            */
            
            $this->load->library('lib_gump');
            
            $validation_rules = array(
                'username' => 'required',
                'password' => 'required'
            );
            
            $filter_rules = array(
                'username' => 'trim|sanitize_string',
                'password' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);
            
            /*
            |--------------------------------------------------------------------------
            | Validate account user
            |--------------------------------------------------------------------------
            */
            
            $this->load->library('lib_user');
            
            $this->lib_user->setUsername($this->input->post('username'));
            $this->lib_user->setPassword($this->input->post('password'));
            
            // find username
            $this->lib_user->findBy('username');
            
            // get data username
            $user = $this->lib_user->ShowBy('username');
            
            // check password
            if ($this->encrypt->decode($user->password) == $this->lib_user->getPassword()) {
                
                // create user session
                $data_session = array(
                    'username' => $user->username,
                    'level' => $user->level,
                    'user_id' => $user->id
                );
                
                $user_logged_in = array(
                    'user_logged_in' => $data_session
                );
                
                $this->session->set_userdata($user_logged_in);
                
            } else {
                
                throw new Exception("Wrong Password");
            }
            
            $result = array(
                'status' => TRUE,
                'message' => "Account Valid",
                'url' => $this->config->item('page_dashboard')
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
    
    function logout()
    {
        
        $this->session->sess_destroy();
        redirect('auth');
    }
}

/* End of file auth.php */
/* Location: ./application/modules/auth/controllers/auth.php */