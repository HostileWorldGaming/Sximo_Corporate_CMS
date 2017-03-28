<h3><i class="fa fa-tags"></i> Article Categories </h3>
{!! PostHelpers::cloudtags() !!}
<hr />


<h3> Latest Post </h3>
<ul class="widgeul">
@foreach($latestposts as $row)
	<li>
		@if($conpost['commimage'] ==1 )
		<div class="image">
			<img src="{{ asset('uploads/images/'.$row->image)}}"  width="50" />
		</div>	
		@endif

		<div class="post">
			<b><a href="{{ url('post/view/'.$row->pageID.'/'.$row->alias)}}"> {{ $row->title }}</a></b><br />
			<span> {{ date("M j, Y " , strtotime($row->created)) }} </span>
		</div>	
	</li>
@endforeach
</ul>
