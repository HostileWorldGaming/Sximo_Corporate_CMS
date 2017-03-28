{!! Form::open(array('url'=>'home/proccess/{form_ID}', 'id'=>'formconfiguration','class'=>'form-vertical' ,'files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
@if(Session::has('message'))	  
		{!! Session::get('message') !!}
@endif	
	
<ul class="parsley-error-list">
	@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
</ul>

{forms}
		<div class="form-group  " >					
				<button type="submit" name="submit" class="btn btn-primary"><i class="icon-checkmark-circle2"></i> Submit </button>
		</div>

{!! Form::close() !!}

<link href="{{ asset('sximo/js/plugins/iCheck/skins/square/red.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{ asset('sximo/js/plugins/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('input[type="checkbox"],input[type="radio"]').iCheck({
			checkboxClass: 'icheckbox_square-red',
			radioClass: 'iradio_square-red',
		});	
	});

	{javascript}
</script>