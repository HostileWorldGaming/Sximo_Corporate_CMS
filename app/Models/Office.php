<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class office extends Sximo  {
	
	protected $table = 'offices';
	protected $primaryKey = 'officeCode';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT offices.* FROM offices  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE offices.officeCode IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
