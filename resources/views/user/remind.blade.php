@extends('layouts.login')

@section('content')

<div class="sbox ">
	<div class="sbox-title"><h4 >{{ CNF_APPNAME }} <small> {{ CNF_APPDESC }} </small></h4></div>
	<div class="sbox-content">
		<div class="login-box">
		{!! Form::open(array('url' => 'user/doreset/'.$verCode, 'class'=>'form-vertical sky-form boxed')) !!}

			    	@if(Session::has('message'))
						{!! Session::get('message') !!}
					@endif

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>	


			<div class="form-group has-feedback animated fadeInLeft delayp1">
				<label>New Password	</label>
				{!! Form::password('password',  array('class'=>'form-control', 'placeholder'=>'New Password')) !!}
				
				<i class="fa fa-lock form-control-feedback"></i>
			</div>

			<div class="form-group has-feedback animated fadeInLeft delayp1">
				<label>Re-type Password	</label>
				{!! Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) !!}
				<i class="fa fa-lock form-control-feedback"></i>
			</div>

			<div class="form-group has-feedback animated fadeInLeft delayp1">
				<label>	</label>
				<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Submit </button>
			</div>			

<p class="text-center ">
			  <a href="{{url('')}}" class="btn btn-white"> {{ Lang::get('core.backtosite') }} </a>  
		   		</p>				
			
			 {!! Form::close() !!}
		</div>
</div>

</div>

@stop