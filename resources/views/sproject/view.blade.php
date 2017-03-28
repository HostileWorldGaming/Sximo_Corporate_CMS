@extends('layouts.app')

@section('content')
<?php
use \App\Http\Controllers\SprojectController;
?>
<div class="page-content row">
 	<div class="page-content-wrapper m-t">   

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><b>{{ $pageTitle }} : </b>  View Detail </a></li>
	@foreach($subgrid as $sub)
		<li role="presentation"><a href="#{{ str_replace(" ","_",$sub['title']) }}" aria-controls="profile" role="tab" data-toggle="tab"><b>{{ $pageTitle }}</b>  : {{ $sub['title'] }}</a></li>
	@endforeach
  </ul>

  <!-- Tab panes -->
  <div class="tab-content m-t">
  	<div role="tabpanel" class="tab-pane active" id="home">
  		
		<div class="sbox">
			<div class="sbox-title"> 
				<h5> {{ $pageTitle }} <small>{{ $pageNote }}</small></h5>
				<div class="sbox-tools" >
			   		<a href="{{ URL::to('sproject?return='.$return) }}" class="tips btn btn-xs btn-white pull-right" title="{{ Lang::get('core.btn_back') }}"><i class="icon-backward"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
					@if($access['is_add'] ==1)
			   		<a href="{{ URL::to('sproject/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-white pull-right" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
					@endif
				</div>	 
			</div>
			<div class="sbox-content" style="background:#fff;"> 	

 <div class="row">
	        <div class="col-md-9">


	            <div class="col-lg-12">
	                <div class="m-b-md">
	                    <h2>{{ $row->ProjectName}}</h2>
	                </div>
	                <dl class="dl-horizontal">
	                    <dt>Status:</dt> <dd>{!! SprojectController::Status($row->Status) !!}</dd>
	                </dl>
	            </div>


	            <div class="col-lg-5">
	                <dl class="dl-horizontal">

	                    <dt>Created by:</dt> <dd>Alex Smith</dd>
	                    <dt>Messages:</dt> <dd>  162</dd>
	                    <dt>Client:</dt> <dd>{{ SiteHelpers::formatLookUp($row->ClientID,'ClientID','1:sb_clients:ClientID:Company') }} </dd>
	                    <dt>Version:</dt> <dd>  v1.4.2 </dd>
	                </dl>
	            </div>
	            <div id="cluster_info" class="col-lg-7">
	                <dl class="dl-horizontal">

	                    <dt>Last Updated:</dt> <dd>{{ $row->LastUpdate}} </dd>
	                    <dt>Created:</dt> <dd>  {{ $row->Created}}  </dd>
	                    <dt>Participants:</dt>
	                    <dd class="project-people">
	                       	{!! SprojectController::showTeam($row->Teams) !!}
	                    </dd>
	                </dl>
	            </div>	

               <div class="row">
                    <div class="col-lg-12">
                        <dl class="dl-horizontal">
                            <dt>Completed:</dt>
                            <dd>
                                <div class="progress progress-striped active m-b-sm">
                                    <div class="progress-bar" style="width: {{ $row->Progress}}%;"></div>
                                </div>
                                <small>Project completed in <strong>{{ $row->Progress}}%</strong>. Remaining close the project, sign a contract and invoice.</small>
                            </dd>
                            <hr />

                          <dt> Description :</dt>
                            <dd>
                               {!! $row->Description !!} 
                            </dd>

                        </dl>
                    </div>
                </div>	            

	        </div>


	    </div>   

			
			</div>
		</div>	
  	</div>
  	@foreach($subgrid as $sub)
  		<div role="tabpanel" class="tab-pane" id="{{ str_replace(" ","_",$sub['title']) }}"></div>
  	@endforeach
  </div>


</div>
</div>


<script type="text/javascript">
	$(function(){
		<?php for($i=0 ; $i<count($subgrid); $i++)  :?>
			$('#{{ str_replace(" ","_",$subgrid[$i]['title']) }}').load('{{ url("sproject/lookup/".implode("-",$subgrid["$i"])."-".$id)}}')
		<?php endfor;?>
	})

</script>
	  
@stop