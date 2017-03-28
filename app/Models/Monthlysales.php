<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class monthlysales extends Sximo  {
	
	protected $table = 'payments';
	protected $primaryKey = '';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " SELECT
 YEAR(paymentDate) AS `year`,
 MONTHNAME(paymentDate) AS `month`,
 FORMAT(SUM(amount), 3) AS `subtotal`,
 count(*) AS totalOrder
FROM payments ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE paymentId IS NOT NULL  ";
	}
	
	public static function queryGroup(){
		return " 
GROUP BY MONTH(paymentDate) ";
	}
	

}
