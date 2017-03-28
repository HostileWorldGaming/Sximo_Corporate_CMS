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
						<td width='30%' class='label-view text-right'>City</td>
						<td>{{ $row->city}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Phone</td>
						<td>{{ $row->phone}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>AddressLine1</td>
						<td>{{ $row->addressLine1}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>AddressLine2</td>
						<td>{{ $row->addressLine2}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>State</td>
						<td>{{ $row->state}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Country</td>
						<td>{{ $row->country}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PostalCode</td>
						<td>{{ $row->postalCode}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Territory</td>
						<td>{{ $row->territory}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	