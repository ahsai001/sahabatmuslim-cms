<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Lokasi Model
*/
class Lokasi extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'lokasi';

	/*
	 * Relasi One-to-Many
	 * ================= 
	 * model 'Lokasi' memiliki relasi One-to-Many (belongsTo) sebagai penerima 'user_id'
	 */
	public function user() {
		return $this->belongsTo('User', 'user_id');
	}

}

/* End of file Lokasi.php */
/* Location: ./application/models/Lokasi.php */