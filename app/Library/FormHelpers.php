<?php
class FormHelpers
{

	public static function render( $ids )
	{
 		//$row = $this->model->find($id);
 		$sql = \DB::table('tb_forms')->where('formID',$ids)->get();
 		if(count($sql) <= 0)
 			return ' Form is not exits';

 		$row = $sql[0];	
		$configuration = json_decode($row->configuration,true);
		$template = base_path().'/resources/views/core/forms/forms/';
		if(file_exists($template .'/form-'.$row->formID.'.blade.php'))
		{
			return view('core.forms.forms.form-'.$row->formID);

		} else {

			return 'Form is not exists';
		}			

	}


	public static function  validateForm( $forms )
	{
		$rules = array();
		foreach($forms as $form)
		{
			if($form['required']== '' || $form['required'] !='0')
			{
				$rules[$form['field']] = 'required';
			} elseif ($form['required'] == 'alpa'){
				$rules[$form['field']] = 'required|alpa';
			} elseif ($form['required'] == 'alpa_num'){
				$rules[$form['field']] = 'required|alpa_num';					
			} elseif ($form['required'] == 'alpa_dash'){
				$rules[$form['field']]='required|alpa_dash';																
			} elseif ($form['required'] == 'email'){
				$rules[$form['field']] ='required|email';
			} elseif ($form['required'] == 'numeric'){
				$rules[$form['field']] = 'required|numeric';		
			} elseif ($form['required'] == 'date'){
				$rules[$form['field']]='required|date';
			} else if($form['required'] == 'url'){
				$rules[$form['field']] = 'required|active_url';
			} else {
	
				if( $form['type'] =='file')
				{
					if(!is_null(Input::file($form['field'])))
					{

						if($form['option']['upload_type'] =='image')
						{
							$rules[$form['field']] = 'mimes:jpg,jpeg,png,gif,bmp';
						} else {
							if($form['option']['image_multiple'] != '1')
							{
								$rules[$form['field']] = 'mimes:zip,csv,xls,doc,docx,xlsx';
							} 
							
						}						
					}

				}

			}										
		}	
		return $rules ;
	}	

	static public function validatePost( $request ,  $str )
	{	
		
		$data = array();
		foreach($str as $f){
			$field = $f['field'];
			// Update for V5.1.5 issue on Autofilled createOn and updatedOn fields
			if($field == 'createdOn') $data['createdOn'] = date('Y-m-d H:i:s');
            if($field == 'updatedOn') $data['updatedOn'] = date('Y-m-d H:i:s');
			if($f['view'] ==1) 
			{
				if($f['type'] =='textarea_editor' || $f['type'] =='textarea')
				{
					// Handle Text Editor 
					$content = (isset($_POST[$field]) ? $_POST[$field] : '');
					 $data[$field] = $content;
				} else {
					// Handle text Input
					if(isset($_POST[$field]))
					{
						$data[$field] = $_POST[$field];				
					}
					// Handle FILE OR IMAGE Upload 
					if($f['type'] =='file')
					{	
						$files ='';	
						if($f['option']['upload_type'] =='file')
						{

							if(isset($f['option']['image_multiple']) && $f['option']['image_multiple'] ==1)
							{								
								if(isset($_POST['curr'.$field]))
								{
									$curr =  '';
									for($i=0; $i<count($_POST['curr'.$field]);$i++)
									{
										$files .= $_POST['curr'.$field][$i].',';
									}
								}	

								if(!is_null(Input::file($field)))
								{

									$destinationPath = '.'. $f['option']['path_to_upload']; 	
									foreach($_FILES[$field]['tmp_name'] as $key => $tmp_name ){
									 	$file_name = $_FILES[$field]['name'][$key];
										$file_tmp =$_FILES[$field]['tmp_name'][$key];
										if($file_name !='')
										{
											move_uploaded_file($file_tmp,$destinationPath.'/'.$file_name);
											$files .= $file_name.',';

										}
										
									}
									
									if($files !='')	$files = substr($files,0,strlen($files)-1);	
								}	
								$data[$field] = $files;													

							} else {
							
								if(!is_null(Input::file($field)))
								{								

									$file = Input::file($field); 
								 	$destinationPath = '.'. $f['option']['path_to_upload']; 
									$filename = $file->getClientOriginalName();
									$extension =$file->getClientOriginalExtension(); //if you need extension of the file
									$rand = rand(1000,100000000);
									$newfilename = strtotime(date('Y-m-d H:i:s')).'-'.$rand.'.'.$extension;
									$uploadSuccess = $file->move($destinationPath, $newfilename);
									if( $uploadSuccess ) {
									   $data[$field] = $newfilename;
									}
								}	 
							}	

						} else {

							if(!is_null(Input::file($field)))
							{

								$file = Input::file($field); 
							 	$destinationPath = '.'. $f['option']['path_to_upload']; 
								$filename = $file->getClientOriginalName();
								$extension =$file->getClientOriginalExtension(); //if you need extension of the file
								$rand = rand(1000,100000000);
								$newfilename = strtotime(date('Y-m-d H:i:s')).'-'.$rand.'.'.$extension;


								$uploadSuccess = $file->move($destinationPath, $newfilename);


								 if($f['option']['resize_width'] != '0' && $f['option']['resize_width'] !='')
								 {
								 	if( $f['option']['resize_height'] ==0 )
									{
										$f['option']['resize_height']	= $f['option']['resize_width'];
									}
								 	$orgFile = $destinationPath.'/'.$newfilename;
									 \SiteHelpers::cropImage($f['option']['resize_width'] , $f['option']['resize_height'] , $orgFile ,  $extension,	 $orgFile)	;						 
								 }
								 
								if( $uploadSuccess ) {
								   $data[$field] = $newfilename;
								} 


							} else {
								unset($data[$field]);
							}	

						}

					}	

					// Handle Checkbox input 
					if($f['type'] =='checkbox')
					{
						if(isset($_POST[$field]))
						{
							$data[$field] = implode(",",$_POST[$field]);
						} else {
							$data[$field] = '0';	
						}
					}
					// Handle Date 				
					if($f['type'] =='date')
					{
						$data[$field] = date("Y-m-d",strtotime($request->input($field)));
					}

					// Handle Date 				
					if($f['type'] =='date_time')
					{
						$data[$field] = date("Y-m-d H:i:s",strtotime($request->input($field)));
					}

					
					// if post is seelct multiple						
					if($f['type'] =='select')
					{
						if( isset($f['option']['select_multiple']) &&  $f['option']['select_multiple'] ==1 )
						{
							$multival = (is_array($_POST[$field]) ? implode(",",$_POST[$field]) :  $_POST[$field]); 
							$data[$field] = $multival;
						} else {
							$data[$field] = $_POST[$field];
						}	
					}									
					
				}	 						

			}	
		}
		

		/* Added for Compatibility laravel 5.2 */
		$values = array();
		foreach($data as $key=>$val)
		{
			if($val !='') $values[$key] = $val;
		}			
		return $values;
	}


	public static function javascriptForms( $forms  )
	{
		$f = '';
		foreach($forms as $form){
			if($form['view'] != 0)
			{			
				if(preg_match('/(select)/',$form['type'])) 
				{
					if($form['option']['opt_type'] == 'external') 
					{
						$table 	=  $form['option']['lookup_table'] ;
						$val 	=  $form['option']['lookup_value'];
						$key 	=  $form['option']['lookup_key'];
						$lookey = '';
						if($form['option']['is_dependency']) $lookey .= $form['option']['lookup_dependency_key'] ;
						$f .= self::createPreCombo( $form['field'] , $table , $key , $val , $lookey  );
							
					}
									
				}
				
			}	
		
		}
		return $f;	
	
	}
	
	public static function createPreCombo( $field , $table , $key ,  $val ,$lookey = null)
	{


		
		$parent = null;
		$parent_field = null;
		if($lookey != null)  
		{	
			$parent = " parent: '#".$lookey."',";
			$parent_field =  "&parent={$lookey}:";
		}	
		$pre_jCombo = "
		\$(\"#{$field}\").jCombo(\"{!! url('post/comboselect?filter={$table}:{$key}:{$val}') !!}$parent_field\",
		{ ".$parent." selected_value : '' });
		";	
		return $pre_jCombo;
	}	 

}