<div class="container" style="padding-top:25px;">	
    <div class="row m-b-lg animated fadeInDown delayp1 text-center">
        <h3> {{ $pageTitle }} <small> {{ $pageNote }} </small></h3>
        <hr />       
    </div>
</div>
<div class="container m-t">		

	<div class="row">
		<div class="col-md-3">
			
			<ul class="faqTree">
			@foreach($faqTree as $fs)
				<li><h4>{{ $fs['title'] }}</h4> 				
				
					<ul>
						@foreach($fs['items'] as $item)
						<li><a href="?view={{$item->id}}"><i class="icon-arrow-right3"></i> + {!! $item->question !!}</a> </li>

						@endforeach

					</ul>
					<div class="clear clr"></div>
				</li>
			@endforeach
			</ul>
		</div>
		<div class="col-md-9">
				
			@if(isset($items) && count($items)>=1)
				<?php $items = $items[0]; ?>
				<div class="displayItem">
					<h4> {{ $items->question}} </h4>
					<hr />
					<div>
						{!! \App\Library\Slimdown::render( strip_tags($items->answer) ) !!}
					</div>
				</div>
				
			@endif

		</div>
		<div class="clr clear"></div>

		</div>
	</div>	

</div> 
<style type="text/css">
	ul.faqTree { margin: 0; padding: 0; list-style: none;}
	ul.faqTree li {}
	ul.faqTree li h4 { margin: 0; padding: 0;  padding: 5px 0;}	
	ul.faqTree li h4 a{ }
	ul.faqTree li ul { margin: 0; padding-top: 0; list-style: none; margin-left: -30px;}
	ul.faqTree li ul li a{ font-size: 11px;}
	.displayItem { font-size: 13px; }

</style>
