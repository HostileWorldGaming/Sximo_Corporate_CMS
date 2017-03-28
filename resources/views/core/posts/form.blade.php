@extends('layouts.app')

@section('content')

  <div class="page-content row">
    <!-- Page header -->

 
 	<div class="page-content-wrapper m-t">


<div class="sbox">
	<div class="sbox-title"> 
		<div class="sbox-tools pull-left" >
			<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_back') }}" ><i class="fa  fa-arrow-left"></i></a> 
		</div>
		<div class="sbox-tools " >
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/posts') }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div> 

	</div>
	<div class="sbox-content"> 	

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>	

		 {!! Form::open(array('url'=>'core/posts/save?return='.$return, 'class'=>'form-vertical','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
			<div class="col-md-9">

						<ul class="nav nav-tabs m-b" >
						  <li class="active"><a href="#info" data-toggle="tab"><i class="fa  fa-info-circle"></i> Page Content </a></li>
						  <li ><a href="#meta" data-toggle="tab"><i class="fa fa-sitemap"></i> Meta & Description </a></li>
						  <li ><a href="#image" data-toggle="tab"><i class="fa fa-picture-o"></i> Images </a></li>
						</ul>	

					<div class="tab-content">
						  <div class="tab-pane active m-t" id="info">

							{!! Form::hidden('pageID', $row['pageID']) !!}		
							{!! Form::hidden('pagetype', 'post') !!}
							{!! Form::hidden('pageID', $row['pageID']) !!}			
									  <div class="form-group  " >
										<label > Post Title    </label>									
										  {!! Form::text('title', $row['title'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 						
									  </div> 					
									  <div class="form-group  " >
										<label for="ipt" class=" btn-primary  btn btn-sm">  {!! url('post/read/')!!}  </label>							
											 
										  {!! Form::text('alias', $row['alias'],array('class'=>'form-control', 'placeholder'=>'', 'style'=>'width:150px; display:inline-block;'   )) !!} 						
											
									  </div> 					
									  <div class="form-group  " >
										<label > Post Content    </label>							
										  <textarea name='note' rows='25' id='note' class='form-control editor'  
				           >{{ $row['note'] }}</textarea> 						
									  </div> 					
									   					
							</div>
							<div class="tab-pane m-t" id="meta">		  					
									  <div class="form-group  " >
										<label > Metakey    </label>
										 <textarea name='metakey' rows='5' id='metakey' class='form-control '  
				           >{{ $row['metakey'] }}</textarea> 						
									  </div> 					
									  <div class="form-group  " >
										<label > Metadesc    </label>									
										  <textarea name='metadesc' rows='5' id='metadesc' class='form-control '  
				           >{{ $row['metadesc'] }}</textarea> 						
									  </div> 	
							</div>

							<div class="tab-pane m-t" id="image">
								<div class="form-group  " >
									<label > Images    </label>
									<input type="file" name="image"></input> 	
									{!! SiteHelpers::showUploadedFile($row['image'],'/uploads/images/') !!}					
								  </div>


							</div>

					</div>	
			</div>
			
			<div class="col-md-3">
						
							  <div class="form-group  " >
								<label> Post Status :  </label>
								<label class="radio  ">					
								  <input  type='radio' name='status'  value="enable" required
								  @if( $row['status'] =='enable')  	checked	  @endif				  
								   /> 
								  Enable
								</label> 
								<label class="radio">					
								  <input  type='radio' name='status'  value="disable" required
								   @if( $row['status'] =='disable')  	checked	  @endif				  
								   /> 
								  Disabled
								</label> 					 
							  </div>									
									   					
									  <div class="form-group  " >
										<label for="ipt" class=" control-label "> Created    </label>								  
										<div class="input-group m-b" style="width:150px !important;">
											{!! Form::text('created', $row['created'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) !!}
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>				 						
									  </div> 					

									  <div class="form-group  " >
									  <label for="ipt"> Who can view this page ? </label>
										@foreach($groups as $group) 
										<label class="checkbox">					
										  <input  type='checkbox' name='group_id[{{ $group['id'] }}]'    value="{{ $group['id'] }}"
										  @if($group['access'] ==1 or $group['id'] ==1)
										  	checked
										  @endif				 
										   /> 
										  {{ $group['name'] }}
										</label>  
										@endforeach	
											  
									  </div>
 		
									   <div class="form-group  " >
										<label> Show for Guest ? unlogged  </label>
										<label class="checkbox"><input  type='checkbox' name='allow_guest' 
					 						@if($row['allow_guest'] ==1 ) checked  @endif	
										   value="1"	/> Allow Guest ?  </lable>
									  </div>			



				<div class="form-group  " >
					<label > Labels    </label>									
					  <textarea name='labels' rows='2' id='labels' class='form-control '>{{ $row['labels'] }}</textarea> 						
				</div>


					
				  <div class="form-group">
					
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="icon-checkmark-circle2"></i> Apply</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="icon-bubble-check"></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('core/posts?return='.$return) }}' " class="btn btn-warning btn-sm "><i class="icon-cancel-circle2 "></i>  {{ Lang::get('core.sb_cancel') }} </button>
						
				</div>	

			
			</div>
			<div style="clear:both;"></div> 
		 {!! Form::close() !!}	
	</div>
</div>		 
</div>	
</div>		
<style type="text/css">
	.form-control { background-color: #f9f9f9 !important; }
</style>	 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("posts/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>	

<style type="text/css">
.note-editor { border: solid 1px #eee }
.note-editor .note-toolbar { border-bottom: none !important; }
.note-editor .note-editable { height:500px; }
.note-editor .note-codable { background-color: #fafafa; color: #333; }

</style>			 
@stop