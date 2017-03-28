@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title">
		<div class="sbox-tools pull-left" >
	   		<a href="{{ url('core/forms?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
			@if($access['is_add'] ==1)
	   		<a href="{{ url('core/forms/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif 
					
		</div>	

		<div class="sbox-tools " >
			<a href="{{ ($prevnext['prev'] != '' ? url('core/forms/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('core/forms/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i>  </a>
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('core/sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div>


	</div>
	<div class="sbox-content" > 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>Name</td>
						<td>{{ $row->name}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Method</td>
						<td>{{ $row->method}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tablename</td>
						<td>{{ $row->tablename}} </td>
						
					</tr>
					<tr>
						<td width='30%' class='label-view text-right'>Send To Email </td>
						<td>{{ $row->email}} </td>
						
					</tr>					
				
					<tr>
						<td width='30%' class='label-view text-right'>Success</td>
						<td>{{ $row->success}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Failed</td>
						<td>{{ $row->failed}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Redirect</td>
						<td>{{ $row->redirect}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

		<div  style="background: #e9e9e9; min-height: 600px; border: solid 1px #ddd;padding: 20px;" > 			
				<div class="col-md-2"></div>
				<div class="col-md-8" style=" border:solid 1px #ddd; background: #fff;" id="formConfig">
					<div style="padding: 20px;"> 
					
					 @include('core.forms.forms.form-'.$row->formID)
					</div>
				</div>
				<div class="col-md-2"></div>
		</div>		 
	
	
	</div>
</div>	

	</div>
</div>
	  
@stop