<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('formatting_errors_slash_n')) {
    function formatting_errors_slash_n($errors)
    {
        
        $exploding_errors = explode("The", strip_tags($errors));
        $filteredarray    = array_values(array_filter($exploding_errors));
        $result           = implode("\n", $filteredarray);
        return $result;
    }
    
}

if (!function_exists('formatting_errors_br')) {
    function formatting_errors_br($errors)
    {
        
        $exploding_errors = explode("The", strip_tags($errors));
        $filteredarray    = array_values(array_filter($exploding_errors));
        $result           = implode("<br/>", $filteredarray);
        return $result;
    }
    
}

/* End of file gump_helper.php */
/* Location: ./application/modules/auth/helpers/gump_helper.php */