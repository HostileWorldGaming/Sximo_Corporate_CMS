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
						<td width='30%' class='label-view text-right'>ProjectName</td>
						<td>{{ $row->ProjectName}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Description</td>
						<td>{{ $row->Description}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ClientID</td>
						<td>{{ SiteHelpers::formatLookUp($row->ClientID,'ClientID','1:sb_clients:ClientID:Company') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status</td>
						<td>{{ $row->Status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Progress</td>
						<td>{{ $row->Progress}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Teams</td>
						<td>{{ $row->Teams}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created</td>
						<td>{{ $row->Created}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LastUpdate</td>
						<td>{{ $row->LastUpdate}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>DueDate</td>
						<td>{{ $row->DueDate}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	