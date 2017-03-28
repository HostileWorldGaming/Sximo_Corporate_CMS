<?php
use App\Library\Markdown;
?>
<section class="page-header">
	<div class="container">
		<h1> {{ strtoupper($pageTitle) }}</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">{{ $pageTitle }}</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<div class="container m-t">	

	<div class="row" style="padding-top:25px;">
		<div class="col-md-9 m-t">

					@if(Session::has('messagetext'))	  
						   {!! Session::get('messagetext') !!}
					@endif	
			@foreach ($rowData as $row)

			<div class="posts">
				<div class="title">
					<h3><a href="{{ url('post/view/'.$row->pageID.'/'.$row->alias)}}" > {{ $row->title }} </a> </h3>
				</div>
				<div class="info">
					<i class="fa fa-user"></i>  <span> {{ ucwords($row->username) }}  </span>   
					<i class="fa fa-calendar"></i>  <span> {{ date("M j, Y " , strtotime($row->created)) }} </span> 
					<i class="fa fa-comment-o "></i>   <span> <a href="{{ url('post/view/'.$row->pageID.'/'.$row->alias)}}#comments" > {{ $row->comments }}  comment(s) </a> </span> 
				</div>
				<div class="note">
				<?php

				$content = explode('<hr>', $row->note);
				if(count($content>=1))
				{
					echo PostHelpers::formatContent($content[0]);
				} else {
					//echo PostHelpers::formatContent($row->note);
				}
				?>

					 
				</div>

				<div class="labels"><br />
				<b>Articles In :  </b><br />
				<?php 
				foreach(explode(',',$row->labels) as $val)
				{
					echo '<a href="'.url('post/label/'.trim($val)).'" class="btn btn-xs btn-default"> '.trim($val).' </a> ';
				}
				?>
				</div>	

				<a href="{{ url('post/view/'.$row->pageID.'/'.$row->alias)}}" class="btn btn-default btn-sm pull-right">Read More <i class="fa fa-arrow-right"></i>  </a> 				
			 <hr />	
			 </div>          			 
			
            @endforeach
		</div>

		<div class="col-md-3">
			@include('post.widget')
		</div>

	</div>
</div>

<div class="text-center"> {!! $pagination->render() !!}</div>

