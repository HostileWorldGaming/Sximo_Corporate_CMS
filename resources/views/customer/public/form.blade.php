

		 {!! Form::open(array('url'=>'customer/savepublic', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-6">
						<fieldset><legend> Customer Info</legend>
				{!! Form::hidden('customerNumber', $row['customerNumber']) !!}					
									  <div class="form-group  " >
										<label for="Company" class=" control-label col-md-4 text-left"> Company <span class="asterix"> * </span></label>
										<div class="col-md-7">
										  <input  type='text' name='customerName' id='customerName' value='{{ $row['customerName'] }}' 
						required     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="LastName" class=" control-label col-md-4 text-left"> LastName </label>
										<div class="col-md-7">
										  <input  type='text' name='contactLastName' id='contactLastName' value='{{ $row['contactLastName'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="FirstName" class=" control-label col-md-4 text-left"> FirstName <span class="asterix"> * </span></label>
										<div class="col-md-7">
										  <div class="input-group"> <span class="input-group-addon">Mrs / Ms</span><input  type='text' name='contactFirstName' id='contactFirstName' value='{{ $row['contactFirstName'] }}' 
						required     class='form-control ' /></div> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Phone" class=" control-label col-md-4 text-left"> Phone <span class="asterix"> * </span></label>
										<div class="col-md-7">
										  <input  type='text' name='phone' id='phone' value='{{ $row['phone'] }}' 
						required     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Sales" class=" control-label col-md-4 text-left"> Sales <span class="asterix"> * </span></label>
										<div class="col-md-7">
										  <select name='salesRepEmployeeNumber' rows='5' id='salesRepEmployeeNumber' class='select2 ' required  ></select> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="CreditLimit" class=" control-label col-md-4 text-left"> CreditLimit </label>
										<div class="col-md-7">
										  <input  type='text' name='creditLimit' id='creditLimit' value='{{ $row['creditLimit'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			<div class="col-md-6">
						<fieldset><legend> Address</legend>
									
									  <div class="form-group  " >
										<label for="AddressLine1" class=" control-label col-md-4 text-left"> AddressLine1 </label>
										<div class="col-md-7">
										  <input  type='text' name='addressLine1' id='addressLine1' value='{{ $row['addressLine1'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="AddressLine2" class=" control-label col-md-4 text-left"> AddressLine2 </label>
										<div class="col-md-7">
										  <input  type='text' name='addressLine2' id='addressLine2' value='{{ $row['addressLine2'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="City" class=" control-label col-md-4 text-left"> City </label>
										<div class="col-md-7">
										  <input  type='text' name='city' id='city' value='{{ $row['city'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="State" class=" control-label col-md-4 text-left"> State </label>
										<div class="col-md-7">
										  <input  type='text' name='state' id='state' value='{{ $row['state'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Country" class=" control-label col-md-4 text-left"> Country </label>
										<div class="col-md-7">
										  <input  type='text' name='country' id='country' value='{{ $row['country'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="PostalCode" class=" control-label col-md-4 text-left"> PostalCode </label>
										<div class="col-md-7">
										  <input  type='text' name='postalCode' id='postalCode' value='{{ $row['postalCode'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
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
		
		
		$("#salesRepEmployeeNumber").jCombo("{!! url('customer/comboselect?filter=employees:employeeNumber:lastName|firstName') !!}",
		{  selected_value : '{{ $row["salesRepEmployeeNumber"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
