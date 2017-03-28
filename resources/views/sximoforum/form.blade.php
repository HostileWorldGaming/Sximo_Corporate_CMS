@extends('layouts.app')

@section('content')

  <div class="page-content row">
 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
		<div class="sbox-content"> 	

		 {!! Form::open(array('url'=>'sximoforum/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Sximo Forum</legend>

									  {!! Form::hidden('ForumID', $row['ForumID'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					
								  <div class="form-group  " >
									<label for="Name" class=" control-label col-md-4 text-left"> Forum Name </label>
									<div class="col-md-6">
									  {!! Form::text('Name', $row['Name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Note" class=" control-label col-md-4 text-left"> Description </label>
									<div class="col-md-6">
									  {!! Form::textarea('Note', $row['Note'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Icon" class=" control-label col-md-4 text-left"> Icon </label>
									<div class="col-md-6">
									  {!! Form::text('Icon', $row['Icon'],array('class'=>'form-control', 'placeholder'=>'','style="width:30%"'   )) !!} 

									  <p> {{ Lang::get('core.fr_mexample') }} : <span class="label label-info"> icon-windows8 </span>  , <span class="label label-info"> fa fa-cloud-upload </span> </p>
					  <p> {{ Lang::get('core.fr_musage') }} 
					  <a href="{{ url('core/template?show=icons')}}" target="_blank"> Font Awesome </a>  and <a href="{{ url('core/template?show=icon-moon')}}" target="_blank"> Icomoon </a> class name</p>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Color" class=" control-label col-md-4 text-left"> Color </label>
									<div class="col-md-6">
									  {!! Form::text('Color', $row['Color'],array('class'=>'form-control', 'placeholder'=>'',  'style="width:30%"'  )) !!} 

									  <p> {{ Lang::get('core.fr_mexample') }} : #ff9900 </p>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Active" class=" control-label col-md-4 text-left"> Active </label>
									<div class="col-md-6">
									   
									  <input type="radio" name="Active" value="1" @if($row['Active'] ==1) checked @endif > Active
									  <input type="radio" name="Active" value="0" @if($row['Active'] ==0) checked @endif> InActive

									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> </fieldset>
			</div>
			
			

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('sximoforum?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop