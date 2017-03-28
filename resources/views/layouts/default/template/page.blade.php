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
<div class="container " style="padding: 30px 0">
	<div class="row m-t">
		<?php echo $content ;?>
	</div>
</div>
