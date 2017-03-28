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
						<td width='30%' class='label-view text-right'>Customer</td>
						<td>{{ SiteHelpers::formatLookUp($row->customerNumber,'customerNumber','1:customers:customerNumber:customerName') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>CheckNumber</td>
						<td>{{ $row->checkNumber}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PaymentDate</td>
						<td>{{ $row->paymentDate}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Amount</td>
						<td>{{ $row->amount}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	