<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_button_actions2')) {
    function get_button_actions2($id)
    {
        
        $ci =& get_instance();
        
        $html = '<a class="btn btn-primary" href="' . $id . '">Approve / Reject</a>';
        return $html;
    }
    
}



/* End of file datatables_lokasi_helper.php */
/* Location: ./application/modules/approval/helpers/datatables_lokasi_helper.php */