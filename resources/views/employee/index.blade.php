@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
  <div class="page-content row">

	
	<div class="page-content-wrapper m-t">	 	

	<div class="sbox">
	<div class="sbox-title">
		<div class="sbox-tools pull-left" >
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('employee/update?return='.$return) }}" class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa  fa-plus "></i></a>
			@endif  
			@if($access['is_remove'] ==1)
			<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_remove') }}">
			<i class="fa fa-trash-o"></i></a>
			@endif 
			<a href="{{ URL::to( 'employee/search?return='.$return) }}" class="btn btn-xs btn-default" onclick="SximoModal(this.href,'Advance Search'); return false;" title="{{ Lang::get('core.btn_search') }}"><i class="fa  fa-search"></i> </a>				


		</div>

		<div class="sbox-tools" >
			@if($access['is_excel'] ==1)
			<a href="{{ URL::to('employee/download?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_download') }}">
			<i class="fa fa-cloud-download"></i></a>
			@endif

			<a href="{{ url($pageModule) }}" class=" tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_clearsearch') }}" ><i class="fa fa-spinner"></i>  </a>		
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 
		</div>
	</div>

	<div class="sbox-content"> 	
	

	 {!! (isset($search_map) ? $search_map : '') !!}
	
	 {!! Form::open(array('url'=>'employee/delete/0?return='.$return, 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
	 <div class="table-responsive" style="min-height:300px;  padding-bottom:60px;">
    <table class="table table-striped ">
        <thead>
			<tr>
				<th class="number"><span> No </span> </th>
				<th> <input type="checkbox" class="checkall" /></th>
				<th ><span>{{ Lang::get('core.btn_action') }}</span></th>
				
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')				
						<?php $limited = isset($t['limited']) ? $t['limited'] :''; ?>
						@if(SiteHelpers::filterColumn($limited ))
						
							<th><span>{{ $t['label'] }}</span></th>			
						@endif 
					@endif
				@endforeach
				
			  </tr>
        </thead>

        <tbody>        						
            @foreach ($rowData as $row)
                <tr>
					<td width="30"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="ids[]" value="{{ $row->employeeNumber }}" />  </td>	
					<td>
					 	<div class="dropdown">
						  <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-cog"></i>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
						 	@if($access['is_detail'] ==1)
							<li><a href="{{ URL::to('employee/show/'.$row->employeeNumber.'?return='.$return)}}" class="tips" title="{{ Lang::get('core.btn_view') }}"><i class="fa  fa-search "></i> {{ Lang::get('core.btn_view') }} </a></li>
							@endif
							@if($access['is_edit'] ==1)
							<li><a  href="{{ URL::to('employee/update/'.$row->employeeNumber.'?return='.$return) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i> {{ Lang::get('core.btn_edit') }} </a></li>
							@endif
						  </ul>
						</div>

					</td>

				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1')
					 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
					 	@if(SiteHelpers::filterColumn($limited ))
						 <td>					 
						 	{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
						 </td>
						@endif	
					 @endif					 
				 @endforeach		 
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
	
@stop