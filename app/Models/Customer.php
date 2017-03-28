<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class customer extends Sximo  {
	
	protected $table = 'customers';
	protected $primaryKey = 'customerNumber';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT customers.* FROM customers  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE customers.customerNumber IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
