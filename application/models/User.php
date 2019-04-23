<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* User Model
*/
class User extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'user';

	/*
	 * Relasi One-to-Many
	 * ==================
	 * model 'User' akan memiliki relasi One-to-Many terhadap model 'Ustadz' sebagai 'user_id'
	 */
	public function ustadz() {
		return $this->hasMany('Ustadz', 'user_id');
	}

	/*
	 * Relasi One-to-Many
	 * ==================
	 * model 'User' akan memiliki relasi One-to-Many terhadap model 'Lokasi' sebagai 'user_id'
	 */
	public function lokasi() {
		return $this->hasMany('Lokasi', 'user_id');
	}


}

/* End of file User.php */
/* Location: ./application/models/User.php */