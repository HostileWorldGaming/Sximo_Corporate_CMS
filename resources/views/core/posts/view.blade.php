@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title">
		<div class="sbox-tools pull-left" >
	   		<a href="{{ url('core/posts?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
			@if($access['is_add'] ==1)
	   		<a href="{{ url('core/posts/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif 
					
		</div>	

		<div class="sbox-tools " >
			<a href="{{ ($prevnext['prev'] != '' ? url('core/posts/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('core/posts/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i>  </a>
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div>


	</div>
	<div class="sbox-content" > 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>PageID</td>
						<td>{{ $row->pageID}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Title</td>
						<td>{{ $row->title}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Alias</td>
						<td>{{ $row->alias}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Note</td>
						<td>{{ $row->note}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created</td>
						<td>{{ $row->created}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Updated</td>
						<td>{{ $row->updated}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Filename</td>
						<td>{{ $row->filename}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status</td>
						<td>{{ $row->status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Access</td>
						<td>{{ $row->access}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Allow Guest</td>
						<td>{{ $row->allow_guest}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Template</td>
						<td>{{ $row->template}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Metakey</td>
						<td>{{ $row->metakey}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Metadesc</td>
						<td>{{ $row->metadesc}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Default</td>
						<td>{{ $row->default}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Pagetype</td>
						<td>{{ $row->pagetype}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Labels</td>
						<td>{{ $row->labels}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop