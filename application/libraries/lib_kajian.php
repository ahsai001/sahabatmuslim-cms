<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lib_kajian
{
    
    private $id;
    private $title;
    private $tanggal;
    private $starttime;
    private $endtime;
    private $startendtime;
    private $status;
    private $ustadz_id;
    private $lokasi_id;
    private $user_id;
    private $created_at;
    private $updated_at;
    private $info;
    
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
     * Gets the value of title.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Sets the value of title.
     *
     * @param mixed $title the title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }
    
    /**
     * Gets the value of tanggal.
     *
     * @return mixed
     */
    public function getTanggal()
    {
        return $this->tanggal;
    }
    
    /**
     * Sets the value of tanggal.
     *
     * @param mixed $tanggal the tanggal
     *
     * @return self
     */
    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;
        
        return $this;
    }
    
    /**
     * Gets the value of starttime.
     *
     * @return mixed
     */
    public function getStarttime()
    {
        return $this->starttime;
    }
    
    /**
     * Sets the value of starttime.
     *
     * @param mixed $starttime the starttime
     *
     * @return self
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
        
        return $this;
    }
    
    /**
     * Gets the value of endtime.
     *
     * @return mixed
     */
    public function getEndtime()
    {
        return $this->endtime;
    }
    
    /**
     * Sets the value of endtime.
     *
     * @param mixed $endtime the endtime
     *
     * @return self
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
        
        return $this;
    }







    /**
     * Gets the value of startendtime.
     *
     * @return mixed
     */
    public function getStartEndtime()
    {
        return $this->startendtime;
    }
    
    /**
     * Sets the value of startendtime.
     *
     * @param mixed $startendtime the startendtime
     *
     * @return self
     */
    public function setStartEndtime($startendtime)
    {
        $this->startendtime = $startendtime;
        
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
     * Gets the value of ustadz_id.
     *
     * @return mixed
     */
    public function getUstadzId()
    {
        return $this->ustadz_id;
    }
    
    /**
     * Sets the value of ustadz_id.
     *
     * @param mixed $ustadz_id the ustadz id
     *
     * @return self
     */
    public function setUstadzId($ustadz_id)
    {
        $this->ustadz_id = $ustadz_id;
        
        return $this;
    }
    
    /**
     * Gets the value of lokasi_id.
     *
     * @return mixed
     */
    public function getLokasiId()
    {
        return $this->lokasi_id;
    }
    
    /**
     * Sets the value of lokasi_id.
     *
     * @param mixed $lokasi_id the lokasi id
     *
     * @return self
     */
    public function setLokasiId($lokasi_id)
    {
        $this->lokasi_id = $lokasi_id;
        
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
     * Gets the value of info.
     *
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }
    
    /**
     * Sets the value of info.
     *
     * @param mixed $info the info
     *
     * @return self
     */
    public function setInfo($info)
    {
        $this->info = $info;
        
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
                $user_id = Kajian::find($this->id)->user_id;
                
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
     * Find data by field
     *
     * @return Response
     */
    public function findBy($field)
    {
        
        switch ($field) {
            
            case 'id':
                
                $kajian = Kajian::find($this->id);
                
                if (count($kajian) < 1) {
                    
                    throw new Exception("Data kajian not found");
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
    
    public function ShowBy($field)
    {
        
        switch ($field) {
            
            case 'id':
                
                return Kajian::where('id', $this->id)->with('lokasi','ustadz', 'user')->first();
                break;
            
            default:
                throw new Exception("Field not found");
                break;
        }
        
    }
    
    /**
     * before store
     *
     * @return Response
     */
    public function beforeStore()
    {
        
        $existDataKajian = Kajian::whereNested(function($query)
        {
            
            //$query->where('title', '=', $this->title);
            $query->where('tanggal', '=', $this->tanggal);
            
            $query->where('starttime', '=', $this->starttime);
            $query->where('endtime', '=', $this->endtime);
            //$query->where('(starttime = '.$this->starttime.' or endtime = '.$this->endtime.')');

            $query->where('ustadz_id', '=', $this->ustadz_id);
            $query->where('lokasi_id', '=', $this->lokasi_id);
        })->first();
        
        if (count($existDataKajian) > 0) {
            
            throw new Exception("Data kajian already exist");
        }
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        
        // save kajian
        
        $kajian             = new Kajian;
        $kajian->title      = $this->title;
        $kajian->tanggal    = $this->tanggal;
        $kajian->starttime  = $this->starttime;
        $kajian->endtime    = $this->endtime;
        $kajian->startendtime    = $this->startendtime;
        $kajian->status     = $this->status;
        $kajian->ustadz_id  = $this->ustadz_id;
        $kajian->lokasi_id  = $this->lokasi_id;
        $kajian->user_id    = $this->user_id;
        $kajian->created_at = $this->created_at;
        $kajian->updated_at = $this->updated_at;
        $kajian->info       = $this->info;
        
        $kajian->save();
    }
    
    /**
     * before update
     *
     * @return Response
     */
    public function beforeUpdate()
    {
        
        $existDataKajian = kajian::whereNested(function($query) {

            //$query->where('title', '=', $this->title);
            $query->where('tanggal', '=', $this->tanggal);
            
            $query->where('starttime', '=', $this->starttime);
            $query->where('endtime', '=', $this->endtime);
            //$query->where('(starttime = '.$this->starttime.' or endtime = '.$this->endtime.')');

            $query->where('ustadz_id', '=', $this->ustadz_id);
            $query->where('lokasi_id', '=', $this->lokasi_id);
        })->whereNotIn('id', [$this->id])->first();
        
        if (count($existDataKajian) > 0) {
            
            throw new Exception("Data kajian already exist");
            
        }
        
    }
    
    /**
     * Update data
     *
     * @return Response
     */
    public function update()
    {
        
        // update kajian
        $kajian             = Kajian::find($this->id);
        $kajian->title      = $this->title;
        $kajian->tanggal    = $this->tanggal;
        $kajian->starttime  = $this->starttime;
        $kajian->endtime    = $this->endtime;
        $kajian->startendtime    = $this->startendtime;
        $kajian->ustadz_id  = $this->ustadz_id;
        $kajian->lokasi_id  = $this->lokasi_id;
        $kajian->updated_at = $this->updated_at;
        $kajian->info       = $this->info;
        
        $kajian->save();
        
    }
    
    /**
     * destroy data
     *
     * @return Response
     */
    public function destroy()
    {
        
        // delete data
        $lokasi = Kajian::find($this->id);
        $lokasi->delete();
    }
}

/* End of file lib_kajian.php */
/* Location: ./application/libraries/lib_kajian.php */