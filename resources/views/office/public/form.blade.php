

		 {!! Form::open(array('url'=>'office/savepublic', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Offices</legend>
				{!! Form::hidden('officeCode', $row['officeCode']) !!}					
									  <div class="form-group  " >
										<label for="City" class=" control-label col-md-4 text-left"> City <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('city', $row['city'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Phone" class=" control-label col-md-4 text-left"> Phone <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('phone', $row['phone'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="AddressLine1" class=" control-label col-md-4 text-left"> AddressLine1 </label>
										<div class="col-md-6">
										  {!! Form::text('addressLine1', $row['addressLine1'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="AddressLine2" class=" control-label col-md-4 text-left"> AddressLine2 </label>
										<div class="col-md-6">
										  {!! Form::text('addressLine2', $row['addressLine2'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="State" class=" control-label col-md-4 text-left"> State <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('state', $row['state'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Country" class=" control-label col-md-4 text-left"> Country <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('country', $row['country'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="PostalCode" class=" control-label col-md-4 text-left"> PostalCode </label>
										<div class="col-md-6">
										  {!! Form::text('postalCode', $row['postalCode'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Territory" class=" control-label col-md-4 text-left"> Territory </label>
										<div class="col-md-6">
										  {!! Form::text('territory', $row['territory'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
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
		
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
