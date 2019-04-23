<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| config assets
|--------------------------------------------------------------------------
|
*/

$config['notfound']   = base_url() . 'assets/404/';
$config['app']        = base_url() . 'assets/app/';
$config['gmail']      = base_url() . 'assets/gmail/';
$config['sbadmin2']   = base_url() . 'assets/sbadmin2/';
$config['sweetalert2'] = base_url() . 'assets/sweetalert2/';
$config['datepicker'] = base_url() . 'assets/datepicker/';
$config['clockpicker'] = base_url() . 'assets/clockpicker/';
$config['craftpip'] = base_url() . 'assets/craftpip/';


/*
|--------------------------------------------------------------------------
| config title
|--------------------------------------------------------------------------
|
*/

$config['head_title'] = 'Sahabat Muslim CMS';

/*
|--------------------------------------------------------------------------
| config forbidden & not found
|--------------------------------------------------------------------------
|
*/

$config['page_notfound']  = site_url() . 'notfound';
$config['page_forbidden'] = site_url() . 'forbidden';
$config['info_forbidden'] = 'Anda tidak memilik akses untuk masuk ke halaman ini.';

/*
|--------------------------------------------------------------------------
| config list menu
|--------------------------------------------------------------------------
|
*/

$config['page_dashboard'] = site_url() . 'dashboard';
$config['page_auth']      = site_url() . 'auth';
$config['page_ustadz']    = site_url() . 'c_ustadz';
$config['page_kajian']    = site_url() . 'c_kajian';
$config['page_lokasi']    = site_url() . 'c_lokasi';
$config['page_user']      = site_url() . 'c_user';
//$config['page_approval_ustadz']  = site_url() . 'approval/ustadz';


/*
|--------------------------------------------------------------------------
| config page auth
|--------------------------------------------------------------------------
|
*/

$config['authenticate_user'] = site_url() . 'auth/authenticate_user';
$config['logout']            = site_url() . 'auth/logout';

/*
|--------------------------------------------------------------------------
| config page ustadz
|--------------------------------------------------------------------------
|
*/

$config['ustadz_refresh'] = site_url() . 'c_ustadz/datatable';
$config['ustadz_create']  = site_url() . 'c_ustadz/create';
$config['ustadz_edit']    = site_url() . 'c_ustadz/edit/';
$config['ustadz_update']  = site_url() . 'c_ustadz/update';
$config['ustadz_delete']  = site_url() . 'c_ustadz/delete/';
$config['ustadz_list']    = site_url() . 'c_ustadz/datatableUstadz';

/*
|--------------------------------------------------------------------------
| config page lokasi
|--------------------------------------------------------------------------
|
*/

$config['lokasi_refresh'] = site_url() . 'c_lokasi/datatable';
$config['lokasi_create']  = site_url() . 'c_lokasi/create';
$config['lokasi_edit']    = site_url() . 'c_lokasi/edit/';
$config['lokasi_update']  = site_url() . 'c_lokasi/update';
$config['lokasi_delete']  = site_url() . 'c_lokasi/delete/';
$config['lokasi_list']    = site_url() . 'c_lokasi/datatableLokasi';

/*
|--------------------------------------------------------------------------
| config page kajian
|--------------------------------------------------------------------------
|
*/

$config['kajian_refresh'] = site_url() . 'c_kajian/datatable';
$config['kajian_create']  = site_url() . 'c_kajian/create';
$config['kajian_create_auto']  = site_url() . 'c_kajian/create_auto';
$config['kajian_edit']    = site_url() . 'c_kajian/edit/';
$config['kajian_update']  = site_url() . 'c_kajian/update';
$config['kajian_delete']  = site_url() . 'c_kajian/delete/';

/*
|--------------------------------------------------------------------------
| config page user
|--------------------------------------------------------------------------
|
*/

$config['user_refresh'] = site_url() . 'c_user/datatable';
$config['user_create']  = site_url() . 'c_user/create';
$config['user_update']  = site_url() . 'c_user/update';
$config['user_delete']  = site_url() . 'c_user/delete/';

/*
|--------------------------------------------------------------------------
| config page approval
|--------------------------------------------------------------------------
|
*/

$config['approval_ustadz']  = site_url() . 'approval/ustadz';
$config['approval_ustadz_datatable']  = site_url() . 'approval/ustadz_datatable';
$config['approval_ustadz_action']  = site_url() . 'approval/ustadz_action';

$config['approval_lokasi']  = site_url() . 'approval/lokasi';
$config['approval_lokasi_datatable']  = site_url() . 'approval/lokasi_datatable';
$config['approval_lokasi_action']  = site_url() . 'approval/lokasi_action';

$config['approval_kajian']  = site_url() . 'approval/kajian';
$config['approval_kajian_datatable']  = site_url() . 'approval/kajian_datatable';
$config['approval_kajian_action']  = site_url() . 'approval/kajian_action';


/* End of file salim_config.php */
/* Location: ./application/config/salim_config.php */
