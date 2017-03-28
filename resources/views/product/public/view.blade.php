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
						<td width='30%' class='label-view text-right'>Code</td>
						<td>{{ $row->productCode}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Name</td>
						<td>{{ $row->productName}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Line</td>
						<td>{{ $row->productLine}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Scale</td>
						<td>{{ $row->productScale}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Vendor</td>
						<td>{{ $row->productVendor}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Description</td>
						<td>{{ $row->productDescription}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Qty</td>
						<td>{{ $row->quantityInStock}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Price</td>
						<td>{{ $row->buyPrice}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MSRP</td>
						<td>{{ $row->MSRP}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	