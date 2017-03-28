@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
  <div class="page-content row">
    <!-- Page header -->

	
	
	<div class="page-content-wrapper m-t">	 	

<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h5> <i class="fa fa-comment"></i>  All Forums </h5>
		<div class="sbox-tools" >


			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('sximoforum/update') }}" class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa  fa-plus "></i></a>
			@endif  
			@if($access['is_remove'] ==1)
			<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_remove') }}">
			<i class="fa fa-trash-o"></i></a>
			@endif 
			
			<a href="{{ url($pageModule) }}" class=" tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_clearsearch') }}" ><i class="fa fa-spinner"></i>  </a>	

			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		


		</div>
	</div>
	<div class="sbox-content"> 	
		
		 {!! Form::open(array('url'=>'sximoforum/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}

		<table class="table table-striped table-bordered" >
        <thead>
			<tr>
				@if($access['is_remove'] ==1)
				<th> <input type="checkbox" class="checkall" /></th>
				@endif
				<th> Forum </th>
				<th>  </th>
				<th> Posts </th>
				<th> <button class="btn btn-white btn-sm">  <i class="icon-bubbles6"></i> </button> </th>
				@if($access['is_remove'] ==1)
					<th width="85"><button class="btn btn-white btn-sm"> <i class="icon-cog2"></i></button>  </th>
				@endif

				
			</tr>
		</thead>		
		<tbody>	
		@foreach ($forums as $row)
			<tr>
				@if($access['is_remove'] ==1)
					<td><input type="checkbox" class="ids" name="ids[]" value="{{ $row['ForumID'] }}" /></td>
				@endif
				<td colspan="3" > 
					<h3>{{ $row['Name'] }}</h3>
					<div class="p-t p-b" style="padding: 5px 0 10px;">
					{!! $row['Note'] !!}
					</div>
				</td>
				<td></td>
				@if($access['is_edit'] ==1)
				<td>
						<a  href="{{ URL::to('sximoforum/update/'.$row['ForumID'].'?return='.$return) }}" class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-pencil "></i></a>
				</td>		
				@endif
				
			</tr>
			@if($access['is_add'] ==1)
			<tr>
				@if($access['is_remove'] ==1)<td></td>@endif
				<td colspan="4">
				<div style="padding: 10px 0; text-align: right;">
				@if($access['is_add'] ==1)
					<a href="{{ url('sximoforum/addtopic/'.$row['ForumID'])}}" onclick="SximoModal(this.href,'Create New Post'); return false;" class="btn btn-success btn-xs"><i class="icon-plus-circle2"></i> New {{ $row['Name'] }}  </a>
				@endif	
				</div>	
				</td>
				
				@if($access['is_remove'] ==1)<td></td>@endif
				
			</tr>	
			@endif		
			@foreach($row['categories'] as $cat)
			<tr>
				@if($access['is_remove'] ==1)<td></td>@endif
				<td> <a href="{!! url('sximoforum/topic/'.$cat['CategoryID'])!!}"><b>{{ $cat['Name'] }}</b> </a></td>
				<td> {!! $cat['Note'] !!}</td>
				<td><a href=""> {{ $cat['Posts'] }} </a></td>
				<td> {{ $cat['Comments'] }}</td>
				
				@if($access['is_remove'] ==1)
				<td>
					<a  href="{{ URL::to('sximoforum/deletetopic/'.$cat['CategoryID'].'?return='.$return) }}" class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-remove confirmDelete"></i></a>	
				</td>
				@endif

				
				
			</tr>

			@endforeach


		@endforeach 
		</tbody>
		</table>

	
		{!! Form::close() !!}

	 
	</div>
</div>	
	</div>	  
</div>	
<script>
$(document).ready(function(){
  $('.confirmDelete').click(function(){
    if(confirm( ' Are u sure delete comment')){
      return true;
    } else {
      return false;
    }
    return false;
  });
});	
</script>		
@stop