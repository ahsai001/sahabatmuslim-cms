<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Kajian Model
*/
class Kajian extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'kajian';

	/*
	 * Relasi One-to-Many
	 * =================
	 * model 'Kajian' memiliki relasi One-to-Many (belongsTo) sebagai penerima 'ustadz_id'
	 */
	public function ustadz() {
		return $this->belongsTo('Ustadz', 'ustadz_id');
	}

	/*
	 * Relasi One-to-Many
	 * =================
	 * model 'Kajian' memiliki relasi One-to-Many (belongsTo) sebagai penerima 'lokasi_id'
	 */
	public function lokasi() {
		return $this->belongsTo('Lokasi', 'lokasi_id');
	}

	/*
	 * Relasi One-to-Many
	 * =================
	 * model 'Kajian' memiliki relasi One-to-Many (belongsTo) sebagai penerima 'user_id'
	 */
	public function user() {
		return $this->belongsTo('User', 'user_id');
	}

}

/* End of file Kajian.php */
/* Location: ./application/models/Kajian.php */