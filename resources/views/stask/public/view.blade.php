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
						<td width='30%' class='label-view text-right'>AssignTo</td>
						<td>{{ $row->UserIDs}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Name</td>
						<td>{{ $row->TaskName}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Note</td>
						<td>{{ $row->TaskNote}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status</td>
						<td>{{ $row->TaskStatus}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created</td>
						<td>{{ date('Y/m/d',strtotime($row->Created)) }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>StartDate</td>
						<td>{{ date('Y/m/d',strtotime($row->StartDate)) }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>EndDate</td>
						<td>{{ date('Y/m/d',strtotime($row->EndDate)) }} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	