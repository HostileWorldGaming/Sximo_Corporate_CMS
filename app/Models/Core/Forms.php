<?php namespace App\Models\Core;

use App\Models\Sximo;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Forms extends Sximo  {
	
	protected $table = 'tb_forms';
	protected $primaryKey = 'formID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_forms.* FROM tb_forms  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_forms.formID IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
