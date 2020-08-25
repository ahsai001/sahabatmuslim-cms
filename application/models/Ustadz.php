<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Ustadz Model
*/
class Ustadz extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'ustadz';

	/*
	 * Relasi One-to-Many
	 * ================= 
	 * model 'Ustadz' memiliki relasi One-to-Many (belongsTo) sebagai penerima 'user_id'
	 */
	public function user() {
		return $this->belongsTo('User', 'user_id');
	}
	
}

/* End of file Ustadz.php */
/* Location: ./application/models/Ustadz.php */