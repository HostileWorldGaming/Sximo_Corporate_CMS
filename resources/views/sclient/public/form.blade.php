

		 {!! Form::open(array('url'=>'sclient/savepublic', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Clients</legend>
				{!! Form::hidden('ClientID', $row['ClientID']) !!}					
									  <div class="form-group  " >
										<label for="Company" class=" control-label col-md-4 text-left"> Company <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('Company', $row['Company'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="About" class=" control-label col-md-4 text-left"> About </label>
										<div class="col-md-6">
										  <textarea name='About' rows='5' id='About' class='form-control '  
				           >{{ $row['About'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Contact Person" class=" control-label col-md-4 text-left"> Contact Person <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('Contact', $row['Contact'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Logo" class=" control-label col-md-4 text-left"> Logo </label>
										<div class="col-md-6">
										  <input  type='file' name='Logo' id='Logo' @if($row['Logo'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['Logo'],'/uploads/images/') !!}
						
						</div>					
					 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Owner" class=" control-label col-md-4 text-left"> Owner </label>
										<div class="col-md-6">
										  <select name='UserID' rows='5' id='UserID' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			

			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
				  </div>	  
			
		</div> 
		 
		 {!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#UserID").jCombo("{!! url('sclient/comboselect?filter=tb_users:id:last_name|first_name') !!}",
		{  selected_value : '{{ $row["UserID"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
