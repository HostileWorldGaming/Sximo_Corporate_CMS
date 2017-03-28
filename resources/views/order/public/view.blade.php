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
						<td width='30%' class='label-view text-right'>Date</td>
						<td>{{ $row->orderDate}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Required Date</td>
						<td>{{ $row->requiredDate}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Shipped Date</td>
						<td>{{ $row->shippedDate}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status</td>
						<td>{{ $row->status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Comments</td>
						<td>{{ $row->comments}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Customer</td>
						<td>{{ SiteHelpers::formatLookUp($row->customerNumber,'customerNumber','1:customers:customerNumber:customerName') }} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	