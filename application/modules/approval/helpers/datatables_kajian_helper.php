<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_button_actions3')) {
    function get_button_actions3($id)
    {
        
        $ci =& get_instance();
        
        $html = '<div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                       <li><a class="view" href="' . base_url() . 'c_kajian/detail/' . $id . '">Detail</a></li>
                       <li><a href="' . $id . '">Approve / Reject</a></li>
                    </ul>
                 </div>';
        
        return $html;
    }
    
}



/* End of file datatables_kajian_helper.php */
/* Location: ./application/modules/approval/helpers/datatables_kajian_helper.php */