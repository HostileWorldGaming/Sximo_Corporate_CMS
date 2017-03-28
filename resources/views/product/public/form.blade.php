

		 {!! Form::open(array('url'=>'product/savepublic', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Products</legend>
				{!! Form::hidden('productId', $row['productId']) !!}					
									  <div class="form-group  " >
										<label for="ProductCode" class=" control-label col-md-4 text-left"> ProductCode </label>
										<div class="col-md-7">
										  {!! Form::text('productCode', $row['productCode'],array('class'=>'form-control','id'=>'productCode', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="ProductName" class=" control-label col-md-4 text-left"> ProductName </label>
										<div class="col-md-7">
										  {!! Form::text('productName', $row['productName'],array('class'=>'form-control','id'=>'productName', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="ProductLine" class=" control-label col-md-4 text-left"> ProductLine </label>
										<div class="col-md-7">
										  {!! Form::text('productLine', $row['productLine'],array('class'=>'form-control','id'=>'productLine', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="ProductScale" class=" control-label col-md-4 text-left"> ProductScale </label>
										<div class="col-md-7">
										  {!! Form::text('productScale', $row['productScale'],array('class'=>'form-control','id'=>'productScale', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="ProductVendor" class=" control-label col-md-4 text-left"> ProductVendor </label>
										<div class="col-md-7">
										  {!! Form::text('productVendor', $row['productVendor'],array('class'=>'form-control','id'=>'productVendor', 'placeholder'=>'',   )) !!} 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="ProductDescription" class=" control-label col-md-4 text-left"> ProductDescription </label>
										<div class="col-md-7">
										  <textarea name='productDescription' rows='5' id='productDescription' class='form-control '  
				           >{{ $row['productDescription'] }}</textarea> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="BuyPrice" class=" control-label col-md-4 text-left"> BuyPrice </label>
										<div class="col-md-7">
										  <div class="input-group"> <span class="input-group-addon">$</span>{!! Form::text('buyPrice', $row['buyPrice'],array('class'=>'form-control','id'=>'buyPrice', 'placeholder'=>'',   )) !!}</div> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="QuantityInStock" class=" control-label col-md-4 text-left"> QuantityInStock </label>
										<div class="col-md-7">
										  <div class="input-group">{!! Form::text('quantityInStock', $row['quantityInStock'],array('class'=>'form-control','id'=>'quantityInStock', 'placeholder'=>'',   )) !!} <span class="input-group-addon">pcs</span></div> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="MSRP" class=" control-label col-md-4 text-left"> MSRP </label>
										<div class="col-md-7">
										  {!! Form::text('MSRP', $row['MSRP'],array('class'=>'form-control','id'=>'MSRP', 'placeholder'=>'',   )) !!} 
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
		
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
