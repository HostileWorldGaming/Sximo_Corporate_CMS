@extends('layouts.app')

@section('content')
<div class="page-content row">

 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title"> 
		<h5 style="display:block !important"><i class="fa fa-comment"></i> {{ $pageTitle }}: {{ $row->name }} </h5>
			<div class="sbox-tools" >
		   		<a href="{{ URL::to('faqs?return='.$return) }}" class="tips btn btn-sm btn-default " title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
				@if($access['is_add'] ==1)
		   		<a href="{{ URL::to('faqs/update/'.$id.'?return='.$return) }}" class="tips btn btn-sm  btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-pencil"></i></a>
				@endif
			</div>	 
	</div>
	<div class="sbox-content" > 	
 
		<hr />
	

		<div class="col-md-3">
			@if($access['is_add'] =='1')
			<a href="{{ url('faqs/section/'.$row->faqID)}}" onclick="SximoModal(this.href,'New Section'); return false;" class="btn btn-sm btn-white"><i class="icon-plus-circle2"></i>   Section  </a>
			<hr />
			@endif
			<ul class="faqTree">
			@foreach($faqTree as $fs)
				<li><h4>{{ $fs['title'] }}

					@if($access['is_remove'] =='1')
					<a href="{{ url('faqs/sectiondelete/'.$row->faqID.'/'.$fs['sectionID'])}}"  class="btn-default btn btn-xs pull-right sectionDelete"><i class="fa fa-trash-o"></i></a>
					@endif
					@if($access['is_edit'] =='1')
					<a href="{{ url('faqs/section/'.$row->faqID.'/'.$fs['sectionID'])}}"  onclick="SximoModal(this.href,'Edit Section'); return false;"  class="btn-default btn btn-xs pull-right"><i class="fa fa-pencil"></i></a>
					@endif	</h4> 				
				
					<ul>
						@foreach($fs['items'] as $item)
						<li><a href="?view={{$item->id}}"><i class="icon-arrow-right3"></i> {!! $item->question !!}</a> </li>

						@endforeach

					</ul>
					<div class="clear clr"></div>
				</li>
			@endforeach
			</ul>
		</div>
		<div class="col-md-9">
			<div class="text-right">
			@if($access['is_add'] =='1')
			<a href="{{ url('faqs/item/'.$row->faqID.'/0/0')}}"  onclick="SximoModal(this.href,'Edit Section'); return false;"  class="btn btn-sm btn-white"><i class="icon-plus-circle2"></i> Add New Item  </a>
			
				@if(isset($items) && count($items)>=1)
					<?php $item = $items[0]; ?>
					<a href="{{ url('faqs/item/'.$row->faqID.'/'.$item->sectionID.'/'.$item->id)}}" onclick="SximoModal(this.href,'Edit Item'); return false;" class="btn btn-sm btn-white "><i class="icon-pencil"></i> Edit Item  </a>
					<a href="{{ url('faqs/itemdelete/'.$row->faqID.'/'.$item->id)}}" class="btn btn-sm btn-white itemDelete"><i class="icon-remove"></i> Delete Item  </a>
				@endif

			<hr />				
			@endif	
			</div>		
			@if(isset($items) && count($items)>=1)
				<?php $items = $items[0]; ?>
				<div class="displayItem">
					<h2> {{ $items->question}} </h2>
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
</div>
	 
<style type="text/css">
	ul.faqTree { margin: 0; padding: 0; list-style: none;}
	ul.faqTree li {}
	ul.faqTree li h4 {  padding-bottom: 5px;}	
	ul.faqTree li h4 a{ }
	ul.faqTree li ul { margin: 0; padding-top: 0; list-style: none; margin-left: -30px;}
	ul.faqTree li ul li a{ font-size: 11px;}
	.displayItem { font-size: 11px; }

</style>	  
<script type="text/javascript">
$(function() {
	$('.sectionDelete , .itemDelete').click(function(){
		if(confirm('Are u sure remove this section/item ?'))
		{
			return true
		} else {
			return false;
		}
		return false;
	})
	$('.editItem').click(function(){
		$('.displayItem').hide();		
		$('.displayEdit').show();
	});
	$('.closeItem').click(function(){
		$('.displayItem').show();		
		$('.displayEdit').hide();		
	});
})
</script>

@stop