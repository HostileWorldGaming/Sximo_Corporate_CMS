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
<div class="container " style="padding-top: 30px;">
	<div class="row">

		<div class="col-md-3">
			<h3><i class="fa fa-tags"></i> Article Categories </h3>
			{!! PostHelpers::cloudtags() !!}
			<hr />

			<h3><i class="fa fa-tags"></i> Latest Post </h3>
			{!! PostHelpers::latestpost() !!}
			<hr />

		</div>

		<div class="col-md-9">
			{!! $content !!}
		</div>
				
	</div>
</div>