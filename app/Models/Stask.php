<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class stask extends Sximo  {
	
	protected $table = 'sb_tasks';
	protected $primaryKey = 'TaskID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT sb_tasks.* FROM sb_tasks  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE sb_tasks.TaskID IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
