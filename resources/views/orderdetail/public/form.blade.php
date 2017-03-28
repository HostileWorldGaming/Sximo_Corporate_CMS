

		 {!! Form::open(array('url'=>'orderdetail/savepublic', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Order Details</legend>
									
									  <div class="form-group  " >
										<label for="OrderDetailId" class=" control-label col-md-4 text-left"> OrderDetailId </label>
										<div class="col-md-6">
										  {!! Form::text('orderDetailId', $row['orderDetailId'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="OrderNumber" class=" control-label col-md-4 text-left"> OrderNumber </label>
										<div class="col-md-6">
										  {!! Form::text('orderNumber', $row['orderNumber'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="ProductCode" class=" control-label col-md-4 text-left"> ProductCode <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <select name='productCode' rows='5' id='productCode' class='select2 ' required  ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="QuantityOrdered" class=" control-label col-md-4 text-left"> QuantityOrdered <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('quantityOrdered', $row['quantityOrdered'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="PriceEach" class=" control-label col-md-4 text-left"> PriceEach <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('priceEach', $row['priceEach'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="OrderLineNumber" class=" control-label col-md-4 text-left"> OrderLineNumber </label>
										<div class="col-md-6">
										  {!! Form::text('orderLineNumber', $row['orderLineNumber'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
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
		
		
		$("#productCode").jCombo("{!! url('orderdetail/comboselect?filter=products:productCode:productName') !!}",
		{  selected_value : '{{ $row["productCode"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
