<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lib_user
{
    
    private $id;
    private $username;
    private $password;
    private $level;
    private $created_at;
    private $updated_at;
    
    protected $ci;
    
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
     * Gets the value of username.
     *
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * Sets the value of username.
     *
     * @param mixed $username the username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        
        return $this;
    }
    
    /**
     * Gets the value of password.
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Sets the value of password.
     *
     * @param mixed $password the password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * Gets the value of level.
     *
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * Sets the value of level.
     *
     * @param mixed $level the level
     *
     * @return self
     */
    public function setLevel($level)
    {
        $this->level = $level;
        
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
                
                $user = User::find($this->id);
                
                if (count($user) < 1) {
                    
                    throw new Exception("Data not found");
                }
                break;
            
            case 'username':
                
                $user = User::where('username', $this->username)->count();
                
                if ($user < 1) {
                    
                    throw new Exception("Username not found");
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
                
                return User::where('id', $this->id)->first(array(
                    'id',
                    'username',
                    'password',
                    'level'
                ));
                break;
            
            case 'username':
                
                return User::where('username', $this->username)->first(array(
                    'id',
                    'username',
                    'password',
                    'level'
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
        
        $existUsername = User::where('username', '=', $this->username)->count();
        
        if ($existUsername > 0) {
            
            throw new Exception("Username already exist");
            
        }
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    
    public function store()
    {
        
        // save user
        
        $user             = new User;
        $user->username   = $this->username;
        $user->password   = $this->password;
        $user->level      = $this->level;
        $user->created_at = $this->created_at;
        $user->updated_at = $this->updated_at;
        
        $user->save();
        
    }
    
    /**
     * Check exist data before update
     *
     * @return Response
     */
    
    public function beforeUpdate()
    {
        
         // check username exist
        $existUsername = User::where('username', '=', $this->username)->whereNotIn('id', [$this->id])->count();
        
        if ($existUsername > 0) {
            
            throw new Exception("Username already exist");
            
        }
        
    }
    
    /**
     * Update data
     *
     * @return Response
     */
    
    public function update($rule)
    {
        
        switch ($rule) {
            
            case 'with_password':
                
                // update data
                $user             = User::find($this->id);
                $user->username   = $this->username;
                $user->password   = $this->password;
                $user->level      = $this->level;
                $user->updated_at = $this->updated_at;
                
                $user->save();
                
                break;
            
            case 'without_password':
                
                // update data
                $user             = User::find($this->id);
                $user->username   = $this->username;
                $user->level      = $this->level;
                $user->updated_at = $this->updated_at;
                
                $user->save();
                
                break;
            
            default:
                throw new Exception("Rule not found");
                break;
        }
        
    }

    /**
     * destroy data
     *
     * @return Response
     */
    public function destroy()
    {
        
        // delete data
        $ustadz = User::find($this->id);
        $ustadz->delete();
    }
    
}

/* End of file lib_user.php */
/* Location: ./application/libraries/lib_user.php */