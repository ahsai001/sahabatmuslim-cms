<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Kajian oto Model
*/
class Kajian_oto extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_ustadz_id($name, $email, $phone, $address, $status, $user_id){
        //pre process $name
        $name = preg_replace('!\s+!', ' ', $name);
        $name = str_replace("’", "'", $name);
        $name = str_replace('"', "'", $name);
        $name = str_replace("“", "'", $name);
        $name = str_replace("”", "'", $name);

        //query
        $query = $this->db->query('select id from ustadz where name = "'.$name.'"');
        if($query->num_rows() > 0){
            $data_ustadz = $query->row_array();
            return $data_ustadz['id'];
        }
        //$this->db->reset_query();
        //insert
        $data = array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'status' => $status,
                'user_id' => $user_id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
        );

        $this->db->insert('ustadz', $data);
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
    }

    public function get_lokasi_id($latitude, $longitude, $place_in_maps, $place, $address, $status, $user_id){
        $query = $this->db->query("select id from lokasi where latitude=".$latitude." and longitude=".$longitude."");
        if($query->num_rows() > 0){
            $data_lokasi = $query->row_array();
            return $data_lokasi['id'];
        }
        //$this->db->reset_query();
        //insert
        $data = array(
                'place' => $place,
                'address' => empty($address)?'':$address,
                'place_in_maps' => $place_in_maps,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'status' => $status,
                'user_id' => $user_id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
        );
    
        $this->db->insert('lokasi', $data);
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
    }

    public function get_lokasi_id_by_url($url){
        $query = $this->db->query('select id from lokasi where url = "'.$url.'"');
        if($query->num_rows() > 0){
            $data_lokasi = $query->row_array();
            return $data_lokasi['id'];
        }
        return false;
    }

    public function update_url_lokasi($url, $id){
        $this->db->update('lokasi', array('url' => $url), array('id' => $id));
        return $this->db->affected_rows() > 0;
    }

}

/* End of file Kajian.php */
/* Location: ./application/models/Kajian.php */