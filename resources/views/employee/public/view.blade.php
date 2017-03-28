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
						<td width='30%' class='label-view text-right'>Photo</td>
						<td>{!! SiteHelpers::formatRows($row->photo,$fields['photo'],$row ) !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LastName</td>
						<td>{{ $row->lastName}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FirstName</td>
						<td>{{ $row->firstName}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JobTitle</td>
						<td>{{ $row->jobTitle}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Extension</td>
						<td>{{ $row->extension}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Email</td>
						<td>{{ $row->email}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>OfficeCode</td>
						<td>{{ SiteHelpers::formatLookUp($row->officeCode,'officeCode','1:offices:officeCode:officeCode|city') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ReportsTo</td>
						<td>{{ SiteHelpers::formatLookUp($row->reportsTo,'reportsTo','1:employees:employeeNumber:lastName|firstName') }} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	