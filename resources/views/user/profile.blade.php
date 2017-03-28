@extends('layouts.app')

@section('content')


  <div class="page-content row">
		
	<div class="page-content-wrapper m-t">
	@if(Session::has('message'))	  
		   {!! Session::get('message') !!}
	@endif	
	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>	
	<ul class="nav nav-tabs" >
	  <li class="active"><a href="#info" data-toggle="tab"> {{ Lang::get('core.personalinfo') }} </a></li>
	  <li ><a href="#pass" data-toggle="tab">{{ Lang::get('core.changepassword') }} </a></li>
	</ul>	
	
	<div class="tab-content">
	  <div class="tab-pane active m-t" id="info">
		{!! Form::open(array('url'=>'user/saveprofile/', 'class'=>'form-horizontal ' ,'files' => true)) !!}  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> Username </label>
			<div class="col-md-8">
			<input name="username" type="text" id="username" disabled="disabled" class="form-control input-sm" required  value="{{ $info->username }}" />  
			 </div> 
		  </div>  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.email') }} </label>
			<div class="col-md-8">
			<input name="email" type="text" id="email"  class="form-control input-sm" value="{{ $info->email }}" /> 
			 </div> 
		  </div> 	  
	  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.firstname') }} </label>
			<div class="col-md-8">
			<input name="first_name" type="text" id="first_name" class="form-control input-sm" required value="{{ $info->first_name }}" /> 
			 </div> 
		  </div>  
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.lastname') }} </label>
			<div class="col-md-8">
			<input name="last_name" type="text" id="last_name" class="form-control input-sm" required value="{{ $info->last_name }}" />  
			 </div> 
		  </div>    
	
		  <div class="form-group  " >
			<label for="ipt" class=" control-label col-md-4 text-right"> Avatar </label>
			<div class="col-md-8">
			
			  
					<input type="file" name="avatar">
				
			
			 Image Dimension 80 x 80 px <br />
			{!! SiteHelpers::showUploadedFile($info->avatar,'/uploads/users/') !!}
			
			 </div> 
		  </div>  
	
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
			<div class="col-md-8">
				<button class="btn btn-success" type="submit"> {{ Lang::get('core.sb_savechanges') }}</button>
			 </div> 
		  </div> 	
		
		{!! Form::close() !!}	
	  </div>
  
	  <div class="tab-pane  m-t" id="pass">
		{!! Form::open(array('url'=>'user/savepassword/', 'class'=>'form-horizontal ')) !!}    
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.newpassword') }} </label>
			<div class="col-md-8">
			<input name="password" type="password" id="password" class="form-control input-sm" value="" /> 
			 </div> 
		  </div>  
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.conewpassword') }}  </label>
			<div class="col-md-8">
			<input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value="" />  
			 </div> 
		  </div>    
		 
		
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
			<div class="col-md-8">
				<button class="btn btn-danger" type="submit"> {{ Lang::get('core.sb_savechanges') }} </button>
			 </div> 
		  </div>   
		{!! Form::close() !!}	
	  </div>
  


</div>
</div>
 
 </div>

@endsection