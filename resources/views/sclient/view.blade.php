@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title"><h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3> 
	<div class="sbox-tools" >
   		<a href="{{ URL::to('sclient?return='.$return) }}" class="tips btn btn-xs btn-white pull-right" title="{{ Lang::get('core.btn_back') }}"><i class="icon-backward"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
		@if($access['is_add'] ==1)
   		<a href="{{ URL::to('sclient/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-white pull-right" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
		@endif 
	</div>	
	</div>
	<div class="sbox-content" style="background:#fff;"> 	

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
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop