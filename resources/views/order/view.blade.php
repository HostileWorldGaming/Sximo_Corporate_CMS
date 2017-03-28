@extends('layouts.app')

@section('content')
<div class="page-content row">
 	<div class="page-content-wrapper m-t">   

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><b>{{ $pageTitle }} : </b>  View Detail </a></li>
	@foreach($subgrid as $sub)
		<li role="presentation"><a href="#{{ str_replace(" ","_",$sub['title']) }}" aria-controls="profile" role="tab" data-toggle="tab"><b>{{ $pageTitle }}</b>  : {{ $sub['title'] }}</a></li>
	@endforeach
  </ul>

  <!-- Tab panes -->
  <div class="tab-content m-t">
  	<div role="tabpanel" class="tab-pane active" id="home">
  		
		<div class="sbox">
			<div class="sbox-title"> 
				<div class="sbox-tools pull-left" >
			   		<a href="{{ url('order?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
					@if($access['is_add'] ==1)
			   		<a href="{{ url('order/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
					@endif 
							
				</div>	

				<div class="sbox-tools " >
					<a href="{{ ($prevnext['prev'] != '' ? url('order/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>	
					<a href="{{ ($prevnext['next'] != '' ? url('order/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i>  </a>
					@if(Session::get('gid') ==1)
						<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
					@endif 			
				</div> 
			</div>
			<div class="sbox-content" > 	

				<table class="table table-striped table-bordered" >
					<tbody>	
				
					<tr>
						<td width='30%' class='label-view text-right'>Date</td>
						<td>{{ $row->orderDate}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Required Date</td>
						<td>{{ $row->requiredDate}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Shipped Date</td>
						<td>{{ $row->shippedDate}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status</td>
						<td>{{ $row->status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Comments</td>
						<td>{{ $row->comments}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Customer</td>
						<td>{{ SiteHelpers::formatLookUp($row->customerNumber,'customerNumber','1:customers:customerNumber:customerName') }} </td>
						
					</tr>
				
						
					</tbody>	
				</table>   
			
			</div>
		</div>	
  	</div>
  	@foreach($subgrid as $sub)
  		<div role="tabpanel" class="tab-pane" id="{{ str_replace(" ","_",$sub['title']) }}"></div>
  	@endforeach
  </div>


</div>
</div>


<script type="text/javascript">
	$(function(){
		<?php for($i=0 ; $i<count($subgrid); $i++)  :?>
			$('#{{ str_replace(" ","_",$subgrid[$i]['title']) }}').load('{{ url("order/lookup/".implode("-",$subgrid["$i"])."-".$id)}}')
		<?php endfor;?>
	})

</script>
	  
@stop