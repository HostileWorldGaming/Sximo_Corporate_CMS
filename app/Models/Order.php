<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class order extends Sximo  {
	
	protected $table = 'orders';
	protected $primaryKey = 'orderNumber';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT orders.* FROM orders  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE orders.orderNumber IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
