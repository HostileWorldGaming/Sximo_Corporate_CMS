<div class="sbox">
	<div class="sbox-title"><h4><small>Current Module : </small>   {{ $row->module_title }} </h4></div>
	<div class="sbox-content">	
	
	{!! Form::open(array('url'=>'sximo/module/duplicate/'.$row->module_id, 'class'=>'form-horizontal ')) !!}
		<input  type='text' name='module_id' id='module_id'  value='{{ $row->module_id }}'  style="display:none; " />
		<div class="form-group">
			<label for="ipt" class=" control-label col-md-4">Name / Title </label>
			<div class="col-md-8">	
			<b> {{	 $row->module_title }} </b><br />
			<input  type='text' name='module_title' id='module_title' class="form-control " placeholder="new title" required value=''  /> 
		 	</div> 
		</div>  

		

		<div class="form-group">
		<label for="ipt" class=" control-label col-md-4">Module Note</label>
		<div class="col-md-8">
		<b>{{ $row->module_note }}</b><br />
			<input  type='text' name='module_note' id='module_note'  value='' placeholder="new note" class="form-control "  />
		 </div> 
		</div>    	

		<div class="form-group">
		<label for="ipt" class=" control-label col-md-4">Class Controller </label>
		<div class="col-md-8">
		<b>{{ $row->module_name }}</b><br />
		<input  type='text' name='module_name' id='module_name'  class="form-control " placeholder="new controller" required value=''  />
		 </div> 
		</div>  

		<div class="form-group">
			<label for="ipt" class=" control-label col-md-4"></label>
			<div class="col-md-8">

				<button type="submit" name="submit" class="btn btn-primary"><i class="icon-copy4"></i> Submit </button>
			</div> 
		</div> 
	{!! Form::close() !!}
	</div>
</div>		