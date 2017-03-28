<div class="m-t" style="padding-top:25px;">	
    <div class="row m-b-lg animated fadeInDown delayp1 text-center">
        <h3> {{ $pageTitle }} <small> {{ $pageNote }} </small></h3>
        <hr />       
    </div>
</div>
<div class="m-t">
	<div class="table-responsive" > 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
			
					<tr>
						<td width='30%' class='label-view text-right'>OrderNumber</td>
						<td>{{ $row->orderNumber}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ProductCode</td>
						<td>{{ SiteHelpers::formatLookUp($row->productCode,'productCode','1:products:productCode:productName') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>QuantityOrdered</td>
						<td>{{ $row->quantityOrdered}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PriceEach</td>
						<td>{{ $row->priceEach}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>OrderLineNumber</td>
						<td>{{ $row->orderLineNumber}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	