@extends('layouts.app')

@section('content')
<?php
use \App\Http\Controllers\SprojectController;
?>
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
  <div class="page-content row">

	
	<div class="page-content-wrapper m-t">	 	


<div class="sbox">
	
	<div class="sbox-title">
		<div class="sbox-tools pull-left" >
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('sproject/update?return='.$return) }}" class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa  fa-plus "></i></a>
			@endif  
			@if($access['is_remove'] ==1)
			<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_remove') }}">
			<i class="fa fa-trash-o"></i></a>
			@endif 
			<a href="{{ URL::to( 'sproject/search?return='.$return) }}" class="btn btn-xs btn-default" onclick="SximoModal(this.href,'Advance Search'); return false;" title="{{ Lang::get('core.btn_search') }}"><i class="fa  fa-search"></i> </a>				
		</div>

		<div class="sbox-tools" >
			@if($access['is_excel'] ==1)
			<a href="{{ URL::to('sproject/download?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_download') }}">
			<i class="fa fa-cloud-download"></i></a>
			@endif

			<a href="{{ url($pageModule) }}" class=" tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_clearsearch') }}" ><i class="fa fa-spinner"></i>  </a>		
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 
		</div> 
	</div>
	<div class="sbox-content"> 	
<section class="ribon-sximo"> 
	<div class="row m-l-none m-r-none m-t  white-bg shortcut ribon "  >
		<div class="col-sm-6 col-md-3  p-sm ribon-module">
			<span class="pull-left m-r-sm "><i class="icon-folder-plus2"></i></span> 
			<a href="#" class="clear">
				<span class="h3 block m-t-xs"><strong>  Open ( {{ $pS->Opened }} )  </strong>
				</span>  Opened Projects - {{ ($pS->Opened*100)/$pS->Total }}% </small>
			</a>
		</div>
		<div class="col-sm-6 col-md-3   p-sm ribon-setting">
			<span class="pull-left m-r-sm">	<i class="icon-folder8"></i></span>
			<a href="#" class="clear">
				<span class="h3 block m-t-xs"><strong> Closed ( {{ $pS->Closed }}  ) </strong>
				</span> <small >   Closed Projects  - {{ ($pS->Closed*100)/$pS->Total }}%   </small> 
			</a>
		</div>
		<div class="col-sm-6 col-md-3   p-sm ribon-module">
			<span class="pull-left m-r-sm  ">	<i class="icon-folder-minus2"></i></span>
			<a href="#" class="clear">
			<span class="h3 block m-t-xs"><strong>  Suspended ( {{ $pS->Suspended }} )  </strong></span>
			<small>  Supended Projects  - {{ ($pS->Suspended*100)/$pS->Total }}%   </small> </a>
		</div>
		<div class="col-sm-6 col-md-3  p-sm ribon-users">
			<span class="pull-left m-r-sm ">	<i class="icon-folder-remove"></i></span>
			<a href="#" class="clear">
			<span class="h3 block m-t-xs"><strong> Canceled (  {{ $pS->Canceled }} ) </strong>
			</span> <small >  Canceled Projects  - {{ ($pS->Canceled*100)/$pS->Total }}%  </small> </a>
		</div>
	</div> 
</section>

<ul class="nav nav-tabs" style="margin-bottom:10px;" >
   <li class=" pull-right"><a href="{{ url('sclient')}}"><i class="icon-users"></i>All Clients </a></li> 
   <li class=" pull-right"><a href="{{ url('stask')}}"><i class="icon-pencil"></i> All Tasks </a></li>
   <li class="active pull-right"><a href="{{ url('sproject')}}" ><i class="icon-stats-up"></i>All Projects </a></li>
</ul> 
 
 



	 {!! (isset($search_map) ? $search_map : '') !!}
	
	 {!! Form::open(array('url'=>'sproject/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
	 <div class="table-responsive" style="min-height:300px;">
    <table class="table table-striped ">
        <thead>
			<tr>
				<th class="number"><span> No </span> </th>
				<th> <input type="checkbox" class="checkall" /></th>
				
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')				
						<?php $limited = isset($t['limited']) ? $t['limited'] :''; ?>
						@if(SiteHelpers::filterColumn($limited ))
							@if($t['field'] =='Teams')
							<th width="150" class="text-right"><span> {{ $t['field'] }} </span></th>
							@else
							<th><span>{{ $t['label'] }}</span></th>			
							@endif
						@endif 
					@endif
				@endforeach
				<th width="70" ><span>{{ Lang::get('core.btn_action') }}</span></th>
			  </tr>
        </thead>

        <tbody>        						
            @foreach ($rowData as $row)
                <tr>
					<td width="30"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="ids[]" value="{{ $row->ProjectID }}" />  </td>									
				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1')
					 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
					 	@if(SiteHelpers::filterColumn($limited ))
						 <td>
						 @if($field['field'] =='ProjectName')
						 	{{ $row->ProjectName }} <br />
						 	<small><b>Created : {{ date("d.m.Y",strtotime($row->Created ))}}</b> </small>
						 @elseif($field['field'] =='Status')
							 {!! SprojectController::Status($row->Status) !!}
						 @elseif($field['field'] =='Tasks')
							 <a href="{{ url('stask?search=ProjectID:equal:'.$row->ProjectID)}}" class="btn btn-success"> {!! $row->Tasks !!} </a>	 
						 @elseif($field['field'] =='Teams')
						 	<div class="text-right"> 
						 		{!! SprojectController::showTeam($row->Teams) !!}
						 	</div>	
						 @elseif($field['field'] =='Progress')
					 		<small>Completion with: {{ $row->Progress}}%</small>
					 		<div class="progress progress-mini">
                                <div class="progress-bar" style="width: {{ $row->Progress}}%;"></div>
                            </div>
						 @else		 
						 	{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
						 @endif
						 </td>
						@endif	
					 @endif					 
				 @endforeach
				 <td>
					 	@if($access['is_detail'] ==1)
						<a href="{{ URL::to('sproject/show/'.$row->ProjectID.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_view') }}"><i class="fa  fa-search "></i></a>
						@endif
						@if($access['is_edit'] ==1)
						<a  href="{{ URL::to('sproject/update/'.$row->ProjectID.'?return='.$return) }}" class="tips btn btn-xs btn-success" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i></a>
						@endif
												
					
				</td>				 
                </tr>
				
            @endforeach
              
        </tbody>
      
    </table>
	<input type="hidden" name="md" value="" />
	</div>
	{!! Form::close() !!}
	@include('footer')
	</div>
</div>	
	</div>	  
</div>	
<style type="text/css">
		.table tbody tr td{ padding-top:10px; line-height: 20px; padding-bottom: 10px;  }

</style>
<script>
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("sproject/multisearch")}}');
		$('#SximoTable').submit();
	});
	
});	
</script>		
@stop