@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title">
		<div class="sbox-tools pull-left" >
	   		<a href="{{ url('employee?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
			@if($access['is_add'] ==1)
	   		<a href="{{ url('employee/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif 
					
		</div>	

		<div class="sbox-tools " >
			<a href="{{ ($prevnext['prev'] != '' ? url('employee/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('employee/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i>  </a>
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div>


	</div>
	<div class="sbox-content" > 	

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
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop