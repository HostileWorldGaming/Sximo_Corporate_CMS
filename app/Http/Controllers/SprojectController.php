<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Sproject;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class SprojectController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'sproject';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Sproject();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'sproject',
			'return'	=> self::returnUrl()
			
		);
		
		\App::setLocale(CNF_LANG);
		if (defined('CNF_MULTILANG') && CNF_MULTILANG == '1') {

		$lang = (\Session::get('lang') != "" ? \Session::get('lang') : CNF_LANG);
		\App::setLocale($lang);
		}  


		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'ProjectID'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = '';	
		if(!is_null($request->input('search')))
		{
			$search = 	$this->buildSearch('maps');
			$filter = $search['param'];
			$this->data['search_map'] = $search['maps'];
		} 

		
		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results = $this->model->getRows( $params );		
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		$pagination->setPath('sproject');
		
		$this->data['rowData']		= $results['rows'];
		// Build Pagination 
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();	
		// Row grid Number 
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// Grid Configuration 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];	
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		$this->data['pS'] = $this->model->projectSummary();
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('sproject.index',$this->data);
	}	



	function getUpdate(Request $request, $id = null)
	{
	
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}				
				
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('sb_projects'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('sproject.form',$this->data);
	}	

	public function getShow( Request $request, $id = null)
	{

		if($this->access['is_detail'] ==0) 
		return Redirect::to('dashboard')
			->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
					
		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['grid']);
			$this->data['id'] = $id;
			$this->data['access']		= $this->access;
			$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
			return view('sproject.view',$this->data);
		} else {
			return Redirect::to('sproject')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_sproject');
				
			$id = $this->model->insertRow($data , $request->input('ProjectID'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'sproject/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'sproject?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('ProjectID') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('sproject/update/'.$request->input('ProjectID'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
	}	

	public function postDelete( Request $request)
	{
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows 
		if(count($request->input('ids')) >=1)
		{
			$this->model->destroy($request->input('ids'));
			
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('ids'))."  , Has Been Removed Successfull");
			// redirect
			return Redirect::to('sproject')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('sproject')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Sproject();
		$info = $model::makeInfo('sproject');

		$data = array(
			'pageTitle'	=> 	$info['title'],
			'pageNote'	=>  $info['note']
			
		);

		if($mode == 'view')
		{
			$id = $_GET['view'];
			$row = $model::getRow($id);
			if($row)
			{
				$data['row'] =  $row;
				$data['fields'] 		=  \SiteHelpers::fieldLang($info['config']['grid']);
				$data['id'] = $id;
				return view('sproject.public.view',$data);
			} 

		} else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> 'ProjectID' ,
				'order'		=> 'asc',
				'params'	=> '',
				'global'	=> 1 
			);

			$result = $model::getRows( $params );
			$data['tableGrid'] 	= $info['config']['grid'];
			$data['rowData'] 	= $result['rows'];	

			$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
			$pagination = new Paginator($result['rows'], $result['total'], $params['limit']);	
			$pagination->setPath('');
			$data['i']			= ($page * $params['limit'])- $params['limit']; 
			$data['pagination'] = $pagination;
			return view('sproject.public.index',$data);			
		}


	}

	function postSavepublic( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('sb_projects');		
			 $this->model->insertRow($data , $request->input('ProjectID'));
			return  Redirect::back()->with('messagetext','<p class="alert alert-success">'.\Lang::get('core.note_success').'</p>')->with('msgstatus','success');
		} else {

			return  Redirect::back()->with('messagetext','<p class="alert alert-danger">'.\Lang::get('core.note_error').'</p>')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	
	
	}	

	static public function showTeam( $val = '')
	{

		$value='';
		if($val !='')
		{
			$sql = \DB::table('tb_users')->whereIn('id',explode(',',$val))->get();
			foreach ($sql as $v) {
				$avatar = '<img alt="" src="http://www.gravatar.com/avatar/'.md5($v->email).'" class="img-circle tips" width="30" title="'. $v->first_name .' '.$v->last_name .'"/> ';
				$files =  './uploads/users/'.$v->avatar ;
				if($v->avatar !='' ) 	
				{
					if( file_exists($files))
					{
						$avatar = '<img src="'.asset('uploads/users').'/'.$v->avatar.'" border="0" width="30" class="img-circle tips" title="'. $v->first_name .' '.$v->last_name .'" /> ';
					} 
				} 

				$value .= $avatar;
			}		
		}

		return $value;
	}	

	static public function Status( $Status)
	{

		if($Status =='open'):
			return '<span class="label label-primary"> Opened </span>';
		elseif($Status =='close'):
			return '<span class="label label-success"> Closed </span>';
		elseif($Status =='suspend'):
			return '<span class="label label-warning"> Suspended </span>';
		else:
			return '<span class="label label-danger"> Canceled </span>';
		endif;

	}			


}