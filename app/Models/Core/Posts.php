<?php namespace App\Models\Core;

use App\Models\Sximo;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class posts extends Sximo  {
	
	protected $table = 'tb_pages';
	protected $primaryKey = 'pageID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  
		 SELECT tb_pages.* , COUNT(commentID) AS comments FROM tb_pages 
		 LEFT JOIN tb_comments ON tb_comments.pageID = tb_pages.pageID
		";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_pages.pageID IS NOT NULL AND pagetype = 'post' ";
	}
	
	public static function queryGroup(){
		return " GROUP BY tb_pages.pageID ";
	}
	

}
