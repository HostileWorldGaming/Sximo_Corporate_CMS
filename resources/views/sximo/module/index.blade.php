@extends('layouts.app')

@section('content')
<div class="page-content row">

	<div class="page-content-wrapper">
	<div class="ribon-sximo">
		<section >

				<div class="row m-l-none m-r-none m-t  white-bg shortcut " >
					<div class="col-sm-3  p-sm ribon-setting">
						<span class="pull-left m-r-sm "><i class="icon-folder-plus3"></i></span> 
						<a href="{{ URL::to('sximo/module/create') }}" class="clear">
							<span class="h3 block m-t-xs"><strong> {{ Lang::get('core.btn_create') }} Module </strong>
							</span> <small > {{ Lang::get('core.fr_createmodule') }}  </small>
						</a>
					</div>				
					<div class="col-sm-3  p-sm ribon-white">
						<span class="pull-left m-r-sm "><i class="icon-folder-upload2"></i></span>
						<a href="javascript:void(0)" class="clear " onclick="$('.unziped').toggle()">
							<span class="h3 block m-t-xs"><strong>{{ Lang::get('core.btn_install') }} Module </strong>
							</span> <small >{{ Lang::get('core.fr_installmodule') }} </small> 
						</a>
					</div>				
					<div class="col-sm-3   p-sm ribon-module">
						<span class="pull-left m-r-sm "><i class="icon-folder-download2"></i></span>
						<a href="{{ URL::to('sximo/module/package') }}" class="clear post_url">
							<span class="h3 block m-t-xs"><strong>{{ Lang::get('core.btn_backup') }} Module</strong>
							</span> <small > {{ Lang::get('core.fr_backupmodule') }} </small> 
						</a>
					</div>					
					<div class="col-sm-6 col-md-3  p-sm ribon-white">
						<span class="pull-left m-r-sm "><i class="icon-database"></i></span>
						<a href="{{ URL::to('sximo/tables') }}" >
							<span class="h3 block m-t-xs"><strong>Database</strong>
							</span> <small > Manage Database Tables </small> 
						</a>
					</div>	


				</div> 

		</section>			
	</div>
	@if(Session::has('message'))
		   {{ Session::get('message') }}
	@endif	
      <div class="white-bg p-sm m-b unziped" style=" border:solid 1px #ddd; display:none;">
	   {!! Form::open(array('url'=>'sximo/module/install/', 'class'=>'breadcrumb-search','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
		<h3>Select File ( Module zip installer ) </h3>
        <p>  <input type="file" name="installer" required style="float:left;">  <button type="submit" class="btn btn-primary btn-xs" style="float:left;"  ><i class="icon-upload"></i> Install</button></p>
        </form>
		<div class="clr"></div>
      </div>

 	<ul class="nav nav-tabs" style="margin-bottom:10px;">
	  <li @if($type =='addon') class="active" @endif><a href="{{ URL::to('sximo/module')}}"><i class="icon-table"></i> {{ Lang::get('core.tab_installed') }}  </a></li>
	  <li @if($type =='core') class="active" @endif><a href="{{ URL::to('sximo/module?t=core')}}"><i class="icon-table"></i> {{ Lang::get('core.tab_core') }}</a></li>
	</ul>     

	@if($type =='core')

		 <div class="infobox infobox-info fade in">
		  <button type="button" class="close" data-dismiss="alert"> x </button>  
		  <p>   Do not <b>Rebuild</b> or Change any Core Module </p>	
		</div>	
		 
	@endif
	 {!! Form::open(array('url'=>'sximo/module/package#', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) !!}
	<div class="table-responsive ibox-content" style="min-height:400px;">
	@if(count($rowData) >=1) 
		<table class="table table-striped ">
			<thead>
			<tr>
				<th>Action</th>					
				<th><input type="checkbox" class="checkall" /></th>
				<th>Module</th>
				@if($type =='addon')<th>Shortcode</th>@endif
				<th>Controller</th>
				<th>Database</th>
				<th>PRI</th>
				<th>Created</th>
		
			</tr>
			</thead>
        <tbody>
		@foreach ($rowData as $row)
			<tr>		
				<td>
				<div class="btn-group">
				<button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
				<I class="icon-cogs"></I> <span class="caret"></span>
				</button>
					<ul style="display: none;" class="dropdown-menu icons-right">
						@if($type != 'core')
						<li><a href="{{ URL::to($row->module_name)}}"><i class="icon-play2"></i> {{ Lang::get('core.btn_view') }} Module </a></li>
						<li><a href="{{ URL::to('sximo/module/duplicate/'.$row->module_id)}}" onclick="SximoModal(this.href,'Duplicate/Clone Module'); return false;" ><i class="icon-copy4"></i> Duplicate/Clone </a></li>						
						@endif
						<li><a href="{{ URL::to('sximo/module/config/'.$row->module_name)}}"><i class="icon-pencil4"></i> {{ Lang::get('core.btn_edit') }}</a></li>	
						
						@if($type != 'core')
						<li><a href="javascript://ajax" onclick="SximoConfirmDelete('{{ URL::to('sximo/module/destroy/'.$row->module_id)}}')"><i class="icon-remove5"></i> {{ Lang::get('core.btn_remove') }}</a></li>
						<li class="divider"></li>
						<li><a href="{{ URL::to('sximo/module/rebuild/'.$row->module_id)}}"><i class="icon-spinner7"></i> Rebuild All Codes</a></li>
						@endif
					</ul>
				</div>					
				</td>
				<td>
				 
				<input type="checkbox" class="ids" name="id[]" value="{{ $row->module_id }}" /> </td>
				<td>{{ $row->module_title }} </td>
				@if($type =='addon')
				<td> 
				<div style="font-size: 10px"> 
					<b>Form Shortcode : </b><?php echo "!!SximoHelpers|showForm|'".$row->module_name."'!!"; ?><br />
					<b>Table Shortcode : </b>
					<?php echo htmlentities('<php>');?> use \App\Http\Controllers\<?php echo ucwords($row->module_name).'Controller;';?> <br />
					<?php echo ' echo '.ucwords($row->module_name).'Controller::display();'. htmlentities('</php>') ; ?>
					
					
				</div>
				</td>
				@endif
				<td>{{ $row->module_name }} </td>

				<td>{{ $row->module_db }} </td>
				<td>{{ $row->module_db_key }} </td>
				<td>{{ $row->module_created }} </td>
			</tr>
		@endforeach	
	</tbody>		
	</table>
	
	@else
		
		<p class="text-center" style="padding:50px 0;">{{ Lang::get('core.norecord') }} 
		<br /><br />
		<a href="{{ URL::to('sximo/module/create')}}" class="btn btn-default "><i class="icon-plus-circle2"></i> New module </a>
		 </p>	
	@endif
	</div>	
	{!! Form::close() !!}


</div>	

  <script language='javascript' >
  jQuery(document).ready(function($){
    $('.post_url').click(function(e){
      e.preventDefault();
      if( ( $('.ids',$('#SximoTable')).is(':checked') )==false ){
        alert( $(this).attr('data-title') + " not selected");
        return false;
      }
      $('#SximoTable').attr({'action' : $(this).attr('href') }).submit();
    });


  })
  </script>	 

@stop