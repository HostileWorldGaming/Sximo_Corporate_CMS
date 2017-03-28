{!! Form::open(array('url'=>'home/proccess/3', 'id'=>'formconfiguration','class'=>'form-vertical')) !!}
@if(Session::has('message'))	  
		{!! Session::get('message') !!}
@endif	
	
<ul class="parsley-error-list">
	@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
</ul>

<div class="form-group  " >
					<label for="ipt" class="  "> Email Address  </label>
				{!! Form::text('email','',array('class'=>'form-control', 'placeholder'=>'',   )) !!}
		</div>

		<div class="form-group  " >
					<label for="ipt" class="  "> Full Name  </label>
				{!! Form::text('name','',array('class'=>'form-control', 'placeholder'=>'',   )) !!}
		</div>

		<div class="form-group  " >
					<label for="ipt" class="  "> Sex  </label>
				
					<label class='radio radio-inline'>
					<input type='radio' name='sex' value ='pria' required  > Laki Laki </label>
					<label class='radio radio-inline'>
					<input type='radio' name='sex' value ='wanita' required  > Wanita </label>
		</div>

		<div class="form-group  " >
					<label for="ipt" class="  "> Adress  </label>
				{!! Form::text('jhjhj','',array('class'=>'form-control', 'placeholder'=>'',   )) !!}
		</div>

		<div class="form-group  " >
					<label for="ipt" class="  "> Select  </label>
				
					<?php 
					$select_opt = array( '1' => 'value 1' ,  '2' => 'Value2' ,  '3' => 'Value3' , ); ?>
					<select name='select' rows='5' required  class='form-control '  > 
						<?php 
						foreach($select_opt as $key=>$val)
						{
							echo "<option  value ='$key' >$val</option>"; 						
						}						
						?></select>
		</div>

		
		<div class="form-group  " >					
				<button type="submit" name="submit" class="btn btn-primary"><i class="icon-checkmark-circle2"></i> Submit </button>
		</div>

{!! Form::close() !!}