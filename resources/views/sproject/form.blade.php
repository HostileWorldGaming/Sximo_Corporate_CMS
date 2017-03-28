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

		 {!! Form::open(array('url'=>'sproject/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Projects Manager</legend>
				{!! Form::hidden('ProjectID', $row['ProjectID']) !!}					
									  <div class="form-group  " >
										<label for="ProjectName" class=" control-label col-md-4 text-left"> ProjectName <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('ProjectName', $row['ProjectName'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Description" class=" control-label col-md-4 text-left"> Description <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <textarea name='Description' rows='5' id='editor' class='form-control editor '  
						required >{{ $row['Description'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="ClientID" class=" control-label col-md-4 text-left"> ClientID <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <select name='ClientID' rows='5' id='ClientID' class='select2 ' required  ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					<?php $Status = explode(',',$row['Status']);
					$Status_opt = array( 'open' => 'Open' ,  'close' => 'Closed' ,  'suspend' => 'Suspended' ,  'cancel' => 'Canceled' , ); ?>
					<select name='Status' rows='5' required  class='select2 '  > 
						<?php 
						foreach($Status_opt as $key=>$val)
						{
							echo "<option  value ='$key' ".($row['Status'] == $key ? " selected='selected' " : '' ).">$val</option>"; 						
						}						
						?></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Progress" class=" control-label col-md-4 text-left"> Progress </label>
										<div class="col-md-6">
										  {!! Form::text('Progress', $row['Progress'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Teams" class=" control-label col-md-4 text-left"> Teams </label>
										<div class="col-md-6">
										  <select name='Teams[]' multiple rows='5' id='Teams' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="DueDate" class=" control-label col-md-4 text-left"> DueDate </label>
										<div class="col-md-6">
										  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('DueDate', $row['DueDate'],array('class'=>'form-control date')) !!}
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
					<button type="button" onclick="location.href='{{ URL::to('sproject?return='.$return) }}' " class="btn btn-warning btn-sm "><i class="icon-cancel-circle2 "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#ClientID").jCombo("{!! url('sproject/comboselect?filter=sb_clients:ClientID:Company') !!}",
		{  selected_value : '{{ $row["ClientID"] }}' });
		
		$("#Teams").jCombo("{!! url('sproject/comboselect?filter=tb_users:id:last_name|first_name') !!}",
		{  selected_value : '{{ $row["Teams"] }}' });
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("sproject/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop