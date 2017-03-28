<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class employee extends Sximo  {
	
	protected $table = 'employees';
	protected $primaryKey = 'employeeNumber';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT employees.* FROM employees  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE employees.employeeNumber IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
