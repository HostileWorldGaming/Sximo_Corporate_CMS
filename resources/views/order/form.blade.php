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
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div> 

	</div>
	<div class="sbox-content"> 	

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>	

		 {!! Form::open(array('url'=>'order/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-6">
						<fieldset><legend> Detail</legend>
				{!! Form::hidden('orderNumber', $row['orderNumber']) !!}					
									  <div class="form-group  " >
										<label for="OrderDate" class=" control-label col-md-4 text-left"> OrderDate <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('orderDate', $row['orderDate'],array('class'=>'form-control date')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="RequiredDate" class=" control-label col-md-4 text-left"> RequiredDate <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('requiredDate', $row['requiredDate'],array('class'=>'form-control date')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="ShippedDate" class=" control-label col-md-4 text-left"> ShippedDate </label>
										<div class="col-md-6">
										  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('shippedDate', $row['shippedDate'],array('class'=>'form-control date')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  {!! Form::text('status', $row['status'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			<div class="col-md-6">
						<fieldset><legend> Customer</legend>
									
									  <div class="form-group  " >
										<label for="Customer" class=" control-label col-md-4 text-left"> Customer <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <select name='customerNumber' rows='5' id='customerNumber' class='select2 ' required  ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Comments" class=" control-label col-md-4 text-left"> Comments </label>
										<div class="col-md-6">
										  <textarea name='comments' rows='5' id='comments' class='form-control '  
				           >{{ $row['comments'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			

					
	<hr />
	<div class="clr clear"></div>
	
	<h5> Order Detail </h5>
	
	<div class="table-responsive">
    <table class="table table-striped ">
        <thead>
			<tr>
				@foreach ($subform['tableGrid'] as $t)
					@if($t['view'] =='1' && $t['field'] !='orderNumber')
						<th>{{ $t['label'] }}</th>
					@endif
				@endforeach
				<th></th>	
			  </tr>

        </thead>

        <tbody>
        @if(count($subform['rowData'])>=1)
            @foreach ($subform['rowData'] as $rows)
            <tr class="clone clonedInput">
									
			 @foreach ($subform['tableGrid'] as $field)
				 @if($field['view'] =='1' && $field['field'] !='orderNumber')
				 <td>					 
				 	{!! SiteHelpers::bulkForm($field['field'] , $subform['tableForm'] , $rows->{$field['field']}) !!}							 
				 </td>
				 @endif					 
			 
			 @endforeach
			 <td>
			 	<a onclick=" $(this).parents('.clonedInput').remove(); return false" href="#" class="remove btn btn-xs btn-danger">-</a>
			 	<input type="hidden" name="counter[]">
			 </td>
			@endforeach
			</tr> 

		@else
            <tr class="clone clonedInput">
									
			 @foreach ($subform['tableGrid'] as $field)

				 @if($field['view'] =='1' && $field['field'] !='orderNumber')
				 <td>					 
				 	{!! SiteHelpers::bulkForm($field['field'] , $subform['tableForm'] ) !!}							 
				 </td>
				 @endif					 
			 
			 @endforeach
			 <td>
			 	<a onclick=" $(this).parents('.clonedInput').remove(); return false" href="#" class="remove btn btn-xs btn-danger">-</a>
			 	<input type="hidden" name="counter[]">
			 </td>
			
			</tr> 

		
		@endif	


        </tbody>	

     </table>  
     <input type="hidden" name="enable-masterdetail" value="true">
     </div>
	<br /><br />
     
     <a href="javascript:void(0);" class="addC btn btn-xs btn-info" rel=".clone"><i class="fa fa-plus"></i> New Item</a>
     <hr />
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="icon-checkmark-circle2"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="icon-bubble-check"></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('order?return='.$return) }}' " class="btn btn-warning btn-sm "><i class="icon-cancel-circle2 "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		$('.addC').relCopy({});
		
		$("#customerNumber").jCombo("{!! url('order/comboselect?filter=customers:customerNumber:customerName') !!}",
		{  selected_value : '{{ $row["customerNumber"] }}' });
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("order/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop