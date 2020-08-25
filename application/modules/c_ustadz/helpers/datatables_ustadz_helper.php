<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_button_actions')) {
    function get_button_actions($id)
    {
        
        $ci =& get_instance();
        
        $html = '<div class="dropdown">
	  				<button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
	  				<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
					   <li><a class="edit" href="'. $id .'">Edit</a></li>
					   <li><a href="' .base_url() . 'c_ustadz/delete/' . $id .'">Delete</a></li>
					</ul>
				 </div>';

        return $html;
    }
    
}



/* End of file datatables_ustadz_helper.php */
/* Location: ./application/modules/c_ustadz/helpers/datatables_ustadz_helper.php */