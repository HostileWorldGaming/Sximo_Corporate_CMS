<h3> Latest Post </h3>
<ul class="widgeul">
@foreach($sql as $row)
	<li>
		<b><a href="{{ url('post/view/'.$row->pageID.'/'.$row->alias)}}"> {{ $row->title }}</a></b><br />
		<span> {{ date("M j, Y " , strtotime($row->created)) }} </span>
	</li>
@endforeach
</ul>
<hr />