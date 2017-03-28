@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title">
		<div class="sbox-tools pull-left" >
	   		<a href="{{ url('product?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
			@if($access['is_add'] ==1)
	   		<a href="{{ url('product/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif 
					
		</div>	

		<div class="sbox-tools " >
			<a href="{{ ($prevnext['prev'] != '' ? url('product/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('product/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i>  </a>
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div>


	</div>
	<div class="sbox-content" > 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>Code</td>
						<td>{{ $row->productCode}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Name</td>
						<td>{{ $row->productName}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Line</td>
						<td>{{ $row->productLine}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Scale</td>
						<td>{{ $row->productScale}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Vendor</td>
						<td>{{ $row->productVendor}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Description</td>
						<td>{{ $row->productDescription}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Qty</td>
						<td>{{ $row->quantityInStock}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Price</td>
						<td>{{ $row->buyPrice}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MSRP</td>
						<td>{{ $row->MSRP}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop