<?php

$tabs = array(
		'' 		        => '<i class="icon-info2"></i> '. Lang::get('core.tab_siteinfo'),
		'email'			=> '<i class="icon-envelop"></i> '. Lang::get('core.tab_email'),
		'security'		=> '<i class="icon-switch"></i> '. Lang::get('core.tab_loginsecurity') ,
		'translation'	=>'<i class="icon-flag"></i> Translation',
		'log'			=>'<i class="icon-remove3"></i> '. Lang::get('Clear Cache & Logs')
	);

?>

<ul class="nav nav-tabs" >
@foreach($tabs as $key=>$val)
	<li  @if($key == $active) class="active" @endif><a href="{{ URL::to('sximo/config/'.$key)}}"> {!! $val !!}  </a></li>
@endforeach

</ul>