<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function postData($url, $params) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $res = curl_exec($ch);
    curl_close($ch);

    return $res;
}

function sentEmail($data) {
    //prod
    $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_crypto' => 'tls',
        'smtp_port' => 587,
        'smtp_user' => 'ahsai001@gmail.com', // change it to yours
        'smtp_pass' => 'allahuakbar', // change it to yours
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
    );

    
	/*
    $config['protocol'] = 'sendmail';
	$config['mailpath'] = '/usr/sbin/sendmail';
	$config['charset'] = 'iso-8859-1';
	$config['wordwrap'] = TRUE;
	*/


    $CI =& get_instance();

    $CI->load->library('email');
    $CI->email->initialize($config);
    $CI->email->set_newline("\r\n");
    $CI->email->from('info@zaitunlabs.com'); // change it to yours
    $CI->email->to($data['email']); // change it to yours
    $CI->email->subject($data['subject']);
    $CI->email->message($data['message']);

    if ($CI->email->send()) {
        return true;
    } else {
        return false;
    }
	//$CI->email->send();
	//return $CI->email->print_debugger();
	
}

?>