@extends('layouts.app')

@section('content')

  <div class="page-content row">
    <!-- Page header -->

 
 	<div class="page-content-wrapper m-t">


<div class="sbox">
	<div class="sbox-title"> <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
		<div class="sbox-tools" >
			<a href="{{ url($pageModule.'?return='.$return) }}" class="btn btn-xs btn-white tips"  title="{{ Lang::get('core.btn_back') }}" ><i class="icon-backward"></i> {{ Lang::get('core.btn_back') }} </a> 
		</div>
	</div>
	<div class="sbox-content"> 	

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>	

		 {!! Form::open(array('url'=>'stask/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Task Manager</legend>
				{!! Form::hidden('TaskID', $row['TaskID']) !!}					
									  <div class="form-group  " >
										<label for="Project Name" class=" control-label col-md-4 text-left"> Project Name <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <select name='ProjectID' rows='5' id='ProjectID' class='select2 ' required  ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 
				<?php 
				$limited = isset($fields['UserIDs']['limited']) ? $fields['UserIDs']['limited'] :'';
				if(SiteHelpers::filterColumn($limited )) { ?>
												
									  <div class="form-group  " >
										<label for="AssignTo" class=" control-label col-md-4 text-left"> AssignTo </label>
										<div class="col-md-6">
										  <select name='UserIDs' rows='5' id='UserIDs' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 
				<?php } ?>					
									  <div class="form-group  " >
										<label for="Name" class=" control-label col-md-4 text-left"> Name <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('TaskName', $row['TaskName'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Note" class=" control-label col-md-4 text-left"> Note <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <textarea name='TaskNote' rows='5' id='TaskNote' class='form-control '  
				         required  >{{ $row['TaskNote'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					<?php $TaskStatus = explode(',',$row['TaskStatus']);
					$TaskStatus_opt = array( 'active' => 'Active' ,  'inactive' => 'Inactive' ,  'cancel' => 'Canceled' ,  'open' => 'Opened' ,  'suspend' => 'Suspended' , ); ?>
					<select name='TaskStatus' rows='5' required  class='select2 '  > 
						<?php 
						foreach($TaskStatus_opt as $key=>$val)
						{
							echo "<option  value ='$key' ".($row['TaskStatus'] == $key ? " selected='selected' " : '' ).">$val</option>"; 						
						}						
						?></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Start Date" class=" control-label col-md-4 text-left"> Start Date <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('StartDate', $row['StartDate'],array('class'=>'form-control date')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="End Date" class=" control-label col-md-4 text-left"> End Date <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('EndDate', $row['EndDate'],array('class'=>'form-control date')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="icon-checkmark-circle2"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="icon-bubble-check"></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('stask?return='.$return) }}' " class="btn btn-warning btn-sm "><i class="icon-cancel-circle2 "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#ProjectID").jCombo("{!! url('stask/comboselect?filter=sb_projects:ProjectID:ProjectName') !!}",
		{  selected_value : '{{ $row["ProjectID"] }}' });
		
		$("#UserIDs").jCombo("{!! url('stask/comboselect?filter=tb_users:id:last_name|first_name') !!}",
		{  selected_value : '{{ $row["UserIDs"] }}' });
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("stask/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop