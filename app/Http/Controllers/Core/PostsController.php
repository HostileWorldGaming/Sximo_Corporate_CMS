<?php namespace App\Http\Controllers\Core;

use App\Http\Controllers\controller;
use App\Models\Core\Posts;
use App\Models\Core\Groups;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class PostsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'posts';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Posts();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'core/posts',
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

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'created'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'desc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = ' AND pagetype="post" ';	
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
		$pagination->setPath('posts');
		
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

		// Get Post Config
		$this->data['conpost'] = json_decode(file_get_contents(base_path().'/resources/views/core/posts/config.json'),true);
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('core.posts.index',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('tb_pages'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;

		if($this->data['row']['access'] !='')
		{
			$access = json_decode($this->data['row']['access'],true)	;	
		} else {
			$access = array();
		}


		$groups = Groups::all();
		$group = array();
		foreach($groups as $g) {
			$group_id = $g['group_id'];			
			$a = (isset($access[$group_id]) && $access[$group_id] ==1 ? 1 : 0);		
			$group[] = array('id'=>$g->group_id ,'name'=>$g->name,'access'=> $a); 			
		}	


		$this->data['groups'] = $group;	

		return view('core.posts.form',$this->data);
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
			$this->data['prevnext'] = $this->model->prevNext($id);
			return view('core.posts.view',$this->data);
		} else {
			return Redirect::to('posts')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			 $data = $this->validatePost('tb_posts');
			 $groups = Groups::all();
			 $access = array();				
			 foreach($groups as $group) {		 	
				$access[$group->group_id]	= (isset($_POST['group_id'][$group->group_id]) ? '1' : '0');
			 }
		 						
			$data['access'] = json_encode($access);
						
			if($request->input('pageID') =='') {
				 $data['created'] = date('Y-m-d H:i:s');
				 $data['userid']	= \Session::get('uid');
			} else {
				 $data['updated'] = date('Y-m-d H:i:s');	
			}	

			if($request->input('alias') =='')
				$data['alias'] = \SiteHelpers::seourl($data['title']);


			$data['allow_guest'] = $request->input('allow_guest');	
			$id = $this->model->insertRow($data , $request->input('pageID'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'core/posts/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'core/posts?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('pageID') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('core/posts/update/'.$request->input('pageID'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('core/posts?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('core/posts?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Posts();
		$info = $model::makeInfo('posts');

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
				return view('core.posts.public.view',$data);
			} 

		} else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> 'pageID' ,
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
			return view('core.posts.public.index',$data);			
		}


	}

	function postSavepublic( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_pages');		
			 $this->model->insertRow($data , $request->input('pageID'));
			return  Redirect::back()->with('messagetext','<p class="alert alert-success">'.\Lang::get('core.note_success').'</p>')->with('msgstatus','success');
		} else {

			return  Redirect::back()->with('messagetext','<p class="alert alert-danger">'.\Lang::get('core.note_error').'</p>')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	
	
	}	


	public function getList( Request $request)
	{

		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$params = array(
			'page'		=> $page ,
			'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
			'sort'		=> 'pageID' ,
			'order'		=> 'asc',
			'params'	=> " AND pagetype ='post'  " ,
			'global'	=> 1 
		);		
		return self::articles( $params , $page , 'all' );

	}

	public function getLabel( Request $request , $label )
	{

		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$params = array(
			'page'		=> $page ,
			'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
			'sort'		=> 'pageID' ,
			'order'		=> 'asc',
			'params'	=> " AND pagetype ='post' AND labels REGEXP '". $label."' " ,
			'global'	=> 1 
		);		
		return self::articles( $params , $page , $label );

	}


	public static function articles($params , $page , $title = 'all')
	{

		$model  = new Posts();
		$info = $model::makeInfo('posts');



		$data['pageLang'] = 'en';
		if(\Session::get('lang') != '')
		{
			$data['pageLang'] = \Session::get('lang');
		}		




		$result = $model::getRows( $params );
		$data['rowData'] 	= $result['rows'];	

		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($result['rows'], $result['total'], $params['limit']);	
		$pagination->setPath('');
		$data['i']			= ($page * $params['limit'])- $params['limit']; 
		$data['pagination'] = $pagination;

		if($title !='all')
		{
			$data['pageTitle'] 	= 'Label :  '.$title;
				
		} else {
			$data['pageTitle'] 	= 'Posts ';
		}

		
		$data['pageNote'] 	=  'View All';
		$data['breadcrumb'] 	= 'false';	
		$data['pageMetakey'] 	=  '' ;
		$data['pageMetadesc'] =  '' ;
		$data['filename'] 	=  '';	


		$page = 'layouts.'.CNF_THEME.'.index';
		$data['pages'] = 'posts.public.index';
		return view($page,$data);			
	

	}


	function getView( Request $request , $id )
	{
					
		$row = $this->model->getRow($id);
		if($row)
		{

			$data['pageLang'] = 'en';
			if(\Session::get('lang') != '')
			{
				$data['pageLang'] = \Session::get('lang');
			}			

			$data['pageTitle'] 		= 	$row->title ;
			$data['pageNote'] 		=  	'View All';
			$data['breadcrumb'] 	= 	'inactive';	
			$data['pageMetakey'] 	=  	$row->metakey;
			$data['pageMetadesc'] 	=  	$row->metadesc ;
			$data['filename'] 		=  	'';	

			$data['row'] =  $row;
			$data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['grid']);
			$data['id'] = $id;
			$data['access']		= $this->access; 
			$data['prevnext'] = $this->model->prevNext($id);
			$data['labels']	= self::splitLabels($row->labels);
			$page = 'layouts.'.CNF_THEME.'.index';
			$data['pages'] = 'posts.public.view';

			return view($page,$data);
		} else {
			return Redirect::to('posts')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}

	public static function splitLabels($value='')
	{
		$value = explode(',',$value);
		$vals = '';
		foreach($value as $val)
		{
			$vals .= '<a href="'.url('posts/label/'.trim($val)).'" class="btn btn-xs btn-default"> '.trim($val).' </a> ';
		}
		return $vals;
	}

	public static function cloudtags()
	{
		$cloud = '';	
		$data = \DB::table('pages')->where('pagetype','post')->get();
		foreach($data as $row)
		{
			$clouds = explode(',',$row->labels);
			foreach($clouds as $cld)
			{
				$cloud .= trim($cld);
			}

		}
	}

	function postConfig( Request $request)
	{
		$data = array(
			"commsys"		=> ($request->commsys ? 1 : 0 ) ,
			"commimage"		=> ($request->commimage ? 1 : 0 ) ,
			"commlatest"	=> ($request->commlatest ? 1 : 0 ) ,
			"commpopular"	=> ($request->commpopular ? 1 : 0 ) ,
			"commshare"		=> ($request->commshare ? 1 : 0 ) ,
			"commshareapi"	=> trim($request->commshareapi) ,
			"commperpage"	=> trim($request->commperpage) ,
		);

		$data = json_encode($data);
		$filename = base_path().'/resources/views/core/posts/config.json';
		$fp=fopen($filename,"w+"); 				
		fwrite($fp,$data); 
		fclose($fp);

		return Redirect::to('core/posts')
        		->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus','success');		

	}

	public function getSearch( $mode = 'native')
	{

		$this->data['tableForm'] 	= $this->info['config']['forms'];	
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['searchMode'] = 'native';
		$this->data['pageUrl']		= url('core/posts');
		return view('sximo.module.utility.search',$this->data);
	
	}	

}