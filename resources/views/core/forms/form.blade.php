@extends('layouts.app')

@section('content')

  <div class="page-content row">
    <!-- Page header --> 
 	<div class="page-content-wrapper m-t">

<div class="sbox">
	<div class="sbox-title"> 
		<div class="sbox-tools pull-left" >
			<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_back') }}" ><i class="fa  fa-arrow-left"></i></a> 
			<a class="btn btn-xs btn-default tips" title="Documentation" href="{{ url('core/forms/docs') }}" onclick="SximoModal(this.href,'Documentation'); return false;"><i class="fa fa-book"></i></a>
		</div>
		<div class="sbox-tools " >
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('core/sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div> 

	</div>
	<div class="sbox-content"> 	

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>	

		 {!! Form::open(array('url'=>'core/forms/save?return='.$return, 'class'=>'form-vertical','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-3">
						<fieldset><legend> Basic Form</legend>
				{!! Form::hidden('formID', $row['formID']) !!}					
									  <div class="form-group  " >
										<label for="ipt" class=" control-label "> Form Name  <span class="asterix"> * </span>  </label>									
										  {!! Form::text('name', $row['name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 						
									  </div> 					
									  <div class="form-group  methodstore" >
										<label for="ipt" class=" control-label "> Save Submited form to  <span class="asterix"> * </span>  </label>									
										  <br />
												
												<label class='radio radio-inline'>
												<input type='radio' name='method' value ='table' required @if($row['method'] == 'table') checked="checked" @endif > Database </label> <br />
												<label class='radio radio-inline'>
												<input type='radio' name='method' value ='email' required @if($row['method'] == 'email') checked="checked" @endif > Send To Email </label> 						
									  </div> 					
									  <div class="form-group  " id="tablename" >
										<label for="ipt" class=" control-label "> Tablename    </label>										{!! Form::select('tablename', $tables , $row['tablename'] , 
													array('class'=>'form-control ', 'required'=>'true' )); 
												!!}					
									  </div> 					
									  <div class="form-group  " id="email"  >
										<label for="ipt" class=" control-label "> Email Address    </label>									
										  {!! Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 						
									  </div> 
									  <div class="form-group  " >
										<label for="ipt" class=" control-label "> After save Redirect to ?    </label>									
										  {!! Form::text('redirect', $row['redirect'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
										  <i style="font-size: 9px; " class="text-success"> Leave blank or (.) mark if want to stay on current page after submited </i>						
									  </div>

									  <div class="form-group  " >
										<label for="ipt" class=" control-label "> Successed Note  <span class="asterix"> * </span>  </label>									
										  <textarea name='success' rows='3' id='success' class='form-control '  
				         required  >{{ $row['success'] }}</textarea> 						
									  </div> 					
									  <div class="form-group  " >
										<label for="ipt" class=" control-label "> Failed Note  <span class="asterix"> * </span>  </label>									
										  <textarea name='failed' rows='3' id='failed' class='form-control '  
				         required  >{{ $row['failed'] }}</textarea> 						
									  </div> 	


									   <div class="form-group" style="margin-bottom: 30px;">
					
					
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="icon-checkmark-circle2"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="icon-bubble-check"></i> {{ Lang::get('core.sb_save') }}</button>
					
					
					<div style="clear:both"></div>	  
			
				  </div>

									  </fieldset>
			</div>
			
			<div class="col-md-9" style="background: #e9e9e9; min-height: 600px; border: solid 1px #ddd;" > 		
			
				<div style="padding: 15px 5px;  " id="formConfig">					

				</div>
			
			</div>

			

		
			<div style="clear:both"></div>	

					
				  
		 
		 {!! Form::close() !!}

		 
			

		  </div>

		</div>
			
			 
	
</div>		 
</div>	
</div>			
<style type="text/css">
	ul.availableinput { padding: 0; margin-bottom: 0; list-style: none; }
	ul.availableinput li{ }
	ul.availableinput li a{ color: #777; display: block; padding: 5px 10px; border: solid 1px #eee; border-bottom: none;  background: #fff; }

</style> 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		//$('#formConfig').get('{{ url("forms/configuration/".$row["formID"]) }}');
		<?php if($row['formID'] !='') { ?>
		$.get( '{{ url("core/forms/configuration/".$row["formID"]) }}', function( data ) {
			  $( '#formConfig' ).html( data );
			 
			});
		<?php } ?>
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("core/forms/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});	

		//$('#tablename').hide();
		$('.methodstore input:radio').on('ifClicked', function() {
		  val = $(this).val(); 
		 
			if(val == 'table')
			{
				$('#tablename').show();	
				$('#email').hide();
			} else if( val =='email') {
				$('#email').show();	
				$('#tablename').hide();		

			} else {
				$('#tablename').hide();	
				$('#email').hide();
			}		  
		  
		});			
		
	});
	</script>		 
@stop