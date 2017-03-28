@extends('layouts.app')

@section('content')
  <div class="page-content row">
 
	
	 <div class="page-content-wrapper m-t">    
		<div class="">
			<div id="elfinder"></div>
		</div>
	</div>	

</div>


<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/pepper-grinder/jquery-ui.css" />
<script type="text/javascript" src="{{ asset('sximo/js/plugins/elfinder/js/elfinder.min.js') }}"></script>
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo/js/plugins/elfinder/css/elfinder.min.css')}}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo/js/plugins/elfinder/css/theme.css')}}" />




<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        var elf = $('#elfinder').elfinder({
            // lang: 'ru',             // language (OPTIONAL)
            url : '{{ url("core/elfinder") }}'  ,// connector URL (REQUIRED)
			height:500,
        }).elfinder('instance');            
    });
</script>
@stop