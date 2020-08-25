<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('check_range')) {
    function check_range($start, $end)
    {
        
        $strStart = strtotime($start);
        $strEnd   = strtotime($end);
        
        if ($strStart > $strEnd) {
            
            throw new Exception("end time must be greater than the start time");
        }
    }
    
}


/* End of file waktu_helper.php */
/* Location: ./application/modules/c_kajian/helpers/waktu_helper.php */