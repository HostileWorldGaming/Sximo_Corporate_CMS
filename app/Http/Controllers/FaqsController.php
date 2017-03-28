<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Faqs;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class FaqsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'faqs';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Faqs();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'faqs',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'faqID'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
		if(\Session::get('gid') != '')
		{
			$filter .= " AND status = '1' ";
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
		$pagination->setPath('faqs');
		
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
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('faqs.index',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('faq'); 
		}


		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('faqs.form',$this->data);
	}	

	public function getShow(  Request $request, $id = null)
	{
	
		if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
					
		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('faq'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['grid']);
		
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		
		$faqsection 		=  \DB::table('faqsection')->where('faqID',$id)->orderBy('orderID','ASC')->get();

		$faqTree = array();
		$first = 0;
		foreach($faqsection as $fs)
		{
			$items = \DB::table('faqitems')->where('sectionID',$fs->sectionID)->orderBy('ordering','asc')->get();
			$faqTree[] = array(
				'sectionID'	=> $fs->sectionID ,
				'title'	=> $fs->title ,
				'items'		=> $items
			);	
			if($first == 0) {
				$this->data['items'] = $items;	
			}
			++$first;
		}
		$this->data['faqTree']  = $faqTree;	

		if(!is_null($request->input('view')))
		{
			$this->data['items'] = \DB::table('faqitems')->where('id',$request->input('view'))->get();	
		} else {
			$this->data['items'] = array();
		}


		return view('faqs.view',$this->data);	
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_faqs');
				
			$id = $this->model->insertRow($data , $request->input('faqID'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'faqs/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'faqs?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('faqID') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('faqs/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('faqs')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('faqs')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public function getSection( Request $request , $faqID , $sectionID =0 )
	{

		$rest = \DB::table('faqsection')->where('sectionID',$sectionID)->get();
		if(count($rest) >=1)
		{
			$row = $rest[0];
			$this->data['row'] = $row;
		} else {
			$this->data['row'] = (object) array(
				'sectionID'	=> '',
				'faqID'		=> $faqID,
				'title'		=> '',
				'orderID'	=> '',
				'note'		=> ''
			);
		}
		return view('faqs.section',$this->data);
	}		

	public function postSection( Request $request)
	{
		$data =  array(
				'faqID'		=> $request->input('faqID'),
				'title'		=> $request->input('title'),
				'orderID'	=> $request->input('orderID'),
				'note'		=> ''
			);
		if($request->input('sectionID') =='')
		{
			\DB::table('faqsection')->insert($data);
			return Redirect::to('faqs/show/'. $request->input('faqID'))
	        	->with('messagetext','New section has been added !')->with('msgstatus','success');			
		} else {
			\DB::table('faqsection')->where('sectionID',$request->input('sectionID'))->update($data);
			return Redirect::to('faqs/show/'. $request->input('faqID'))
	        	->with('messagetext','Section has been updated !')->with('msgstatus','success');			
		}



	}	

	public function getSectiondelete( Request $request , $faqID , $sectionID =0)	
	{
		\DB::table('faqsection')->where('sectionID',$sectionID)->where('faqID',$faqID)->delete();
		\DB::table('faqitems')->where('sectionID',$sectionID)->delete();
			return Redirect::to('faqs/show/'. $faqID)
	        	->with('messagetext','Section has been deleted !')->with('msgstatus','success');		
	}


	public function getItem( Request $request , $faqID ,$sectionID, $itemID = 0 )
	{

		$rest = \DB::table('faqitems')->where('id',$itemID)->get();
		if(count($rest) >=1)
		{
			$row = $rest[0];
			$this->data['row'] = $row;
			$this->data['row']->faqID = $faqID;
		} else {
			$this->data['row'] = (object) array(
				'faqID'			=> $faqID,
				'sectionID'		=> '',
				'question'		=> '',
				'answer'		=> '',
				'ordering'		=> '',
				'id'			=> ''
			);
		}
		$this->data['section'] = \DB::table('faqsection')->where('faqID',$faqID)->get();
		return view('faqs.item',$this->data);
	}

	public function postItem( Request $request)
	{
		$data =  array(
				'sectionID'		=> $request->input('sectionID'),
				'question'		=> $request->input('question'),
				'answer'		=> $request->input('answer'),
				'ordering'		=> $request->input('ordering'),
				
			);
		if($request->input('id') =='')
		{
			$id = \DB::table('faqitems')->insertGetId($data);
			return Redirect::to('faqs/show/'. $request->input('faqID').'?view='.$id)
	        	->with('messagetext','New item has been added !')->with('msgstatus','success');			
		} else {
			\DB::table('faqitems')->where('id',$request->input('id'))->update($data);
			return Redirect::to('faqs/show/'. $request->input('faqID').'?view='.$request->input('id'))
	        	->with('messagetext','Section has been updated !')->with('msgstatus','success');			
		}



	}	

	public function getItemdelete( Request $request , $faqID , $id =0)	
	{
		
		\DB::table('faqitems')->where('id',$id)->delete();
			return Redirect::to('faqs/show/'. $faqID)
	        	->with('messagetext','Item has been deleted !')->with('msgstatus','success');		
	}



	public static function display( $faqID )
	{

		if($faqID =='') return ' Please choose FAQ';
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Faqs();
		$info = $model::makeInfo('faqs');



			$faq =  \DB::table('faq')->where('faqID',$faqID)->get();
			$row = $faq[0];

			$faqsection =  \DB::table('faqsection')->where('faqID',$faqID)->orderBy('orderID','ASC')->get();

			
			$data = array(
				'pageTitle'	=> 	$row->name,
				'pageNote'	=>  $row->content
				
			);

			$faqTree = array();
			$first = 0;
			foreach($faqsection as $fs)
			{
				$items = \DB::table('faqitems')->where('sectionID',$fs->sectionID)->orderBy('ordering','asc')->get();
				$faqTree[] = array(
					'sectionID'	=> $fs->sectionID ,
					'title'	=> $fs->title ,
					'items'		=> $items
				);	
				if($first == 0) {
					$data['items'] = $items;	
				}
				++$first;
			}
			$data['faqTree']  = $faqTree;

			//return 'test';
			if(isset($_GET['view']))
			{
				$data['items'] = \DB::table('faqitems')->where('id',$_GET['view'])->get();	
			} else {
				$data['items'] = array();
			}


				return view('faqs.public.index',$data);			
		}


					

}