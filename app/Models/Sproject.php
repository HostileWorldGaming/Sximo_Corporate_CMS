<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class sproject extends Sximo  {
	
	protected $table = 'sb_projects';
	protected $primaryKey = 'ProjectID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " 
			 SELECT sb_projects.* ,
				COUNT(sb_tasks.TaskID) AS 'Tasks'
			 
			 FROM sb_projects 
			 LEFT JOIN sb_tasks ON sb_tasks.ProjectID = sb_projects.ProjectID
 
		  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE sb_projects.ProjectID IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  GROUP BY sb_projects.ProjectID ";
	}
	
	public static function projectSummary()
	{
		$sql = "SELECT 

			SUM(CASE WHEN sb_projects.Status ='open' THEN 1 ELSE 0 END ) AS 'Opened',
			SUM(CASE WHEN sb_projects.Status ='close' THEN 1 ELSE 0 END ) AS 'Closed',
			SUM(CASE WHEN sb_projects.Status ='suspend' THEN 1 ELSE 0 END ) AS 'Suspended',
			SUM(CASE WHEN sb_projects.Status ='cancel' THEN 1 ELSE 0 END ) AS 'Canceled',
			COUNT(sb_projects.ProjectID) AS 'Total'
		FROM sb_projects";

		$sql = \DB::select($sql);
		return $sql[0];

	}


}
