<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class product extends Sximo  {
	
	protected $table = 'products';
	protected $primaryKey = 'productCode';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT products.* FROM products  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE products.productCode IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
