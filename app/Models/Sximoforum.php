<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class sximoforum extends Sximo  {
	
	protected $table = 'forums';
	protected $primaryKey = 'ForumID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT forums.* FROM forums  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE forums.ForumID IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}


	public static function licences( $id){
		$sql = "  
			SELECT 
				licences.* ,ItemName
				
			FROM licences 
			LEFT JOIN items ON items.ItemID = licences.itemid
			WHERE userid ='$id'

		";
		$data = array();
		foreach(\DB::select($sql) as $row )
		{
			$data[] = $row->ItemName;
		}
		return implode(',',$data);
	}

	public static function theard( $ForumID)
	{
		$result = "
		SELECT forum_categories.* ,  count(forum_posts.PostID) as Posts , count(forum_comments.CommentID) as Comments 
			FROM `forum_categories`
		left join forum_posts on forum_posts.CategoryID = forum_categories.CategoryID
		left join forum_comments on forum_comments.PostID = forum_posts.PostID

		WHERE forum_categories.ForumID = '".$ForumID."'
		GROUP BY forum_categories.CategoryID";
		$result = \DB::select($result);
		return $result;


	}
	

}
