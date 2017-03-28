@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title">
		<div class="sbox-tools pull-left" >
	   		<a href="{{ url('orderdetail?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
			@if($access['is_add'] ==1)
	   		<a href="{{ url('orderdetail/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif 
					
		</div>	

		<div class="sbox-tools " >
			<a href="{{ ($prevnext['prev'] != '' ? url('orderdetail/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('orderdetail/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i>  </a>
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div>


	</div>
	<div class="sbox-content" > 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>OrderNumber</td>
						<td>{{ $row->orderNumber}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ProductCode</td>
						<td>{{ SiteHelpers::formatLookUp($row->productCode,'productCode','1:products:productCode:productName') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>QuantityOrdered</td>
						<td>{{ $row->quantityOrdered}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PriceEach</td>
						<td>{{ $row->priceEach}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>OrderLineNumber</td>
						<td>{{ $row->orderLineNumber}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop