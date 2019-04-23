<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lib_gump
{
    
    protected $ci;
    
    public function __construct()
    {
        
        $this->ci =& get_instance();
    }
    
    function execute($validation_rules, $filter_rules)
    {
        
        /*
        |--------------------------------------------------------------------------
        | Validate & Sanitize post data
        |--------------------------------------------------------------------------
        */
        
        $gump = new GUMP();
        $gump->validation_rules($validation_rules);
        $gump->filter_rules($filter_rules);
        $validated_data = $gump->run($_POST);
        
        if ($validated_data === false) {
            
            $this->ci->load->helper('gump');
            $validation_errors = formatting_errors_br($gump->get_readable_errors(true));
            
            throw new Exception($validation_errors);
        }
    }
}

/* End of file lib_gump.php */
/* Location: ./application/libraries/lib_gump.php */