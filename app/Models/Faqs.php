<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class faqs extends Sximo  {
	
	protected $table = 'faq';
	protected $primaryKey = 'faqID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT faq.* FROM faq  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE faq.faqID IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
