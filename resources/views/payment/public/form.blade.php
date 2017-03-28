

		 {!! Form::open(array('url'=>'payment/savepublic', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Payments</legend>
				{!! Form::hidden('paymentId', $row['paymentId']) !!}					
									  <div class="form-group  " >
										<label for="CustomerNumber" class=" control-label col-md-4 text-left"> CustomerNumber <span class="asterix"> * </span></label>
										<div class="col-md-7">
										  <select name='customerNumber' rows='5' id='customerNumber' class='select2 ' required  ></select> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="CheckNumber" class=" control-label col-md-4 text-left"> CheckNumber <span class="asterix"> * </span></label>
										<div class="col-md-7">
										  {!! Form::text('checkNumber', $row['checkNumber'],array('class'=>'form-control','id'=>'checkNumber', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="PaymentDate" class=" control-label col-md-4 text-left"> PaymentDate </label>
										<div class="col-md-7">
										  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('paymentDate', $row['paymentDate'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
				 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Amount" class=" control-label col-md-4 text-left"> Amount <span class="asterix"> * </span></label>
										<div class="col-md-7">
										  <div class="input-group"> <span class="input-group-addon">USD</span>{!! Form::text('amount', $row['amount'],array('class'=>'form-control','id'=>'amount', 'placeholder'=>'', 'required'=>'true'  )) !!} <span class="input-group-addon">.00</span></div> 
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
		
		
		$("#customerNumber").jCombo("{!! url('payment/comboselect?filter=customers:customerNumber:customerName') !!}",
		{  selected_value : '{{ $row["customerNumber"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
