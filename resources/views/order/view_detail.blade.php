@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ url('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ url('order?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper m-t">   

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"> View Detail </a></li>
	@foreach($subgrid as $sub)
		<li role="presentation"><a href="#{{ str_replace(" ","_",$sub['title']) }}" aria-controls="profile" role="tab" data-toggle="tab">{{ $sub['title'] }}</a></li>
	@endforeach
  </ul>

  <!-- Tab panes -->
  <div class="tab-content m-t">
  	<div role="tabpanel" class="tab-pane active" id="home">
  		
		<div class="sbox">
			<div class="sbox-title"> 
		   		<a href="{{ URL::to('order?return='.$return) }}" class="tips btn btn-xs btn-default pull-right" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
				@if($access['is_add'] ==1)
		   		<a href="{{ URL::to('order/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary pull-right" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
				@endif 
			</div>
			<div class="sbox-content" style="background:#fff;"> 	

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