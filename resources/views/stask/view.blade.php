@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title"><h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3> 
	<div class="sbox-tools" >
   		<a href="{{ URL::to('stask?return='.$return) }}" class="tips btn btn-xs btn-white pull-right" title="{{ Lang::get('core.btn_back') }}"><i class="icon-backward"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
		@if($access['is_add'] ==1)
   		<a href="{{ URL::to('stask/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-white pull-right" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
		@endif 
	</div>	
	</div>
	<div class="sbox-content" style="background:#fff;"> 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>Created</td>
						<td>{{ date('Y/m/d',strtotime($row->Created)) }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>AssignTo</td>
						<td>{{ SiteHelpers::formatLookUp($row->UserIDs,'UserIDs','1:tb_users:id:last_name|first_name') }} </td>
						
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
						<td width='30%' class='label-view text-right'>StartDate</td>
						<td>{{ date('Y/m/d',strtotime($row->StartDate)) }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ProjectID</td>
						<td>{{ SiteHelpers::formatLookUp($row->ProjectID,'ProjectID','1:sb_projects:ProjectID:ProjectName') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>EndDate</td>
						<td>{{ date('Y/m/d',strtotime($row->EndDate)) }} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop