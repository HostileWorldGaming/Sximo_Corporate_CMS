@extends('layouts.app')

@section('content')

  <div class="page-content row">
    <!-- Page header -->

 
 	<div class="page-content-wrapper m-t">


<div class="sbox">
	<div class="sbox-title"> 
		<div class="sbox-tools pull-left" >
			<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_back') }}" ><i class="fa  fa-arrow-left"></i></a> 
		</div>
		<div class="sbox-tools " >
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div> 

	</div>
	<div class="sbox-content"> 	

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>	

		 {!! Form::open(array('url'=>'employee/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Employee</legend>
				{!! Form::hidden('employeeNumber', $row['employeeNumber']) !!}					
									  <div class="form-group  " >
										<label for="LastName" class=" control-label col-md-4 text-left"> LastName </label>
										<div class="col-md-7">
										  <input  type='text' name='lastName' id='lastName' value='{{ $row['lastName'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="FirstName" class=" control-label col-md-4 text-left"> FirstName <span class="asterix"> * </span></label>
										<div class="col-md-7">
										  <input  type='text' name='firstName' id='firstName' value='{{ $row['firstName'] }}' 
						required     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Extension" class=" control-label col-md-4 text-left"> Extension </label>
										<div class="col-md-7">
										  <input  type='text' name='extension' id='extension' value='{{ $row['extension'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Email" class=" control-label col-md-4 text-left"> Email <span class="asterix"> * </span></label>
										<div class="col-md-7">
										  <input  type='text' name='email' id='email' value='{{ $row['email'] }}' 
						required  placeholder='Email Address'   class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="OfficeCode" class=" control-label col-md-4 text-left"> OfficeCode </label>
										<div class="col-md-7">
										  <select name='officeCode' rows='5' id='officeCode' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="ReportsTo" class=" control-label col-md-4 text-left"> ReportsTo </label>
										<div class="col-md-7">
										  <select name='reportsTo' rows='5' id='reportsTo' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="JobTitle" class=" control-label col-md-4 text-left"> JobTitle </label>
										<div class="col-md-7">
										  <input  type='text' name='jobTitle' id='jobTitle' value='{{ $row['jobTitle'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Photo" class=" control-label col-md-4 text-left"> Photo </label>
										<div class="col-md-7">
										  <input  type='file' name='photo' id='photo' @if($row['photo'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['photo'],'/uploads/images/') !!}
						
						</div>					
					 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="icon-checkmark-circle2"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="icon-bubble-check"></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('employee?return='.$return) }}' " class="btn btn-warning btn-sm "><i class="icon-cancel-circle2 "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#officeCode").jCombo("{!! url('employee/comboselect?filter=offices:officeCode:officeCode|city') !!}",
		{  selected_value : '{{ $row["officeCode"] }}' });
		
		$("#reportsTo").jCombo("{!! url('employee/comboselect?filter=employees:employeeNumber:lastName|firstName') !!}",
		{  selected_value : '{{ $row["reportsTo"] }}' });
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("employee/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop