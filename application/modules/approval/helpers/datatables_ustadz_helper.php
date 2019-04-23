<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_button_actions'))
{
    function get_button_actions($id) {

        $ci = & get_instance();

        $html = '<a class="btn btn-primary" href="'. $id .'">Approve / Reject</a>';
        return $html;
    }

}



/* End of file datatables_ustadz_helper.php */
/* Location: ./application/modules/approval/helpers/datatables_ustadz_helper.php */