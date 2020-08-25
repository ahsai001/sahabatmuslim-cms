<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lib_ustadz
{
    
    private $id;
    private $name;
    private $email;
    private $phone;
    private $address;
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
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
    }
    
    /**
     * Gets the value of phone.
     *
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * Sets the value of phone.
     *
     * @param mixed $phone the phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        
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
                $id_user = Ustadz::find($this->id)->user_id;
                
                if (!($user_session['user_logged_in']['level'] == 'admin' || $user_session['user_logged_in']['user_id'] == $id_user)) {
                    
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
                
                $ustadz = Ustadz::find($this->id);
                
                if (count($ustadz) < 1) {
                    
                    throw new Exception("Data not found");
                }
                break;
            
            case 'name':
                
                $ustadz = Ustadz::where('name', $this->name)->count();
                
                if ($ustadz < 1) {
                    
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
                
                return Ustadz::where('id', $this->id)->first(array(
                    'id',
                    'name',
                    'email',
                    'address',
                    'phone',
                    'user_id'
                ));
                break;
            
            case 'name':
                
                return Ustadz::where('name', $this->name)->first(array(
                    'id',
                    'name',
                    'email',
                    'address',
                    'phone',
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
        
        $existEmailOrPhone = Ustadz::where('email', '=', $this->email)->orWhere('phone', '=', $this->phone)->count();
        
        if ($existEmailOrPhone > 0) {
            
            //throw new Exception("Email or phone already exist");
        }
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    
    public function store()
    {
        
        // save ustadz
        
        $ustadz             = new Ustadz;
        $ustadz->name       = $this->name;
        $ustadz->email      = $this->email;
        $ustadz->phone      = $this->phone;
        $ustadz->address    = $this->address;
        $ustadz->status     = $this->status;
        $ustadz->user_id    = $this->user_id;
        $ustadz->created_at = $this->created_at;
        $ustadz->updated_at = $this->updated_at;
        
        $ustadz->save();
        
    }
    
    
    /**
     * Check exist data before update
     *
     * @return Response
     */
    
    public function beforeUpdate()
    {
        
        // check email or phone exist
        $existEmail = Ustadz::where('email', '=', $this->email)->whereNotIn('id', [$this->id])->count();
        $existPhone = Ustadz::where('phone', '=', $this->phone)->whereNotIn('id', [$this->id])->count();
        
        if ($existEmail > 0 || $existPhone > 0) {
            
            //throw new Exception("Email or phone already exist");
            
        }
        
    }
    
    /**
     * Update data
     *
     * @return Response
     */
    
    public function update()
    {
        
        // update data
        $ustadz             = Ustadz::find($this->id);
        $ustadz->name       = $this->name;
        $ustadz->email      = $this->email;
        $ustadz->phone      = $this->phone;
        $ustadz->address    = $this->address;
        $ustadz->updated_at = $this->updated_at;
        
        $ustadz->save();
        
    }
    
    /**
     * destroy data
     *
     * @return Response
     */
    public function destroy()
    {
        
        // delete data
        $ustadz = Ustadz::find($this->id);
        $ustadz->delete();
    }
    
}

/* End of file lib_ustadz.php */
/* Location: ./application/libraries/lib_ustadz.php */