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
						<td width='30%' class='label-view text-right'>Logo</td>
						<td>{!! SiteHelpers::formatRows($row->Logo,$fields['Logo'],$row ) !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Company</td>
						<td>{{ $row->Company}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>About</td>
						<td>{{ $row->About}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Contact</td>
						<td>{{ $row->Contact}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Owner</td>
						<td>{{ SiteHelpers::formatLookUp($row->UserID,'UserID','1:tb_users:id:last_name|first_name') }} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	