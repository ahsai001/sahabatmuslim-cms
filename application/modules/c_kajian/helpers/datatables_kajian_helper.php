<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_button_actions')) {
    function get_button_actions($id, $ustadz_id, $lokasi_id, $startendtime)
    {
        
        $ci =& get_instance();
        
        $html = '<div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                       <li><a class="view" href="' . base_url() . 'c_kajian/detail/' . $id . '">Detail</a></li>
                       <li><a class="edit" href="' . $id . '*/#' . $ustadz_id . '*/#' . $lokasi_id .'">Edit</a></li>
                       <li><a href="' . base_url() . 'c_kajian/delete/' . $id . '">Delete</a></li>
                    </ul>
                 </div>';
        
        return $html;
    }
    
}



/* End of file datatables_kajian_helper.php */
/* Location: ./application/modules/c_kajian/helpers/datatables_kajian_helper.php */