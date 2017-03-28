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
						<td width='30%' class='label-view text-right'>Id</td>
						<td>{{ $row->id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Userid</td>
						<td>{{ $row->userid}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Url</td>
						<td>{{ $row->url}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Note</td>
						<td>{{ $row->note}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created</td>
						<td>{{ $row->created}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Icon</td>
						<td>{{ $row->icon}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Is Read</td>
						<td>{{ $row->is_read}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	