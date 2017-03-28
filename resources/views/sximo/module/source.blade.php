 @extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery.fileTree/jqueryFileTree.js') }}"></script>	
<link href="{{ asset('sximo/js/plugins/jquery.fileTree/jqueryFileTree.css') }}" rel="stylesheet">

  <div class="page-content row ">


 	<div class="page-content-wrapper m-t"> 
 	<div class="ajaxLoading"></div>
 	@include('sximo.module.tab',array('active'=>'source','type'=> 'addon'))
 		<div class="sbox">
 		<div class="sbox-title"><h4> {{ $row->module_title }} <small> : Source Code Editor</small></h4> </div>
 		<div class="sbox-content">
	 		<div class="row">
	 			<div class="col-md-3">
				<div id="container_id"></div>

	 			</div>

	 			<div class="col-md-9">
	 				<div style="padding:10px; background:#fff; min-height:300px; border:solid 1px #ddd;display:none;" class="result">
	 				{!! Form::open(array('url'=>'sximo/module/code/'.$module_name, 'class'=>'form-horizontal','id'=>'FormCode' )) !!}
	 					<b> File Location : </b> <span class="file_location text-danger"></span>  <hr />
	 					<div class="message"></div>
	 					<textarea id="content_html" name="content_html" class="form-control markItUp" rows="20"></textarea>
	 					<input type="hidden" name="path" class="path" value="" >
	 					<br />
	 					<button class="btn btn-primary"> Save Change(s) </button>
	 				{!! Form::close() !!}	

	 				</div>

	 			</div>
			</div> 		
 		</div>
 		</div>

	</div>
</div>


<script type="text/javascript">
    $(document).ready( function() {
        $('#container_id').fileTree({
            root: '/{{ $module_name}}/',
            script: '{{ url("sximo/module/source/folder")}}',
            expandSpeed: 1000,
            collapseSpeed: 1000,
            multiFolder: false
        }, function(file) {
        	$('.ajaxLoading').show();	
        	$.get( "{{ url('sximo/module/code/'.$module_name)}}",{ path:file}, function( data ) {
        		$('#content_html').val(data.content);
        		$('.file_location').html(data.path);
        		$('.path').val(data.path);
				 $('.ajaxLoading').hide();	
				 $('.result').show();
			});
           
        });

		var form = $('#FormCode'); 
		form.parsley();
		form.submit(function(){
			
			if(form.parsley('isValid') == true){			
				var options = { 
					dataType:      'json', 
					beforeSubmit :  showRequest,
					success:       showResponse  
				}  
				$(this).ajaxSubmit(options); 
				return false;
							
			} else {
				return false;
			}		
		
		});        
    });



	

function showRequest()
{
	$('.ajaxLoading').show();		
}  
function showResponse(data)  {		
	
	if(data.status == 'success')
	{	
		$('.ajaxLoading').hide();
		$('.message').html(data.message);
					
	} else {
		//$('.message').html(data.message)	
		$('.ajaxLoading').hide();
		$('.message').html(data.message);
	}	
}	


</script>

@stop
