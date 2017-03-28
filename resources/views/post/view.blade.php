<section class="page-header">
	<div class="container">
		<h1> {{ strtoupper($pageTitle) }}</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li><a href="{{ url('post')}}"> Posts </a></li>
			<li class="active">{{ $pageTitle }}</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>
<div class="container m-t">
	<div class="row"  style="padding:25px 0;">

		<div class="col-md-9">
			<div class="posts">
				
				<div class="info">
					<i class="fa fa-eye "></i>  <span>  Views (<b> {{ $row->views }} </b>)  </span>   
					<i class="fa fa-user "></i>  <span>  {{ ucwords($row->username) }}  </span>   
					<i class="fa fa-calendar "></i>  <span> {{ date("M j, Y " , strtotime($row->created)) }} </span> 
					<i class="fa fa-comment-o "></i>   <span>  {{ $row->comments }} comment(s)  </span> 
				</div>
				@if($conpost['commshare'] ==1 AND $conpost['commshareapi'] !='')
				<span class='st_sharethis_large' displayText='ShareThis'></span>
				<span class='st_facebook_large' displayText='Facebook'></span>
				<span class='st_twitter_large' displayText='Tweet'></span>
				<span class='st_googleplus_large' displayText='Google +'></span>
				<span class='st_linkedin_large' displayText='LinkedIn'></span>
				<span class='st_email_large' displayText='Email'></span>
				@endif				


				@if($conpost['commimage'] ==1 )
				<div class="image">
				<img src="{{ asset('uploads/images/'.$row->image)}}" class="img-responsive" />
				</div>	
				@endif
				<div class="note">
					@if(Session::has('messagetext'))	  
						   {!! Session::get('messagetext') !!}
					@endif	

					 {!! PostHelpers::formatContent($row->note) !!}

				</div>

				<div class="labels"><br />
				<b>Articles In :  </b><br /><br />
				{!! $labels !!}
				
				<a href="{{ url('post')}}" class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left"></i> Back </a>
				<hr />

					@if($conpost['commsys'] ==1)
					<div class="comments">
						<h3> Comment(s) </h3>

						@foreach($comments as $comm)
							<div class="info" >
							<div class="avatar">
							<?php if( file_exists( './uploads/users/'.$comm->avatar) && $comm->avatar !='') { ?>
								<img src="{{ URL::to('uploads/users').'/'.$comm->avatar }} " border="0" width="40" class="img-circle" />
							<?php  } else { ?> 
								<img alt="" src="http://www.gravatar.com/avatar/{{ md5($comm->email) }}" width="40" class="img-circle" />
							<?php } ?> 
							</div>

								{{ ucwords($comm->username) }} | 
								 {{ date("M j, Y " , strtotime($comm->posted)) }}
								
							</div>
							<div class="content">
								{!! PostHelpers::formatContent($comm->comments) !!}
								<div class="tools">
									@if(Session::get('gid') == '1' OR $comm->userID == Session::get('uid')) 
									<a href="{{ url('post/remove/'.$row->pageID.'/'. $row->alias.'/'.$comm->commentID) }}"><i class="fa fa-minus-circle"></i> Remove  </a>
									@endif
								</div>
							</div> 

						@endforeach

						<hr />
						<form method="post"  action="{{ url('post/comment') }}" parsley-validate novalidate class="form">
							<textarea rows="5" placeholder="Leave comments here ...." class="form-control " required name="comments"></textarea><br />
							<button type="submit" class="btn btn-primary "> Submit Comment </button>	
							<input type="hidden" name="pageID" value="{{ $row->pageID }}" />	
							<input type="hidden" name="alias" value="{{ $row->alias }}" />						
						</form>

					</div>
					@endif
				</div>	
			</div>   
		</div>

		<div class="col-md-3">
			@include('post.widget',array("conpost"=>$conpost))
		</div>

	</div>
</div>

<style type="text/css">
	.posts {  }
	.posts h3 { margin: 0 0 10px 0; }
	.posts .info { padding: 10px 0 20px 0; font-size: 12px; }
	.posts .info i{ font-size: 18px; padding: 0 5px 0 15px;}
	.posts .labels { padding: 10px 0; }
	.posts .image { border: solid 1px #ddd; padding: 5px; margin-bottom: 10px; background: #eee; }
	.comments {}
	.comments .info{ font-size: 13px; font-weight: 700; }	
	.comments .info .avatar{ width: 40px; float: left;margin-right: 5px;  }
	.comments .content { font-size: 12px; border-bottom: solid 1px #eee;  padding: 5px 0 20px 50px;}
	.cloudtags { margin: 0 5px 5px 0; padding: 5px 10px; border: solid 1px #eee; display: block;  }
	ul.widgeul { margin: 0; padding:0; list-style: none; }
	ul.widgeul li{ clear: both; padding-bottom: 10px; border-bottom: solid 1px #eee;  }
	ul.widgeul li .image{ width: 60px; float: left; padding-right: 15px;  }
		

</style>
