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
			   		<a href="{{ url('{class}?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
					@if($access['is_add'] ==1)
			   		<a href="{{ url('{class}/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
					@endif 
							
				</div>	

				<div class="sbox-tools " >
					<a href="{{ ($prevnext['prev'] != '' ? url('{class}/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>	
					<a href="{{ ($prevnext['next'] != '' ? url('{class}/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i>  </a>
					@if(Session::get('gid') ==1)
						<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
					@endif 			
				</div> 
			</div>
			<div class="sbox-content" > 	

				<table class="table table-striped table-bordered" >
					<tbody>	
				{form_view}
						
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
			$('#{{ str_replace(" ","_",$subgrid[$i]['title']) }}').load('{{ url("{class}/lookup/".implode("-",$subgrid["$i"])."-".$id)}}')
		<?php endfor;?>
	})

</script>
	  
@stop