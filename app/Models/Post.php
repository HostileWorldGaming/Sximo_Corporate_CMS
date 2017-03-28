<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class post extends Sximo  {
	
	protected $table = 'tb_pages';
	protected $primaryKey = 'pageID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " 
SELECT 
	tb_pages.* , COUNT(commentID) AS comments , username
FROM tb_pages 
LEFT JOIN tb_comments ON tb_comments.pageID = tb_pages.pageID
LEFT JOIN tb_users ON tb_users.id = tb_pages.userid
		  ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE tb_pages.pageID IS NOT NULL AND pagetype = 'post'";
	}
	
	public static function queryGroup(){
		return " GROUP BY tb_pages.pageID ";
	}
	

	public static function comments( $pageID)
	{
		$sql = \DB::select("
			SELECT tb_comments.* ,username , avatar , email
			FROM tb_comments LEFT JOIN tb_users ON tb_users.id = tb_comments.userid
			WHERE pageID ='".$pageID."'
			");
		return $sql;
	}


	public static function latestposts( )
	{
		$sql = \DB::select("
			SELECT * FROM tb_pages WHERE pagetype ='post' ORDER BY created DESC LIMIT 5
			");
		return $sql;
	}
}
