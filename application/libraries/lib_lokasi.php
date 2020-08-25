<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lib_lokasi
{
    
    private $id;
    private $place;
    private $place_in_maps;
    private $address;
    private $latitude;
    private $longitude;
    private $status;
    private $user_id;
    private $created_at;
    private $updated_at;
    
    
    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * Gets the value of place.
     *
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }
    
    /**
     * Sets the value of place.
     *
     * @param mixed $place the place
     *
     * @return self
     */
    public function setPlace($place)
    {
        $this->place = $place;
        
        return $this;
    }




    /**
     * Gets the value of place.
     *
     * @return mixed
     */
    public function getPlaceInMaps()
    {
        return $this->place_in_maps;
    }
    
    /**
     * Sets the value of place.
     *
     * @param mixed $place the place
     *
     * @return self
     */
    public function setPlaceInMaps($place_in_maps)
    {
        $this->place_in_maps = $place_in_maps;
        
        return $this;
    }
    
    /**
     * Gets the value of address.
     *
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Sets the value of address.
     *
     * @param mixed $address the address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;
        
        return $this;
    }
    
    /**
     * Gets the value of latitude.
     *
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    /**
     * Sets the value of latitude.
     *
     * @param mixed $latitude the latitude
     *
     * @return self
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        
        return $this;
    }
    
    /**
     * Gets the value of longitude.
     *
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    /**
     * Sets the value of longitude.
     *
     * @param mixed $longitude the longitude
     *
     * @return self
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        
        return $this;
    }
    
    /**
     * Gets the value of status.
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Sets the value of status.
     *
     * @param mixed $status the status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }
    
    /**
     * Gets the value of user_id.
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }
    
    /**
     * Sets the value of user_id.
     *
     * @param mixed $user_id the user id
     *
     * @return self
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        
        return $this;
    }
    
    /**
     * Gets the value of created_at.
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    /**
     * Sets the value of created_at.
     *
     * @param mixed $created_at the created at
     *
     * @return self
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        
        return $this;
    }
    
    /**
     * Gets the value of updated_at.
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    
    /**
     * Sets the value of updated_at.
     *
     * @param mixed $updated_at the updated at
     *
     * @return self
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        
        return $this;
    }
    
    /**
     * Check privilege before access something
     *
     * @return Response
     */
    
    public function checkPrivilege($rule)
    {
        
        $this->ci =& get_instance();
        
        // get user session
        $user_session = $this->ci->session->all_userdata();
        
        switch ($rule) {
            
            case 'admin':
                
                if ($user_session['user_logged_in']['level'] != 'admin') {
                    
                    throw new Exception("You can not run this process");
                }
                
                break;
            
            case 'admin&user':
                
                // user_id
                $user_id = Lokasi::find($this->id)->user_id;
                
                if (!($user_session['user_logged_in']['level'] == 'admin' || $user_session['user_logged_in']['user_id'] == $user_id)) {
                    
                    throw new Exception("You can not run this process");
                }
                
                break;
            
            default:
                throw new Exception("Rule not found");
                break;
        }
        
    }
    
    /**
     * Find By field
     *
     * @return Response
     */
    
    public function findBy($field)
    {
        
        switch ($field) {
            
            case 'id':
                
                $lokasi = Lokasi::find($this->id);
                
                if (count($lokasi) < 1) {
                    
                    throw new Exception("Data not found");
                }
                break;
            
            default:
                throw new Exception("Field not found");
                break;
        }
        
    }
    
    /**
     * Show By field
     *
     * @return Response
     */
    
    public function showBy($field)
    {
        
        switch ($field) {
            
            case 'id':
                
                return Lokasi::where('id', $this->id)->first(array(
                    'id',
                    'place',
                    'place_in_maps',
                    'address',
                    'latitude',
                    'longitude',
                    'user_id'
                ));
                break;
            
            default:
                throw new Exception("Field not found");
                break;
        }
        
    }
    
    /**
     * Before store
     *
     * @return Response
     */
    
    public function beforeStore()
    {
        
        $existDataLokasi = Lokasi::whereNested(function($query)
        {
            
            $query->where('place', '=', $this->place);
            $query->where('address', '=', $this->address);
            $query->where('latitude', '=', $this->latitude);
            $query->where('longitude', '=', $this->longitude);
        })->first();
        
        if (count($existDataLokasi) > 0) {
            
            throw new Exception("Data lokasi already exist");
        }
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        
        // save lokasi
        
        $lokasi             = new Lokasi;
        $lokasi->place      = $this->place;
        $lokasi->place_in_maps      = $this->place_in_maps;
        $lokasi->address    = $this->address;
        $lokasi->latitude   = $this->latitude;
        $lokasi->longitude  = $this->longitude;
        $lokasi->status     = $this->status;
        $lokasi->user_id    = $this->user_id;
        $lokasi->created_at = $this->created_at;
        $lokasi->updated_at = $this->updated_at;
        
        $lokasi->save();
        
    }
    
    /**
     * Check exist data before update
     *
     * @return Response
     */
    
    public function beforeUpdate()
    {
        
        $existDataLokasi = Lokasi::whereNested(function($query) {

            $query->where('place', '=', $this->place);
            $query->where('address', '=', $this->address);
            $query->where('latitude', '=', $this->latitude);
            $query->where('longitude', '=', $this->longitude);
        })->whereNotIn('id', [$this->id])->first();

        $existDataCoordinate = Lokasi::whereNested(function($query) {

            $query->where('latitude', '=', $this->latitude);
            $query->where('longitude', '=', $this->longitude);
        })->whereNotIn('id', [$this->id])->first();
        
        if (count($existDataLokasi) > 0 || count($existDataCoordinate) > 0) {
            
            throw new Exception("Data lokasi already exist");
        }
        
    }
    
    /**
     * Update data
     *
     * @return Response
     */
    
    public function update()
    {
        
        // update lokasi
        $lokasi             = Lokasi::find($this->id);
        $lokasi->place      = $this->place;
        $lokasi->place_in_maps      = $this->place_in_maps;
        $lokasi->address    = $this->address;
        $lokasi->latitude   = $this->latitude;
        $lokasi->longitude  = $this->longitude;
        $lokasi->updated_at = $this->updated_at;
        
        $lokasi->save();
        
    }
    
    /**
     * destroy data
     *
     * @return Response
     */
    public function destroy()
    {
        
        // delete data
        $lokasi = Lokasi::find($this->id);
        $lokasi->delete();
    }
    
}

/* End of file lib_lokasi.php */
/* Location: ./application/libraries/lib_lokasi.php */