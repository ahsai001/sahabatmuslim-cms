<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_kajian extends SESSION_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT+7');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        
        $this->load->config('salim_config');
        $this->load->module('layout');
        $this->load->library('lib_gump');
        $this->load->library('lib_kajian');
        $this->load->helper('waktu');
        $this->load->helper('datatables_kajian');
        
    }
    
    public function index()
    {
        
        $data['header']           = $this->layout->header();
        $data['sidebar']          = $this->layout->sidebar();
        $data['path_sbadmin2']    = $this->config->item('sbadmin2');
        $data['path_app']         = $this->config->item('app');
        $data['path_sweetalert2'] = $this->config->item('sweetalert2');
        $data['path_datepicker']  = $this->config->item('datepicker');
        $data['path_clockpicker'] = $this->config->item('clockpicker');
        $data['head_title']       = $this->config->item('head_title');
        
        // link insert, update & refresh kajian
        $data['link_kajian_refresh'] = $this->config->item('kajian_refresh');
        $data['link_kajian_create']  = $this->config->item('kajian_create');
        $data['link_kajian_create_auto']  = $this->config->item('kajian_create_auto');
        $data['link_kajian_update']  = $this->config->item('kajian_update');
        $data['link_list_ustadz']    = $this->config->item('ustadz_list');
        $data['link_list_lokasi']    = $this->config->item('lokasi_list');
        
        // modal add kajian
        $data['view_modal_kajian']        = $this->load->view('view_modal_kajian', NULL, TRUE);
        $data['view_modal_ustadz']        = $this->load->view('view_modal_ustadz', NULL, TRUE);
        $data['view_modal_lokasi']        = $this->load->view('view_modal_lokasi', NULL, TRUE);
        $data['view_modal_kajian_detail'] = $this->load->view('view_modal_kajian_detail', NULL, TRUE);
        
        $data['view_modal_kajian_auto']        = $this->load->view('view_modal_kajian_auto', NULL, TRUE);
        
        $this->load->view('view_kajian', $data);
    }
    
    function datatable()
    {
        
        $this->load->database();
        $this->load->library('Datatables');
        $this->datatables->select('kajian.id,title,tanggal,starttime,endtime,startendtime,info,ustadz_id,ustadz.name,lokasi_id')->unset_column('id')->unset_column('ustadz_id')->unset_column('lokasi_id')->add_column('Actions', get_button_actions('$1', '$2', '$3'), 'id, ustadz_id, lokasi_id')->from('kajian')->join('ustadz','ustadz_id = ustadz.id')->where('kajian.status', 'approved');
        echo $this->datatables->generate();
    }
    
    function detail($id)
    {
        
        // set id lokasi
        $this->lib_kajian->setId($id);
        
        try {
            
            // find data
            $this->lib_kajian->findBy('id');
            
            // get data
            $detail_kajian = $this->lib_kajian->ShowBy('id');
            
            // set data
            $data = array(
                'title' => $detail_kajian['title'],
                'tanggal' => $detail_kajian['tanggal'],
                'starttime' => $detail_kajian['starttime'],
                'endtime' => $detail_kajian['endtime'],
                'startendtime' => $detail_kajian['startendtime'],
                'info' => $detail_kajian['info'],
                'place' => $detail_kajian->lokasi['place'],
                'address' => $detail_kajian->lokasi['address'],
                'latitude' => $detail_kajian->lokasi['latitude'],
                'longitude' => $detail_kajian->lokasi['longitude'],
                'ustadz' => $detail_kajian->ustadz['name'],
                'user' => $detail_kajian->user['username']
            );
            
            $result = array(
                'status' => TRUE,
                'content' => $data
            );
            
        }
        catch (Exception $e) {
            
            $result = array(
                'status' => FALSE,
                'message' => $e->getMessage()
            );
        }
        
        echo json_encode($result);
    }
    
    function create()
    {
        
        /*
        |--------------------------------------------------------------------------
        | Detect Ajax
        |--------------------------------------------------------------------------
        */
        
        if (!$this->input->is_ajax_request()) {
            
            exit('No direct script access allowed');
        }
        
        try {
            
            $validation_rules = array(
                'title' => 'required',
                'tanggal' => 'required|date',
                'starttime' => 'required|valid_time_hhmm',
                'endtime' => 'required|valid_time_hhmm',
                'ustadz_id' => 'required|integer',
                'lokasi_id' => 'required|integer'
            );
            
            $filter_rules = array(
                'title' => 'trim|sanitize_string',
                'tanggal' => 'trim|sanitize_string',
                'starttime' => 'trim|sanitize_string',
                'endtime' => 'trim|sanitize_string',
                'startendtime' => 'trim|sanitize_string',
                'ustadz_id' => 'trim|sanitize_string',
                'lokasi_id' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);
            
            /*
            |--------------------------------------------------------------------------
            | Set data kajian
            |--------------------------------------------------------------------------
            */
            
            date_default_timezone_set("Asia/Jakarta");
            $this->lib_kajian->setTitle($this->input->post('title'));
            $this->lib_kajian->setTanggal($this->input->post('tanggal'));
            $this->lib_kajian->setUstadzId($this->input->post('ustadz_id'));
            $this->lib_kajian->setLokasiId($this->input->post('lokasi_id'));
            $this->lib_kajian->setCreatedAt(date("Y-m-d H:i:s"));
            $this->lib_kajian->setUpdatedAt(date("Y-m-d H:i:s"));

            $this->lib_kajian->setInfo($this->input->post('info'));
            
            // convert time meridian
            $starttime = date('H:i:s', strtotime($this->input->post('starttime')));
            $endtime   = date('H:i:s', strtotime($this->input->post('endtime')));
            
            // validate range time
            check_range($starttime, $endtime);
            
            $this->lib_kajian->setStarttime($starttime);
            $this->lib_kajian->setEndtime($endtime);

            $this->lib_kajian->setStartEndtime($this->input->post('startendtime'));
            
            // set user id
            $user_session = $this->session->all_userdata();
            $this->lib_kajian->setUserId($user_session['user_logged_in']['user_id']);
            
            // set status
            $status = $user_session['user_logged_in']['level'] == 'guest editor' ? "need approval" : "approved";
            $this->lib_kajian->setStatus($status);
            
            /*
            |--------------------------------------------------------------------------
            | save data kajian
            |--------------------------------------------------------------------------
            */
            
            $this->lib_kajian->beforeStore();
            $this->lib_kajian->store();
            
            $result = $this->lib_kajian->getStatus() == 'approved' ? array(
                'status' => TRUE,
                'message' => 'Save Kajian'
            ) : array(
                'status' => TRUE,
                'message' => 'Save Kajian, but need approval to be displayed'
            );

           if($this->lib_kajian->getStatus() == 'need approval'){
                $this->load->helper('message');
                $dataEmail = array("email"=>"ahsai002@gmail.com",
                                    "subject"=>$user_session['user_logged_in']['user_id']." need approval for creating kajian salim",
                                    "message"=>"title : ".$this->lib_kajian->getTitle()."<br>"."tanggal : ".$this->lib_kajian->getTanggal());
                sentEmail($dataEmail);
            }
            
        }
        catch (Exception $e) {
            
            $result = array(
                'status' => FALSE,
                'message' => $e->getMessage()
            );
        }
        
        echo json_encode($result);
    }










    // FOLLOW A SINGLE REDIRECT:
    // This makes a single request and reads the "Location" header to determine the
    // destination. It doesn't check if that location is valid or not.
    function get_redirect_target($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $headers = curl_exec($ch);
        curl_close($ch);
        // Check if there's a Location: header (redirect)
        if (preg_match('/^Location: (.+)$/im', $headers, $matches))
            return trim($matches[1]);
        // If not, there was no redirect so return the original URL
        // (Alternatively change this to return false)
        return $url;
    }




    // FOLLOW ALL REDIRECTS:
    // This makes multiple requests, following each redirect until it reaches the
    // final destination.
    function get_redirect_final_target($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // set referer on redirect
        curl_exec($ch);
        $target = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        if ($target)
            return $target;
        return false;
    }

    function starts_with($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    function ends_with($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function get_request($url, $cookies = null, $connect_timeout = 120, $response_timeout = 120){
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => $connect_timeout,      // timeout on connect
            CURLOPT_TIMEOUT        => $response_timeout,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        );

        $ch      = curl_init($url);
        curl_setopt_array($ch, $options);

        if(!empty($cookies)){
            curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        }

        $content = curl_exec($ch);
        $err     = curl_errno($ch);
        $errmsg  = curl_error($ch);
        $header  = curl_getinfo($ch);
        curl_close($ch);

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }

    function get_adzan_api_url($latitude, $longitude, $month_string, $year_string){
        return "http://api.aladhan.com/v1/calendar?latitude=".urlencode($latitude)."&longitude=".urlencode($longitude)."&method=5&month=".$month_string."&year=".$year_string."&tune=".urlencode("0,0,0,3,2,0,3,4,0");
    }

    function get_adzan_time($result_from_api, $date_string){
        $praytime_array = json_decode($result_from_api, true);
        $praytime_data = $praytime_array['data'];
        $praytime_curr = $praytime_data[(float)$date_string - 1];
        $praytime_curr_time = $praytime_curr['timings'];
        return $praytime_curr_time;
    }

    function get_place_api_url($cid){
        return "https://maps.googleapis.com/maps/api/place/details/json?cid=".$cid."&key=AIzaSyAfp20TEldFUHZ3hlVGgpyBWnpGxeLIJZw";
    }

    function get_place_detail($cid){
        $place_api_url = $this->get_place_api_url($cid);
        $place_result = $this->get_request($place_api_url,null,120, 300);
        $place_result_array = json_decode($place_result['content'], true);
        $place_result_data = $place_result_array['result'];
        $place_result_geometry = $place_result_data['geometry'];
        $place_result_location = $place_result_geometry['location'];
        $place_result_location['name'] = $place_result_data['name'];
        return $place_result_location;
    }

    function check_if_contains($haystack, $needle){
        return strpos($haystack, $needle) !== false ? true : false;
    }



    function save_kajian($title, $tanggal, $start_time, $end_time, $start_end_time, $ustadz_id, $lokasi_id, $info){
        try {
                $this->lib_kajian->setTitle($title);
                $this->lib_kajian->setTanggal($tanggal);
                $this->lib_kajian->setUstadzId($ustadz_id);
                $this->lib_kajian->setLokasiId($lokasi_id);
                $this->lib_kajian->setCreatedAt(date("Y-m-d H:i:s"));
                $this->lib_kajian->setUpdatedAt(date("Y-m-d H:i:s"));

                $this->lib_kajian->setInfo($info);
                
                // convert time meridian
                $starttime = date('H:i:s', strtotime($start_time));
                $endtime   = date('H:i:s', strtotime($end_time));
                
                // validate range time
                check_range($starttime, $endtime);
                
                $this->lib_kajian->setStarttime($starttime);
                $this->lib_kajian->setEndtime($endtime);

                $this->lib_kajian->setStartEndtime($start_end_time);
                
                // set user id
                $user_session = $this->session->all_userdata();
                $this->lib_kajian->setUserId($user_session['user_logged_in']['user_id']);
                
                // set status
                $status = $user_session['user_logged_in']['level'] == 'guest editor' ? "need approval" : "approved";
                $this->lib_kajian->setStatus($status);
                
                /*
                |--------------------------------------------------------------------------
                | save data kajian
                |--------------------------------------------------------------------------
                */
                
                $this->lib_kajian->beforeStore();
                $this->lib_kajian->store();
        } catch (Exception $e) {
            throw new Exception($e);  
        }
    }


    function extract_gmaps_link($value, &$last_url, &$latitude, &$longitude, &$place_in_maps, &$is_special_case_gmaps){
        if(substr_count($value, ',') == 2){
            //special case
            list($last_url, $latitude, $longitude) = explode(',',$value);
            $is_special_case_gmaps = true;
        } else {
            $last_url = $this->get_redirect_final_target($value);
            $last_url = trim($last_url);
            if(!$this->check_if_contains($last_url,'?')){
                $last_url .= "?";
            }
            $last_url_cropped = substr($last_url, strrpos($last_url,'!8m2!3d'));
            $coordinate = $this->get_string_between($last_url_cropped,'!8m2!3d','?');
            $place_in_maps = $this->get_string_between($last_url,'maps/place/','/@');
            if(!empty($place_in_maps)){
                $place_in_maps = urldecode($place_in_maps);
            } else {
                $place_in_maps = '';
            }
            if(!empty($coordinate)){
                list($latitude,$longitude) = explode('!4d',$coordinate);
            } else {
                //handle if url format like this https://www.google.com/maps?q=-7.006016,110.379629&hl=in&gl=id&shorturl=1
                if($this->check_if_contains($last_url,'maps?q=')){
                    $place_url_parts = parse_url($last_url);
                    parse_str($place_url_parts['query'], $place_url_parts_array);
                    if (array_key_exists('q', $place_url_parts_array)) {
                        try{
                            list($latitude,$longitude) = explode(',',$place_url_parts_array['q'],2);
                            if(is_numeric($latitude) && is_numeric($longitude)){
                                return;
                            }
                        } catch (Exception $e){
                        }
                    }
                }

                //handle if url format cid= using place api
                if($this->check_if_contains($last_url,'cid=')){
                } else {
                    $last_url = $this->get_redirect_target($value);
                    $last_url = trim($last_url);
                }

                if($this->check_if_contains($last_url,'cid=')){
                    $place_url_parts = parse_url($last_url);
                    $last_url = $value; //set last_url as origin
                    parse_str($place_url_parts['query'], $place_url_parts_array);
                    if (array_key_exists('cid', $place_url_parts_array)) {
                        //throw new Exception($place_url_parts_array['cid']);
                        try{
                            $place_location = $this->get_place_detail($place_url_parts_array['cid']);
                            $latitude = $place_location['lat'];
                            $longitude = $place_location['lng'];
                            $place_in_maps = $place_location['name'];
                            
                            return;
                        } catch (Exception $e){
                        }
                    }
                }

                $last_url = $value; //set last_url as origin
                $latitude = '';
                $longitude = '';
            }
        }
    }


    function create_auto()
    {
        
        /*
        |--------------------------------------------------------------------------
        | Detect Ajax
        |--------------------------------------------------------------------------
        */
        
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        try {
            
            $validation_rules = array(
                'info_auto' => 'required'
            );
            
            $filter_rules = array(
                'info_auto' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);


            date_default_timezone_set("Asia/Jakarta");


            //parsing data 
            $itinerary_list = $this->input->post('info_auto');

            $tanggal_kajian = '';

            $tempat_kajian = '';
            $pemateri_kajian = '';
            $tema_kajian = '';
            
            $waktu_kajian = '';
            $start_sholat_time = '';
            $end_sholat_time = '';

            $informasi_kajian = '';
            $last_url = '';

            
            $latitude = '';
            $longitude = '';
            $place_in_maps = '';

            $result = '';

            $total_sukses = 0;
            $total_duplikat = 0;
            $total_gagal = 0;

            //set user id
            $user_session = $this->session->all_userdata();

            $user_id = $user_session['user_logged_in']['user_id'];
            
            //set status
            $user_status = $user_session['user_logged_in']['level'] == 'guest editor' ? "need approval" : "approved";

            if ($user_status != 'approved') {
                throw new Exception("You can not run this process");
            }
            
            $this->load->model('kajian_oto');
            

            /* //for development testing only
            $ustadz_id = $this->kajian_oto->get_ustadz_id('Ustadz Testing, Lc  حفظه الله تعالى ', '-', '-', '-', $user_status, $user_id);
            list($place, $address) = explode(',','Masjid Qotrunnada SD Embun Pagi Jl. Kapin No.8 Kalimalang jakarta Timur',2);
            $lokasi_id = $this->kajian_oto->get_lokasi_id(-6, 106, $place, $address, $user_status, $user_id);
            $this->save_kajian('Kitab 101 Cara Mudah Mendidik Keluarga, Menggali Bakat Anak Hebat Dalam Pandangan Syariat Islam', date("Y-m-d"), '16:00', '18:00', $waktu_kajian, $ustadz_id, $lokasi_id, 'testing');
            */


            $is_special_case_gmaps = false;

            foreach(preg_split("/((\r?\n)|(\r\n?))/", $itinerary_list) as $line){
                if($this->starts_with($line,'Tanggal')){
                    list(,$tanggal_kajian) = explode(':',$line);
                    $tanggal_kajian = trim($tanggal_kajian);
                } else if($this->starts_with($line,'Tempat')){
                    if(!empty($latitude) && !empty($longitude)
                    && !empty($tempat_kajian) && !empty($pemateri_kajian) 
                    && !empty($tema_kajian) && !empty($waktu_kajian)){
                        //insert to database
                        try {
                            $ustadz_id = $this->kajian_oto->get_ustadz_id($pemateri_kajian, '-', '-', '-', $user_status, $user_id);
                            if(!$this->check_if_contains($tempat_kajian,',')){
                                $tempat_kajian .= ',';
                            }
                            list($place, $address) = explode(',',$tempat_kajian,2);
                            $lokasi_id = $this->kajian_oto->get_lokasi_id($latitude, $longitude, $place_in_maps, $place, $address, $user_status, $user_id);
                            
                            if($is_special_case_gmaps){
                                //update lokasi with last_url
                                $this->kajian_oto->update_url_lokasi($last_url, $lokasi_id);
                                $is_special_case_gmaps = false;
                            }
                            
                            $this->save_kajian($tema_kajian, empty($tanggal_kajian)?date("Y-m-d"):$tanggal_kajian, $start_sholat_time, $end_sholat_time, $waktu_kajian, $ustadz_id, $lokasi_id, $informasi_kajian);
                         
                            $total_sukses++;
                        } catch (Exception $e) {
                            //do nothing, next iteration
                            //log_message('error', 'failed saving kajian, next iteration : '.$e->getMessage());
                            
                            $total_duplikat++;
                        }
                        $tempat_kajian = '';
                        $last_url = '';
                        $latitude = '';
                        $longitude = '';
                        $pemateri_kajian = '';
                        $tema_kajian = '';
                        $waktu_kajian = '';
                        $start_sholat_time = '';
                        $end_sholat_time = '';
                        $informasi_kajian = '';
                    } else if(empty($latitude) && empty($longitude) 
                    && !empty($tempat_kajian) && !empty($pemateri_kajian) 
                    && !empty($tema_kajian) && !empty($waktu_kajian)){
                        if(!empty($last_url)){
                            $lokasi_id = $this->kajian_oto->get_lokasi_id_by_url($last_url);
                            if($lokasi_id){
                                try {
                                    $ustadz_id = $this->kajian_oto->get_ustadz_id($pemateri_kajian, '-', '-', '-', $user_status, $user_id);
                                    if(!$this->check_if_contains($tempat_kajian,',')){
                                        $tempat_kajian .= ',';
                                    }
                                    list($place, $address) = explode(',',$tempat_kajian,2);
                                    $this->save_kajian($tema_kajian, empty($tanggal_kajian)?date("Y-m-d"):$tanggal_kajian, $start_sholat_time, $end_sholat_time, $waktu_kajian, $ustadz_id, $lokasi_id, $informasi_kajian);
                                 
                                    $total_sukses++;
                                } catch (Exception $e) {
                                    //do nothing, next iteration
                                    //log_message('error', 'failed saving kajian, next iteration : '.$e->getMessage());
                                    
                                    $total_duplikat++;
                                }

                                $tempat_kajian = '';
                                $last_url = '';
                                $latitude = '';
                                $longitude = '';
                                $pemateri_kajian = '';
                                $tema_kajian = '';
                                $waktu_kajian = '';
                                $start_sholat_time = '';
                                $end_sholat_time = '';
                                $informasi_kajian = '';

                                continue;
                            }
                        }
                        $result .= "<br>Tempat : ".$tempat_kajian;
                        $result .= "<br>Google Maps : ".$last_url;
                        $result .= "<br>Pemateri : ".$pemateri_kajian;
                        $result .= "<br>Tema : ".$tema_kajian;
                        $result .= "<br>Waktu : ".$waktu_kajian;
                        $result .= "<br>Informasi : ".$informasi_kajian;
                        $result .= "<br><br>";
        
                        $tempat_kajian = '';
                        $last_url = '';
                        $latitude = '';
                        $longitude = '';
                        $pemateri_kajian = '';
                        $tema_kajian = '';
                        $waktu_kajian = '';
                        $start_sholat_time = '';
                        $end_sholat_time = '';
                        $informasi_kajian = '';

                        $total_gagal++;
                    }

                    list(,$tempat_kajian) = explode(':',$line, 2);
                    $tempat_kajian = trim($tempat_kajian);

                    if($this->check_if_contains($tempat_kajian,' gmap ')){ //1
                        //extract link gmaps
                        list($tempat_kajian, $gmaps_link_in_tempat) = explode(' gmap ', $tempat_kajian);
                        $tempat_kajian = trim($tempat_kajian, ",");
                    } else if($this->check_if_contains($tempat_kajian,' Gmap ')){ //2
                        //extract link gmaps
                        list($tempat_kajian, $gmaps_link_in_tempat) = explode(' Gmap ', $tempat_kajian);
                        $tempat_kajian = trim($tempat_kajian, ",");
                    } else if($this->check_if_contains($tempat_kajian,'bit.ly')){ //3
                        //extract link gmaps
                        list($tempat_kajian, $gmaps_link_in_tempat) = explode('(', $tempat_kajian);
                        $gmaps_link_in_tempat = trim($gmaps_link_in_tempat, ")");
                        $gmaps_link_in_tempat = trim($gmaps_link_in_tempat);
                    } else if($this->check_if_contains($tempat_kajian,'(peta:')){ //4
                        //extract link gmaps
                        list($tempat_kajian, $gmaps_link_in_tempat) = explode('(peta:', $tempat_kajian);
                        $gmaps_link_in_tempat = trim($gmaps_link_in_tempat, ")");
                        $gmaps_link_in_tempat = trim($gmaps_link_in_tempat);
                    } else if($this->check_if_contains($tempat_kajian,'( https://') || $this->check_if_contains($tempat_kajian,'(https://')){ //5
                        //extract link gmaps
                        list($tempat_kajian, $gmaps_link_in_tempat) = explode('(', $tempat_kajian);
                        $gmaps_link_in_tempat = trim($gmaps_link_in_tempat, ")");
                        $gmaps_link_in_tempat = trim($gmaps_link_in_tempat);
                    } else if($this->check_if_contains($tempat_kajian,'https://')){
                        list($tempat_kajian, $gmaps_link_in_tempat) = explode('https://', $tempat_kajian);
                        $gmaps_link_in_tempat = trim($gmaps_link_in_tempat);
                        $gmaps_link_in_tempat = "https://".$gmaps_link_in_tempat;
                    } else if($this->check_if_contains($tempat_kajian,'http://')){
                        list($tempat_kajian, $gmaps_link_in_tempat) = explode('http://', $tempat_kajian);
                        $gmaps_link_in_tempat = trim($gmaps_link_in_tempat);
                        $gmaps_link_in_tempat = "http://".$gmaps_link_in_tempat;
                    }

                    if(!empty($gmaps_link_in_tempat)){
                        $this->extract_gmaps_link($gmaps_link_in_tempat, $last_url, $latitude, $longitude, $place_in_maps, $is_special_case_gmaps);
                    }

                } else if($this->starts_with($line,'Google Maps') || $this->starts_with($line,'G-Maps')){
                    list(, $value) = explode(': ',$line);
                    if(empty($value)){
                        list(, $value) = explode(' :',$line);
                    }
                    $value = trim($value);

                    /* //to debug inspection of last_url
                    $last_url = $this->get_redirect_final_target($value);
                    throw new Exception("->".$last_url); */

                    $this->extract_gmaps_link($value, $last_url, $latitude, $longitude, $place_in_maps, $is_special_case_gmaps);
                } else if($this->starts_with($line,'Pemateri') || $this->starts_with($line,'1 Pemateri') || $this->starts_with($line,'2 Pemateri')){
                    if(!empty($latitude) && !empty($longitude) 
                    && !empty($tempat_kajian) && !empty($pemateri_kajian) 
                    && !empty($tema_kajian) && !empty($waktu_kajian)){
                        //insert to database
                        try {
                            $ustadz_id = $this->kajian_oto->get_ustadz_id($pemateri_kajian, '-', '-', '-', $user_status, $user_id);
                            if(!$this->check_if_contains($tempat_kajian,',')){
                                $tempat_kajian .= ',';
                            }
                            list($place, $address) = explode(',',$tempat_kajian,2);
                            $lokasi_id = $this->kajian_oto->get_lokasi_id($latitude, $longitude, $place_in_maps, $place, $address, $user_status, $user_id);
                            
                            if($is_special_case_gmaps){
                                //update lokasi with last_url
                                $this->kajian_oto->update_url_lokasi($last_url, $lokasi_id);
                                $is_special_case_gmaps = false;
                            }
                            
                            $this->save_kajian($tema_kajian, empty($tanggal_kajian)?date("Y-m-d"):$tanggal_kajian, $start_sholat_time, $end_sholat_time, $waktu_kajian, $ustadz_id, $lokasi_id, $informasi_kajian);
                            
                            $total_sukses++;
                        } catch (Exception $e) {
                            //do nothing, next iteration
                            //log_message('error', 'failed saving kajian, next iteration : '.$e->getMessage());

                            $total_duplikat++;
                        }

                        $pemateri_kajian = '';
                        $tema_kajian = '';
                        $waktu_kajian = '';
                        $start_sholat_time = '';
                        $end_sholat_time = '';
                        $informasi_kajian = '';
                    } else  if(empty($latitude) && empty($longitude) 
                    && !empty($tempat_kajian) && !empty($pemateri_kajian) 
                    && !empty($tema_kajian) && !empty($waktu_kajian)){
                        if(!empty($last_url)){
                            $lokasi_id = $this->kajian_oto->get_lokasi_id_by_url($last_url);
                            if($lokasi_id){
                                try {
                                    $ustadz_id = $this->kajian_oto->get_ustadz_id($pemateri_kajian, '-', '-', '-', $user_status, $user_id);
                                    if(!$this->check_if_contains($tempat_kajian,',')){
                                        $tempat_kajian .= ',';
                                    }
                                    list($place, $address) = explode(',',$tempat_kajian,2);
                                    $this->save_kajian($tema_kajian, empty($tanggal_kajian)?date("Y-m-d"):$tanggal_kajian, $start_sholat_time, $end_sholat_time, $waktu_kajian, $ustadz_id, $lokasi_id, $informasi_kajian);
                                 
                                    $total_sukses++;
                                } catch (Exception $e) {
                                    //do nothing, next iteration
                                    //log_message('error', 'failed saving kajian, next iteration : '.$e->getMessage());
                                    
                                    $total_duplikat++;
                                }

                                $pemateri_kajian = '';
                                $tema_kajian = '';
                                $waktu_kajian = '';
                                $start_sholat_time = '';
                                $end_sholat_time = '';
                                $informasi_kajian = '';

                                continue;
                            }
                        }

                        $result .= "<br>Tempat : ".$tempat_kajian;
                        $result .= "<br>Google Maps : ".$last_url;
                        $result .= "<br>Pemateri : ".$pemateri_kajian;
                        $result .= "<br>Tema : ".$tema_kajian;
                        $result .= "<br>Waktu : ".$waktu_kajian;
                        $result .= "<br>Informasi : ".$informasi_kajian;
                        $result .= "<br><br>";

                        $pemateri_kajian = '';
                        $tema_kajian = '';
                        $waktu_kajian = '';
                        $start_sholat_time = '';
                        $end_sholat_time = '';
                        $informasi_kajian = '';

                        $total_gagal++;
                    }

                    list(,$pemateri_kajian) = explode(':',$line);
                    $pemateri_kajian = trim($pemateri_kajian);
                } else if($this->starts_with($line,'Tema') || $this->starts_with($line,'1 Tema') || $this->starts_with($line,'2 Tema')){
                    list(,$value) = explode(':',$line);
                    $tema_kajian = $tema_kajian.(empty($tema_kajian)?'':' : ').trim($value);
                } else if($this->starts_with($line,'Waktu')){
                    list(, $value) = explode(': ',$line);
                    if(empty($value)){
                        list(, $value) = explode(' :',$line);
                    }
                    $waktu_kajian = trim($value);

                    $waktu_kajian = str_replace('–', '-', $waktu_kajian);
                    $waktu_kajian = str_replace(' - ', '-', $waktu_kajian);
                    list($start_time, $end_time) = explode('-', $waktu_kajian, 2);
                    if(!empty($latitude) && !empty($longitude)){
                        if(empty($tanggal_kajian)){
                            $tanggal_kajian = date("Y-m-d");
                        }
                        
                        $curr_date = date("d", strtotime($tanggal_kajian));
                        $curr_month = date("m", strtotime($tanggal_kajian));
                        $curr_year = date("Y", strtotime($tanggal_kajian));

                        $adzan_api_url = $this->get_adzan_api_url($latitude, $longitude, $curr_month, $curr_year);
                        $praytime_result = $this->get_request($adzan_api_url,null,120, 300);
                        $praytime_curr_time = $this->get_adzan_time($praytime_result['content'], $curr_date);

                        $start_time = strtolower($start_time);
                        $end_time = strtolower($end_time);

                        $start_sholat_type = "time";
                        if($this->check_if_contains($start_time, "subuh") || $this->check_if_contains($start_time, "shubuh")){
                            $start_sholat_type = "Fajr";
                        } else if($this->check_if_contains($start_time, "dzuhur") || $this->check_if_contains($start_time, "zhuhur")){
                            $start_sholat_type = "Dhuhr";
                        } else if($this->check_if_contains($start_time, "ashar") || $this->check_if_contains($start_time, "asar")){
                            $start_sholat_type = "Asr";
                        } else if($this->check_if_contains($start_time, "maghrib") || $this->check_if_contains($start_time, "magrib")){
                            $start_sholat_type = "Maghrib";
                        } else if($this->check_if_contains($start_time, "isya")){
                            $start_sholat_type = "Isha";
                        } else {
                            $start_sholat_type = "time";
                            $start_time = preg_replace('/[^0-9.]/', '', $start_time);
                        }

                        if($this->check_if_contains($start_sholat_type, "time")){
                            $start_sholat_time = str_replace('.',':',$start_time);
                        } else {
                            $start_sholat_time_complete = $praytime_curr_time[$start_sholat_type];
                            list($start_sholat_time,) = explode(" ", $start_sholat_time_complete);
                        }

                        $end_sholat_type = "time";
                        if($this->check_if_contains($end_time, "subuh") || $this->check_if_contains($end_time, "shubuh")){
                            $end_sholat_type = "Fajr";
                        } else if($this->check_if_contains($end_time, "dzuhur") || $this->check_if_contains($end_time, "zhuhur")){
                            $end_sholat_type = "Dhuhr";
                        } else if($this->check_if_contains($end_time, "ashar") || $this->check_if_contains($end_time, "asar")){
                            $end_sholat_type = "Asr";
                        } else if($this->check_if_contains($end_time, "maghrib") || $this->check_if_contains($end_time, "magrib")){
                            $end_sholat_type = "Maghrib";
                        } else if($this->check_if_contains($end_time, "isya")){
                            $end_sholat_type = "Isha";
                        } else if($this->check_if_contains($end_time, "selesai")){
                            $end_sholat_type = "selesai";
                        } else {
                            $start_sholat_type = "time";
                            $end_time = preg_replace('/[^0-9.]/', '', $end_time);
                        }

                        if($this->check_if_contains($end_sholat_type, "time")){
                            $end_sholat_time = str_replace('.',':',$end_time);
                        } else if($this->check_if_contains($end_sholat_type, "selesai")){
                            $end_sholat_time = date('H:i',strtotime('+2 hours',strtotime($start_sholat_time)));
                        } else {
                            $end_sholat_time_complete = $praytime_curr_time[$end_sholat_type];
                            list($end_sholat_time,) = explode(" ", $end_sholat_time_complete);
                        }
                    }
                } else if($this->starts_with($line,'Informasi') || $this->starts_with($line,'PIC')){
                    list(, $value) = explode(': ',$line);
                    if(empty($value)){
                        list(, $value) = explode(' :',$line);
                    }
                    $informasi_kajian = trim($value);
                } else if($this->starts_with($line,'KHOTIB JUM\'AT') || $this->starts_with($line,'KHOTIB JUM’AT') ){
                    list(,$value) = explode(':',$line);
                    $pemateri_kajian = trim($value);
                    $tema_kajian = "Khutbah Jum'at";

                    $waktu_kajian = "khutbah sholat jum'at";

                    if(!empty($latitude) && !empty($longitude)){
                        if(empty($tanggal_kajian)){
                            $tanggal_kajian = date("Y-m-d");
                        }
                        
                        $curr_date = date("d", strtotime($tanggal_kajian));
                        $curr_month = date("m", strtotime($tanggal_kajian));
                        $curr_year = date("Y", strtotime($tanggal_kajian));

                        $adzan_api_url = $this->get_adzan_api_url($latitude, $longitude, $curr_month, $curr_year);
                        $praytime_result = $this->get_request($adzan_api_url,null,120, 300);
                        $praytime_curr_time = $this->get_adzan_time($praytime_result['content'], $curr_date);

                        $start_sholat_time_complete = $praytime_curr_time['Dhuhr'];
                        list($start_sholat_time,) = explode(" ", $start_sholat_time_complete);
                        $end_sholat_time = date('H:i',strtotime('30 minutes',strtotime($start_sholat_time)));

                        $waktu_kajian = $start_sholat_time." - ".$end_sholat_time;
                    }
                }
            } 

            $is_gagal_item_terakhir = false;

            if(!empty($latitude) && !empty($longitude) 
            && !empty($tempat_kajian) && !empty($pemateri_kajian) 
            && !empty($tema_kajian) && !empty($waktu_kajian)){
                //insert to database
                try {
                    $ustadz_id = $this->kajian_oto->get_ustadz_id($pemateri_kajian, '-', '-', '-', $user_status, $user_id);
                    if(!$this->check_if_contains($tempat_kajian,',')){
                        $tempat_kajian .= ',';
                    }
                    list($place, $address) = explode(',',$tempat_kajian,2);
                    $lokasi_id = $this->kajian_oto->get_lokasi_id($latitude, $longitude, $place_in_maps, $place, $address, $user_status, $user_id);
                    
                    if($is_special_case_gmaps){
                        //update lokasi with last_url
                        $this->kajian_oto->update_url_lokasi($last_url, $lokasi_id);
                        $is_special_case_gmaps = false;
                    }
                    
                    $this->save_kajian($tema_kajian, empty($tanggal_kajian)?date("Y-m-d"):$tanggal_kajian, $start_sholat_time, $end_sholat_time, $waktu_kajian, $ustadz_id, $lokasi_id, $informasi_kajian);
                    
                    $total_sukses++;
                } catch (Exception $e) {
                    //do nothing, next step
                    //log_message('error', 'failed saving kajian, next step : '.$e->getMessage());

                    $total_duplikat++;
                }

                $tempat_kajian = '';
                $last_url = '';
                $latitude = '';
                $longitude = '';
                $pemateri_kajian = '';
                $tema_kajian = '';
                $waktu_kajian = '';
                $start_sholat_time = '';
                $end_sholat_time = '';
                $informasi_kajian = '';
            } else  if(empty($latitude) && empty($longitude) 
            && !empty($tempat_kajian) && !empty($pemateri_kajian) 
            && !empty($tema_kajian) && !empty($waktu_kajian)){
                if(!empty($last_url)){
                    $lokasi_id = $this->kajian_oto->get_lokasi_id_by_url($last_url);
                    if($lokasi_id){
                        try {
                            $ustadz_id = $this->kajian_oto->get_ustadz_id($pemateri_kajian, '-', '-', '-', $user_status, $user_id);
                            if(!$this->check_if_contains($tempat_kajian,',')){
                                $tempat_kajian .= ',';
                            }
                            list($place, $address) = explode(',',$tempat_kajian,2);
                            $this->save_kajian($tema_kajian, empty($tanggal_kajian)?date("Y-m-d"):$tanggal_kajian, $start_sholat_time, $end_sholat_time, $waktu_kajian, $ustadz_id, $lokasi_id, $informasi_kajian);
                         
                            $total_sukses++;
                        } catch (Exception $e) {
                            //do nothing, next iteration
                            //log_message('error', 'failed saving kajian, next iteration : '.$e->getMessage());
                            
                            $total_duplikat++;
                        }

                        $tempat_kajian = '';
                        $last_url = '';
                        $latitude = '';
                        $longitude = '';
                        $pemateri_kajian = '';
                        $tema_kajian = '';
                        $waktu_kajian = '';
                        $start_sholat_time = '';
                        $end_sholat_time = '';
                        $informasi_kajian = '';
                    } else {
                        $is_gagal_item_terakhir = true;
                    }
                } else {
                    $is_gagal_item_terakhir = true;
                }
                

                if($is_gagal_item_terakhir){
                    $result .= "<br>Tempat : ".$tempat_kajian;
                    $result .= "<br>Google Maps : ".$last_url;
                    $result .= "<br>Pemateri : ".$pemateri_kajian;
                    $result .= "<br>Tema : ".$tema_kajian;
                    $result .= "<br>Waktu : ".$waktu_kajian;
                    $result .= "<br>Informasi : ".$informasi_kajian;
                    $result .= "<br><br>";

                    $tempat_kajian = '';
                    $last_url = '';
                    $latitude = '';
                    $longitude = '';
                    $pemateri_kajian = '';
                    $tema_kajian = '';
                    $waktu_kajian = '';
                    $start_sholat_time = '';
                    $end_sholat_time = '';
                    $informasi_kajian = '';

                    $total_gagal++;
                    $is_gagal_item_terakhir = false;
                }
            }

            /* //debug all
            $result .= "<br>".$tempat_kajian;
            $result .= "<br>".$pemateri_kajian;
            $result .= "<br>".$tema_kajian;
            $result .= "<br>".$waktu_kajian;
            $result .= "<br>".$informasi_kajian;
            $result .= "<br>".$latitude;
            $result .= "<br>".$longitude;
            $result .= "<br><br>";
            */

            
            //throw new Exception($result);  

            $result = array(
                'status' => TRUE,
                'message' => "Sukses : ".$total_sukses."<br>Duplikat : ".$total_duplikat."<br>Gagal : ".$total_gagal."<br><br>List gagal : <br>".$result
            );
        } catch (Exception $e) {
            
            $result = array(
                'status' => FALSE,
                'message' => $e->getMessage()
            );
        }
        
        echo json_encode($result);
    }
    
    function update()
    {
        
        /*
        |--------------------------------------------------------------------------
        | Detect Ajax
        |--------------------------------------------------------------------------
        */
        
        if (!$this->input->is_ajax_request()) {
            
            exit('No direct script access allowed');
        }
        
        try {
            
            $validation_rules = array(
                'title' => 'required',
                'tanggal' => 'required|date',
                'starttime' => 'required|valid_time_hhmm',
                'endtime' => 'required|valid_time_hhmm',
                'ustadz_id' => 'required|integer',
                'lokasi_id' => 'required|integer',
                'kajian_id' => 'required|integer'
            );
            
            $filter_rules = array(
                'title' => 'trim|sanitize_string',
                'tanggal' => 'trim|sanitize_string',
                'starttime' => 'trim|sanitize_string',
                'endtime' => 'trim|sanitize_string',
                'startendtime' => 'trim|sanitize_string',
                'ustadz_id' => 'trim|sanitize_string',
                'lokasi_id' => 'trim|sanitize_string',
                'kajian_id' => 'trim|sanitize_string'
            );
            
            $this->lib_gump->execute($validation_rules, $filter_rules);
            
            /*
            |--------------------------------------------------------------------------
            | Set data kajian
            |--------------------------------------------------------------------------
            */
            
            date_default_timezone_set("Asia/Jakarta");
            $this->lib_kajian->setTitle($this->input->post('title'));
            $this->lib_kajian->setTanggal($this->input->post('tanggal'));
            $this->lib_kajian->setUstadzId($this->input->post('ustadz_id'));
            $this->lib_kajian->setLokasiId($this->input->post('lokasi_id'));
            $this->lib_kajian->setId($this->input->post('kajian_id'));
            $this->lib_kajian->setCreatedAt(date("Y-m-d H:i:s"));
            $this->lib_kajian->setUpdatedAt(date("Y-m-d H:i:s"));


            $this->lib_kajian->setInfo($this->input->post('info'));
            
            // convert time meridian
            $starttime = date('H:i:s', strtotime($this->input->post('starttime')));
            $endtime   = date('H:i:s', strtotime($this->input->post('endtime')));
            
            // validate range time
            check_range($starttime, $endtime);
            
            $this->lib_kajian->setStarttime($starttime);
            $this->lib_kajian->setEndtime($endtime);


            $this->lib_kajian->setStartEndtime($this->input->post('startendtime'));

            
            $user_session = $this->session->all_userdata();
            // set status
            $status = $user_session['user_logged_in']['level'] == 'guest editor' ? "need approval" : "approved";
            $this->lib_kajian->setStatus($status);

            
            /*
            |--------------------------------------------------------------------------
            | update data kajian
            |--------------------------------------------------------------------------
            */
            
            $this->lib_kajian->findBy('id');
            $this->lib_kajian->checkPrivilege('admin&user');
            $this->lib_kajian->beforeUpdate();
            $this->lib_kajian->update();

            if($this->lib_kajian->getStatus() == 'need approval'){
                $this->load->helper('message');
                $dataEmail = array("email"=>"ahsai002@gmail.com",
                                    "subject"=>$user_session['user_logged_in']['user_id']." need approval for updating kajian salim",
                                    "message"=>"title : ".$this->lib_kajian->getTitle()."<br>"."tanggal : ".$this->lib_kajian->getTanggal());
                sentEmail($dataEmail);
            }

            $result = array(
                'status' => TRUE,
                'message' => 'Update Kajian'
            );
            
        }
        catch (Exception $e) {
            
            $result = array(
                'status' => FALSE,
                'message' => $e->getMessage()
            );
            
        }
        
        echo json_encode($result);
    }
    
    function delete($id)
    {
        
        // set id lokasi
        $this->lib_kajian->setId($id);
        
        try {
            
            /*
            |--------------------------------------------------------------------------
            | delete data kajian
            |--------------------------------------------------------------------------
            */
            
            $this->lib_kajian->findBy('id');
            $this->lib_kajian->checkPrivilege('admin&user');
            $this->lib_kajian->destroy();
            
            $result = array(
                'status' => TRUE,
                'message' => 'Delete Kajian'
            );
            
        }
        catch (Exception $e) {
            
            $result = array(
                'status' => FALSE,
                'message' => $e->getMessage()
            );
            
        }
        
        echo json_encode($result);
    }
    
}

/* End of file c_kajian.php */
/* Location: ./application/modules/c_kajian/controllers/c_kajian.php */