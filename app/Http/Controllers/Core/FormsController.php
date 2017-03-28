<?php namespace App\Http\Controllers\Core;

use App\Http\Controllers\controller;
use App\Models\Core\Forms;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class FormsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'forms';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Forms();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'core/forms',
			'pageUrl'	=> 'core/forms',
			'return'	=> self::returnUrl()
			
		);
		
		\App::setLocale(CNF_LANG);
		if (defined('CNF_MULTILANG') && CNF_MULTILANG == '1') {

		$lang = (\Session::get('lang') != "" ? \Session::get('lang') : CNF_LANG);
		\App::setLocale($lang);
		}  

		$driver             = config('database.default');
        $database           = config('database.connections');
       
        $this->db           = $database[$driver]['database'];		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'formID'); 
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
		$pagination->setPath('forms');
		
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
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('core.forms.index',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('tb_forms'); 
		}



		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		//echo '<pre>';print_r(json_decode($row['configuration'],true)); echo '</pre>';exit;
		$this->data['tables']  = Forms::getTableList($this->db);
		
		$this->data['id'] = $id;
		return view('core.forms.form',$this->data);
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
			return view('core.forms.view',$this->data);
		} else {
			return Redirect::to('core/forms')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_forms');
				
			

			if($request->input('formID') =='')
			{
				if($request->input('method') =='table')
				{
					$table = $request->input('tablename');
					$columns = \DB::select("SHOW COLUMNS FROM ".$table );

					$i = 0; $rowForm = array();
					foreach($columns as $column)
		            {
		                if(!isset($column->Table)) $column->Table = $table;
		                if($column->Key =='PRI') $column->Type ='hidden';
		                if($column->Table == $table) 
		                {                
		                    $form_creator = self::configForm($column->Field,$column->Table,$column->Type,$i);
		                    $relation = self::buildRelation($table ,$column->Field);
		                    foreach($relation as $row) 
		                    {
		                        $array = array('external',$row['table'],$row['column']);
		                        $form_creator = self::configForm($column->Field,$table,'select',$i,$array);
		                        
		                    }
		                    $rowForm[] = $form_creator;
		                }                 
		                $i++;
		            }   
		            $data['configuration'] = json_encode($rowForm); 	                


				} else {
					 $data['configuration'] = json_encode(array()); 
				}
			}

			$id = $this->model->insertRow($data , $request->input('formID'));	
			
			if(!is_null($request->input('apply')))
			{
				$return = 'core/forms/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'core/forms?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('formID') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('core/forms/update/'.$request->input('formID'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			$template = base_path().'/resources/views/core/forms/forms/';
			for($i=0; $i<count($_POST['ids']);$i++)
			{
				$file = $template.'form-'.$_POST['ids'][$i].'.blade.php';
				if(file_exists($file))
				{
					unlink($file);
				}	
			}
			
			
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('ids'))."  , Has Been Removed Successfull");
			// redirect
			return Redirect::to('core/forms?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('core/forms?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Forms();
		$info = $model::makeInfo('forms');

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
				return view('forms.public.view',$data);
			} 

		} else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> 'formID' ,
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
			return view('forms.public.index',$data);			
		}


	}

	function postSavepublic( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_forms');		
			 $this->model->insertRow($data , $request->input('formID'));
			return  Redirect::back()->with('messagetext','<p class="alert alert-success">'.\Lang::get('core.note_success').'</p>')->with('msgstatus','success');
		} else {

			return  Redirect::back()->with('messagetext','<p class="alert alert-danger">'.\Lang::get('core.note_error').'</p>')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	
	
	}	

    function configForm( $field , $alias, $type , $sort, $opt = array()) {
        
        $opt_type = ''; $lookup_table =''; $lookup_key ='';
        if(count($opt) >=1) {
            $opt_type = $opt[0]; $lookup_table = $opt[1]; $lookup_key = $opt[2];
        }
        
    
        $forms = array(
            "field"     => $field,
            "alias"     => $alias,
            "label"     => ucwords(str_replace('_',' ',$field)),
            "language"    => array(),
            'required'        => '0',
            'view'            => '1',
            'type'            => self::configFieldType($type),
            'add'            => '1',
            'edit'            => '1',
            'search'        => '1',

            'size'            => 'span12',
            "sortlist"     => $sort ,
            'form_group'    => '',
            'option'        => array(
                "opt_type"                 => $opt_type,
                "lookup_query"             => '',
                "lookup_table"             =>     $lookup_table,
                "lookup_key"             =>  $lookup_key,
                "lookup_value"            => $lookup_key,
                'is_dependency'            => '',
                'select_multiple'            => '0',
                'image_multiple'            => '0',
                'lookup_dependency_key'    => '',
                'path_to_upload'        => '',
                'upload_type'        => '',
                'tooltip'        => '',
                'attribute'        => '',
                'extend_class'        => ''
                )
            );
        return $forms;    
    
    } 
    function configFieldType( $type )
    {
        switch($type)
        {
            default: $type = 'text'; break;
            case 'timestamp'; $type = 'text_datetime'; break;
            case 'datetime'; $type = 'text_datetime'; break;
            case 'string'; $type = 'text'; break;
            case 'int'; $type = 'text'; break;
            case 'text'; $type = 'textarea'; break;
            case 'blob'; $type = 'textarea'; break;
            case 'select'; $type = 'select'; break;
        }
        return $type;
    
    }

    function buildRelation( $table , $field)
    {

        $pdo = \DB::getPdo();
        $sql = "
        SELECT
            referenced_table_name AS 'table',
            referenced_column_name AS 'column'
        FROM
            information_schema.key_column_usage
        WHERE
            referenced_table_name IS NOT NULL
            AND table_schema = '".$this->db."'  AND table_name = '{$table}' AND column_name = '{$field}' ";
        $Q = $pdo->query($sql);
        $rows = array();
        while ($row =  $Q->fetch()) {
            $rows[] = $row;
        } 
        return $rows;    

    
    }    

    function getConfiguration( Request $request, $ids)
    {
		$row = $this->model->find($ids);
		$configuration = json_decode($row->configuration,true);
		$i = 0; $forms = array();
		$i = 0 ;
		usort($configuration, "\SiteHelpers::_sort");
		foreach($configuration as $rows){
		  $id = ++$i;
		  $forms[] = self::convertForm( $ids , $rows , $id); 

		}
		$data['forms'] = $forms;
		$data['row']	= $row ;

		return view('core.forms.configuration',$data);

		

    } 
  
  	function getInput( Request $request, $id )
  	{

 		$f = array(
                    "field" =>'',"alias"=>'',"label"=>  '','form_group'=>'', 'required' => '',
                    'view' => '','type' => '','add'=> '','size'=> '','edit'=> '','search' => '',"sortlist" => '',
                    'limited' => '','option'=> array(
                        "opt_type"              => '',
                        "lookup_query"          => '',
                        "lookup_table"          => '',
                        "lookup_key"            => '',
                        "lookup_value"          => '',
                        'is_dependency'         => '',
                        'select_multiple'       => '',
                        'image_multiple'        => '',
                        'lookup_dependency_key' => '',
                        'path_to_upload'        => '',
                        'upload_type'           => '',
                        'resize_width'          =>'' ,
                        'resize_height'         => '',
                        'extend_class'          => '',
                        'tooltip'               => '' ,
                        'attribute'             => '',
                        'extend_class'          => '',    
                    ));                


         $this->data['field_type_opt'] = array(
            'text'            => 'Text' ,
            'text_date'        => 'Date',
            'text_datetime'        => 'Date & Time',
            'textarea'        => 'Textarea',
            'textarea_editor'    => 'Textarea With Editor ',
            'select'        => 'Select Option',
            'radio'            => 'Radio' ,
            'checkbox'        => 'Checkbox',
            'file'            => 'Upload File',            
            'hidden'        => 'Hidden',
                    
        );
        $this->data['f']     = $f;  
        $this->data['tables']        = Forms::getTableList($this->db);   
        $this->data['row']	= array('formID'=>$id);
        return view('core.forms.field',$this->data); 

  	}

    function getField( Request $request ,$id)
    {

 		$row = $this->model->find($id);
		$configuration = json_decode($row->configuration,true);
		$i = 0; $forms = array();
		$field_id     = $request->input('field'); 
		foreach($configuration as $form)
        {            
            $tooltip = '';$attribute = '';
            if(isset($form['option']['tooltip'])) $tooltip = $form['option']['tooltip'];
            if(isset($form['option']['attribute'])) $attribute = $form['option']['attribute'];
            $size = isset($form['size']) ? $form['size'] : 'span12'; 
            if($form['field'] == $field_id)
            {
                //$multiVal = explode(":",$form['option']['lookup_value']);
                $f = array(
                    "field"     => $form['field'],
                    "alias"     => $form['alias'],
                    "label"     =>  $form['label'],
                    'form_group'    =>  $form['form_group'],
                    'required'        => $form['required'],
                    'view'            => $form['view'],
                    'type'            => $form['type'],
                    'add'            => $form['add'],
                    'size'            => $size,
                    'edit'            => $form['edit'],
                    'search'        => $form['search'],
                    "sortlist"         => $form['sortlist'] ,
                    'limited'           => isset($form['limited']) ? $form['limited'] : '',
                    'option'        => array(
                        "opt_type"                 => $form['option']['opt_type'],
                        "lookup_query"             => $form['option']['lookup_query'],
                        "lookup_table"             => $form['option']['lookup_table'],
                        "lookup_key"             => $form['option']['lookup_key'],
                        "lookup_value"            => $form['option']['lookup_value'],
                        'is_dependency'            => $form['option']['is_dependency'],
                        'select_multiple'            => (isset($form['option']['select_multiple']) ? $form['option']['select_multiple'] : 0 ) ,
                        'image_multiple'            => (isset($form['option']['image_multiple']) ? $form['option']['image_multiple'] : 0 ) ,
                        'lookup_dependency_key'    => $form['option']['lookup_dependency_key'],
                        'path_to_upload'        => $form['option']['path_to_upload'],
                        'upload_type'            => $form['option']['upload_type'],
                        'resize_width'            => isset( $form['option']['resize_width'])?$form['option']['resize_width']:'' ,
                        'resize_height'            => isset( $form['option']['resize_height'])? $form['option']['resize_height']:'',
                        'extend_class'            => isset( $form['option']['extend_class'])?$form['option']['extend_class']:'',
                        'tooltip'                => $tooltip ,
                        'attribute'                => $attribute,
                        'extend_class'            => isset( $form['option']['extend_class'])?$form['option']['extend_class']:''
                        ),    
                    );                
            }
        }

         $this->data['field_type_opt'] = array(
            'text'            => 'Text' ,
            'text_date'        => 'Date',
            'text_datetime'        => 'Date & Time',
            'textarea'        => 'Textarea',
            'textarea_editor'    => 'Textarea With Editor ',
            'select'        => 'Select Option',
            'radio'            => 'Radio' ,
            'checkbox'        => 'Checkbox',
            'file'            => 'Upload File',            
            'hidden'        => 'Hidden',
                    
        );
        $this->data['f']     = $f; 
        $this->data['row']     = $row; 
        $this->data['tables']        = Forms::getTableList($this->db);   
        return view('core.forms.field',$this->data);       


    }


    function postField( Request $request,$formID)
    {

    
        $lookup_value = (is_array($request->input('lookup_value')) ? implode("|",array_filter($request->input('lookup_value'))) : '');        
        $row = \DB::table('tb_forms')->where('formID', $formID)
                                ->get();
        if(count($row) <= 0){
             return Redirect::to('core/forms/update/'.$formID)->with('messagetext','Can not find module')->with('msgstatus','error');        
        }
        $row = $row[0];                                    
        $this->data['row'] = $row;    
        $config = json_decode($row->configuration,true);     

        $view = 0;$search = 0;
        if(!is_null($request->input('view'))) $view = 1; 
        if(!is_null($request->input('search'))) $search = 1; 
    
        if(preg_match('/(select|radio|checkbox)/',$request->input('type'))) 
        {
            if($request->input('opt_type') == 'datalist')
            {
                $datalist = '';
                $cf_val     = $request->input('custom_field_val');
                $cf_display = $request->input('custom_field_display');
                for($i=0; $i<count($cf_val);$i++)
                {
                    $value         = $cf_val[$i];
                    if(isset($cf_display[$i])) { $display = $cf_display[$i]; } else { $display ='none';}
                    $datalist .= $value.':'.$display.'|';
                }
                $datalist = substr($datalist,0,strlen($datalist)-1);
            
            } else {
                $datalist = ''; 
            }
        }  else {
            $datalist = '';
        }
                 
        $new_field = array(
            "field"         => \SiteHelpers::seoUrl($request->input('field')),
            "alias"         => $request->input('alias'),
            "label"         => $request->input('label'),
            "form_group"     => $request->input('form_group'),
            'required'        => $request->input('required'),
            'view'            => $view,
            'type'            => $request->input('type'),
            'add'            => 1,
            'edit'            => 1,
            'search'        => $request->input('search'),
            'size'            =>     '',
            'sortlist'        => $request->input('sortlist'),
            'limited'           => $request->input('limited'),
            'option'        => array(
                "opt_type"         =>  $request->input('opt_type'),
                "lookup_query"     =>  $datalist,
                "lookup_table"     =>  $request->input('lookup_table'),
                "lookup_key"     =>  $request->input('lookup_key'),
                "lookup_value"    =>     $lookup_value,
                'is_dependency'    =>  $request->input('is_dependency'),
                'select_multiple'    =>  (!is_null($request->input('select_multiple')) ? '1':'0'),
                'image_multiple'    =>  (!is_null($request->input('image_multiple')) ? '1':'0'),
                'lookup_dependency_key'=>  $request->input('lookup_dependency_key'),
                'path_to_upload'=>  $request->input('path_to_upload'),
                'upload_type'    =>  $request->input('upload_type'),
                'resize_width'    =>  $request->input('resize_width'),
                'resize_height'    =>  $request->input('resize_height'),
                'tooltip'        =>  $request->input('tooltip'),
                'attribute'        =>  $request->input('attribute'),
                'extend_class'    =>  $request->input('extend_class')
                )            
        );
      

        if($request->input('is_new') =='new')
        {
        	$forms[] = $new_field;
        	$forms = array_merge($config ,$forms);

        	//echo '<pre>'; print_r($forms); echo '</pre>'; exit;
        } else {	

	        $forms = array();
	        foreach($config as $form_view)
	        {
	            if($form_view['field'] == $request->input('field')) 
	            {
	                $new_form = $new_field;        
	            } else     {
	                $new_form  = $form_view;
	            }    
	            $forms[] = $new_form ;
	    
	        } 
	    }       
    	  
        \DB::table('tb_forms')->where('formID', '=',$formID )->update(array('configuration' => json_encode($forms))); 
         return json_encode(array('status'=>"success")); 

                
         
    }    


    function getRemovefield( Request $request,$formID ,$field)
    {

    
   
        $row = \DB::table('tb_forms')->where('formID', $formID)
                                ->get();
        if(count($row) <= 0){
             return Redirect::to('core/forms/update/'.$formID)->with('messagetext','Can not find module')->with('msgstatus','error');        
        }

        $row = $row[0];                                    
        $this->data['row'] = $row;    
        $config = json_decode($row->configuration,true);     


        $forms = array();
        foreach($config as $form_view)
        {
            if($form_view['field'] != $field)  $forms[] = $form_view ;
    
        } 
	           	  
        \DB::table('tb_forms')->where('formID', '=',$formID )->update(array('configuration' => json_encode($forms))); 
         return json_encode(array('status'=>"success")); 

                
         
    }     
   

   function postReorder( Request $request , $ids )
   {
		
   		
		$row = $this->model->find($ids);
		$configuration = json_decode($row->configuration,true);
		$i = 0; $forms = array();
		foreach($configuration as $rows){
		  $id = ++$i;
		  if(isset($_POST['sortlist'][$rows['field']]))
		  {
		  	$orders = array('sortlist'=> $_POST['sortlist'][$rows['field']]);
		  	$forms[] = array_merge($rows,$orders);
		  	
		  } else {
		  	$forms[] = $rows;
		  }
		  

		}
		//echo '<pre>'; print_r($forms); echo '</pre>'; exit;
		\DB::table('tb_forms')->where('formID', '=',$ids )->update(array('configuration' => json_encode($forms))); 
         return json_encode(array('status'=>"success")); 	

   }


    function convertForm( $id , $rows , $num )
    {
    	$type 	= $rows['type'];
    	$field 	= $rows['field'];
    	$required	=  $rows['required'] ;
    	$option     = $rows['option'];
    	$label     = $rows['label'];
    	
    	$edit = url('core/forms/field/'.$id.'?field='.$field);
    	$remove = '<a href="#" onclick="removeField(\''.$id.'\',\''.$field.'\'); return false;"><i class="fa fa-trash-o"></i> Remove </a>';
    	switch ($type)
    	{
  			default;
				$form = '
				<div class="form-group">
					<label class="  " >'.ucwords($label).'</label>

				<input type="text" class="form-control" name="'.$field.'" value="" placeholder="" /> 
				<input type="hidden" name="sortlist['.$field.']" class="reorder" value="'.$num.'"  />
				<input type="hidden" name="field['.$num.']"  value="'.$field.'"  />
				<span class="pull-right"><a href="#" onclick="SximoModal(\''.$edit.'\')"><i class="fa fa-edit "></i> Edit </a> | '.$remove.'</span>
				</div>';
				break;

			case 'hidden';
				$form = '
				<div class="form-group">
					<label class="  " >'.ucwords($label).' ( This input form will be hidden ) </label>

				<input type="text" class="form-control" name="'.$field.'" value="" placeholder="" disabled /> 
				<input type="hidden" name="sortlist['.$field.']" class="reorder" value="'.$num.'"  />
				<span class="pull-right"><a href="#" onclick="SximoModal(\''.$edit.'\')"><i class="fa fa-edit "></i> Edit </a> | 
				'.$remove.'</span>
				</div>';
				break;				

			case 'text_date';
				$form = '
				<div class="form-group">
					<label class="  " >'.ucwords($label).'</label>
					<div class="input-group m-b" style="width:150px !important;">
						<input type="text" class="form-control" name="'.$field.'" value="" placeholder="" /> 
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
					<input type="hidden" name="sortlist['.$field.']" class="reorder" value="'.$num.'"  />
			
					<span class="pull-right"><a href="#" onclick="SximoModal(\''.$edit.'\')"><i class="fa fa-edit "></i> Edit </a> | 
					'.$remove.'</span>
				</div>'	;
				break;


			case 'file';
				$form = '
				<div class="form-group">
					<label class="  " >'.ucwords($label).'</label>
					<input type="hidden" name="sortlist['.$field.']" class="reorder" value="'.$num.'"  />
					<input type="file" name="'.$field.'" />
				<span class="pull-right"><a href="#" onclick="SximoModal(\''.$edit.'\')"><i class="fa fa-edit "></i> Edit </a> | 
					'.$remove.'</span>
				</div>'	;
				break;

			case 'select';
				$form = '
				<div class="form-group">
					<label class="  " >'.ucwords($label).'</label>
					<input type="hidden" name="sortlist['.$field.']" class="reorder" value="'.$num.'"  />
				<select name="" class="form-control"><option value="">Select</option></select>
				<span class="pull-right"><a href="#" onclick="SximoModal(\''.$edit.'\')"><i class="fa fa-edit "></i> Edit </a> | 
					'.$remove.'</span>
				</div>'	;
				break;

			case 'radio';
				$opt = explode("|",$option['lookup_query']);
				$option = '';
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]); 
					$option .= "
					<label class='radio radio-inline'>
					<input type='radio' name='".$field." value ='".ltrim(rtrim($row[0]))."'";
					$option .= " > ".$row[1]." </label>";
				}
				$form = '
				<div class="form-group">
				<input type="hidden" name="sortlist['.$field.']" class="reorder" value="'.$num.'"  />
					<label class="  " >'.ucwords($label).'</label> <br />
					'.$option.'	
				<span class="pull-right"><a href="#" onclick="SximoModal(\''.$edit.'\')"><i class="fa fa-edit "></i> Edit </a> | 
					'.$remove.'</span>
				</div>'	;
				break;	


			case 'checkbox';
				$opt = explode("|",$option['lookup_query']);
				$option = '';
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]); 
					$option .= "
					<label class='checked checkbox-inline'>
					<input type='checkbox' name='".$field." value ='".ltrim(rtrim($row[0]))."'";
					$option .= " > ".$row[1]." </label>";
				}
				$form = '
				<div class="form-group">
				<input type="hidden" name="sortlist['.$field.']" class="reorder" value="'.$num.'"  />
					<label class="  " >'.ucwords($label).'</label> <br />
					'.$option.'	
				<span class="pull-right"><a href="#" onclick="SximoModal(\''.$edit.'\')"><i class="fa fa-edit "></i> Edit </a> | 
					'.$remove.'</span>
				</div>'	;
				break;	


			case 'textarea';
				$form = '
				<div class="form-group">
				<input type="hidden" name="sortlist['.$field.']" class="reorder" value="'.$num.'"  />
					<label class="  " >'.ucwords($label).'</label>
					<textarea name="name" class="form-control"></textarea>
					<span class="pull-right"><a href="#" onclick="SximoModal(\''.$edit.'\')"><i class="fa fa-edit "></i> Edit </a> | '.$remove.'</span>
				</div>	
					'	;
				break;	

    	}

    	return $form;
    }

    function getRebuild( $id )
    {
		$row = $this->model->find($id);
		$configuration = json_decode($row->configuration,true);

		$i = 0; $codes = array();$forms = '';
		usort($configuration, "\SiteHelpers::_sort");
		foreach($configuration as $rows){
		  $id = ++$i;
		  $attr = '';
		  if($rows['type'] =='hidden')
		  	$attr = 'style="display:none"';
		$forms .= '<div class="form-group  " '.$attr.'>
					<label for="ipt" class="  "> '.ucwords($rows['label']).'  </label>
				';
$forms .= self::formShow( $rows['type'] , $rows['field'] , $rows['required'] , $rows['option']);
			$forms .= '
		</div>

		';

		}
		$codes['forms'] = $forms;
		$codes['javascript'] = \FormHelpers::javascriptForms($configuration,'home','home');
		$codes['form_ID'] = $row->formID;

		//echo '<pre>'; print_r($codes); echo '</pre>'; exit;

		$template = base_path().'/resources/views/core/forms/';
		$form_template = file_get_contents(  $template.'form.tpl' );
		$convert       = \SiteHelpers::blend($form_template,$codes); 
		// Render To Form
		file_put_contents(  $template ."forms/form-{$row->formID}.blade.php" , $convert) ;
		// End Render to Form
		return response()->json(array('status'=>'success','message'=>'Code Script has been replaced successfull'));

    }


	public static function formShow( $type , $field , $required ,$option = array())
	{
		//print_r($option);
		$mandatory = '';$attribute = ''; $extend_class ='';
		if(isset($option['attribute']) && $option['attribute'] !='') {
				$attribute = $option['attribute']; }
		if(isset($option['extend_class']) && $option['extend_class'] !='') {
			$extend_class = $option['extend_class']; 
		}				
				
		$show = '';
		if($type =='hidden') $show = 'style="display:none;"';	
				
		if($required =='required') {
			$mandatory = "'required'=>'true'";
		} else if($required =='email') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'email' ";
		} else if($required =='url') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'url' ";
		} else if($required =='date') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'dateIso' ";
		} else if($required =='numeric') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'number' ";
		} else {
			$mandatory = '';
		}		
		
		switch($type)
		{
			default;
				$form = "{!! Form::text('{$field}','',array('class'=>'form-control', 'placeholder'=>'', {$mandatory}  )) !!}";
				break;
				
			case 'hidden';
				$form = "{!! Form::hidden('{$field}', '') !!}";
				break;

			case 'textarea';
				if($required !='0') { $mandatory = 'required'; }
				$form = "<textarea name='{$field}' rows='5' id='{$field}' class='form-control {$extend_class}'  
				         {$mandatory} {$attribute} ></textarea>";
				break;

			case 'textarea_editor';
				if($required !='0') { $mandatory = 'required'; }
				$form = "<textarea name='{$field}' rows='5' id='editor' class='form-control editor {$extend_class}'  
						{$mandatory}{$attribute} ></textarea>";
				break;				
				

			case 'text_date';
				$form = "
				<div class=\"input-group m-b\" style=\"width:150px !important;\">
					{!! Form::text('{$field}', '',array('class'=>'form-control date')) !!}
					<span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
				</div>";
				break;
				
			case 'text_time';
				$form = "
					<div class=\"input-group m-b\" style=\"width:150px !important;\">
						input  type='text' name='{$field}' id='{$field}' value='' 
						{$mandatory}  {$attribute}   class='form-control {$extend_class}'
						data-date-format='yyyy-mm-dd'
						 />
						 <span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
					</div>
						 ";
				break;				

			case 'text_datetime';
				if($required !='0') { $mandatory = 'required'; }
				$form = "
				<div class=\"input-group m-b\" style=\"width:150px !important;\">
					{!! Form::text('{$field}','',array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) !!}
					<span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
				</div>
				";
				break;				

			case 'select';
				if($required !='0') { $mandatory = 'required'; }
				if($option['opt_type'] =='datalist')
				{
					$optList ='';
					$opt = explode("|",$option['lookup_query']);
					for($i=0; $i<count($opt);$i++) 
					{							
						$row =  explode(":",$opt[$i]);
						for($i=0; $i<count($opt);$i++) 
						{					
							
							$row =  explode(":",$opt[$i]);
							$optList .= " '".trim($row[0])."' => '".trim($row[1])."' , ";
							
						}							
					}	
					$form  = "
					<?php 
					";
					$form  .= 
					"\$".$field."_opt = array(".$optList."); ?>
					";	
					
					if(isset($option['select_multiple']) && $option['select_multiple'] ==1)
					{
					 
						$form  .= "<select name='{$field}[]' rows='5' {$mandatory} multiple  class='form-control '  > ";
						$form  .= "
						<?php 
						foreach(\$".$field."_opt as \$key=>\$val)
						{
							echo \"<option  value ='\$key' \".(in_array(\$key,\$".$field.") ? \" selected='selected' \" : '' ).\">\$val</option>\"; 						
						}						
						?>";
						$form .= "</select>";
					} else {
						
						$form  .= "<select name='{$field}' rows='5' {$mandatory}  class='form-control '  > ";
						$form  .= "
						<?php 
						foreach(\$".$field."_opt as \$key=>\$val)
						{
							echo \"<option  value ='\$key' >\$val</option>\"; 						
						}						
						?>";
						$form .= "</select>";				
					
					}
					
				} else {
					
					if(isset($option['select_multiple']) && $option['select_multiple'] ==1)
					{
						$named ="name='{$field}[]' multiple";
					} else {
						$named ="name='{$field}'";

					}
					$form = "<select ".$named." rows='5' id='{$field}' class='form-control {$extend_class}' {$mandatory} {$attribute} ></select>";


				}
				break;	
				
			case 'file';
				if($required !='0') { $mandatory = 'required'; }

				if(isset($option['image_multiple']) && $option['image_multiple'] ==1)
				{
					$form = '
					<a href="javascript:void(0)" class="btn btn-xs btn-primary pull-right" onclick="addMoreFiles(\''.$field.'\')"><i class="fa fa-plus"></i></a>
					<div class="'.$field.'Upl">	
					 	<input  type=\'file\' name=\''.$field.'[]\'  />			
					</div>
					<ul class="uploadedLists " >
					<?php $cr= 0; 
					$row[\''.$field.'\'] = explode(",",$row[\''.$field.'\']);
					?>
					@foreach($row[\''.$field.'\'] as $files)
						@if(file_exists(\'.'.$option['path_to_upload'].'\'.$files) && $files !=\'\')
						<li id="cr-<?php echo $cr;?>" class="">							
							<a href="{{ url(\''.$option['path_to_upload'].'/\'.$files) }}" target="_blank" >{{ $files }}</a> 
							<span class="pull-right removeMultiFiles" rel="cr-<?php echo $cr;?>" url="'.$option['path_to_upload'].'{{$files}}">
							<i class="fa fa-trash-o  btn btn-xs btn-danger"></i></span>
							<input type="hidden" name="curr'.$field.'[]" value="{{ $files }}"/>
							<?php ++$cr;?>
						</li>
						@endif
					
					@endforeach
					</ul>
					';

				} else {
					$form = "<input  type='file' name='{$field}' id='{$field}' ";
					$form .= "style='width:150px !important;' {$attribute} />";

				}
				break;						
				
			case 'radio';
				if($required !='0') { $mandatory = 'required'; }
				$opt = explode("|",$option['lookup_query']);
				$form = '';
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]); 
					$form .= "
					<label class='radio-inline'>
					<input type='radio' name='{$field}' value ='".ltrim(rtrim($row[0]))."' {$mandatory} {$attribute}";
					$form .= " > ".$row[1]." </label>";
				}
				break;
				
			case 'checkbox';
				if($required !='0') { $mandatory = 'required'; }
				$opt = explode("|",$option['lookup_query']);
				$form = "";
				for($i=0; $i<count($opt);$i++) 
				{
					
					$checked = '';
					$row =  explode(":",$opt[$i]);					
					 $form .= "
					 <label class='checked checkbox-inline'>   
					<input type='checkbox' name='{$field}[]' value ='".ltrim(rtrim($row[0]))."' {$mandatory} {$attribute} class='{$extend_class}' ";
					$form .= " /> ".$row[1]." </label> ";					
				}
				break;				
			
		}
		
		return $form;		
	}  


	function postProccess( Request $request , $formID )
	{
		$row = $this->model->find($formID);
		$configuration = json_decode($row->configuration,true);

		$rules = \FormHelpers::validateForm( $configuration);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			//$data = \FormHelpers::checkInputField($formID);	
			if($row->method =='table')
			{

				foreach($configuration as $conf)
				{
					$data['field'] =  $request->input($conf['field']);
				}
				\DB::table($row->tablename)->insert($data);

			} elseif($row->method =='eav'){

				// DO insert into EAV table

			} else {
				// Send all input into specific email address

				$message = '';
				foreach($configuration as $conf)
				{
					$message .='
						<b>'.$conf['label'].'</b> : '. $request->input($conf['field']).' <br />
					';
				}
				/*
				$data['message'] = $message;
				Mail::send('forms.templateform', $data, function ($message) use ($row) {
		    		$message->to($row->email)->subject('Submited Form :  '. $row->name);
		    	});
		    	*/
		    	return Redirect::back()->with('message', \SiteHelpers::alert('success',$row->success))
				->withErrors($validator)->withInput();

				

			}

			
		} else {

			//Redirect::back();
			return Redirect::back()->with('message', \SiteHelpers::alert('error','The following errors occurred'))
			->withErrors($validator)->withInput();	

		}	
	
	}	


	function getDocs()
	{
		return view('core.forms.docs');
	}


	public function getSearch( $mode = 'native')
	{

		$this->data['tableForm'] 	= $this->info['config']['forms'];	
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['searchMode'] = 'native';
		$this->data['pageUrl']		= url('core/forms');
		return view('sximo.module.utility.search',$this->data);
	
	}	


}