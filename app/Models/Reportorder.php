<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class reportorder extends Sximo  {
	
	protected $table = 'orders';
	protected $primaryKey = '';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " select 
	year(orders.orderDate) as 'Year',
    sum(if((month(orders.orderDate) = '01'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Jan',
    sum(if((month(orders.orderDate) = '02'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Feb',
    sum(if((month(orders.orderDate) = '03'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Mar',
    sum(if((month(orders.orderDate) = '04'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Apr',
    sum(if((month(orders.orderDate) = '05'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'May',
    sum(if((month(orders.orderDate) = '05'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Jun',
    sum(if((month(orders.orderDate) = '07'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Jul',
    sum(if((month(orders.orderDate) = '08'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Aug',
    sum(if((month(orders.orderDate) = '09'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Sep',
    sum(if((month(orders.orderDate) = '10'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Oct',
    sum(if((month(orders.orderDate) = '11'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Nov',
    sum(if((month(orders.orderDate) = '12'), (orderdetails.priceEach * orderdetails.quantityOrdered),0)) as 'Dec'
    
from orders
left join orderdetails on orderdetails.orderNumber = orders.orderNumber ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE orders.orderNumber IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return " group by year(orders.orderDate) ";
	}
	

}
