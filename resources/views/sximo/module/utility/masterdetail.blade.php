<div class="sbox">
	<div class="sbox-title"> <h4> {{ $pageTitle }} : <small>{{ $pageNote }}</small></h4></div>
	<div class="sbox-content">

<div class="table-responsive" style="min-height:300px;">
    <table class="table table ">
        <thead>
			<tr>
					
				<th></th>
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')				
						<?php $limited = isset($t['limited']) ? $t['limited'] :''; ?>
						@if(SiteHelpers::filterColumn($limited ))
						
							<th>{{ $t['label'] }}</th>			
						@endif 
					@endif
				@endforeach
				
			  </tr>
        </thead>

        <tbody>    
        <?php $i = 0; ?>    						
            @foreach ($rowData as $row)
            <?php $ids = ++$i; ?>
                <tr>
					<td><a href="javascript:void(0)" class="expandable-child-{{ $key}}-{{ $id }}" rel="#row-{{ $key }}-{{ $row->{$key} }}" 
					data-url=""
					><i class="fa fa-plus " ></i></a></td>	
													
				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1')
					 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
					 	@if(SiteHelpers::filterColumn($limited ))
						 <td>					 
						 	{!! SiteHelpers::formatRows($row->{$field['field']},$field,$row) !!}						 
						 </td>
						@endif	
					 @endif					 
				 @endforeach
				 			 
                </tr>
				
            
            <tr style="display:none" class="expanded" id="row-{{ $key }}-{{ $row->{$key} }}">
                	<td></td>
                	<td colspan="{{ $colspan}}" class="data">
                		<table class="table table-striped">
                			<thead>
                				<tr>
                					<th> Label </th>
                					<th> Value </th>
                				</tr>
                			</thead>
                			<tbody>
                			 @foreach ($tableGrid as $field)
					 			@if($field['detail'] =='1')
					 			<tr>
					 				<td width="20%"> {{ $field['label']}} </td>
					 				<td> : 					 
						 				{!! SiteHelpers::formatRows($row->{$field['field']},$field,$row) !!}						 
						 			</td>
						 		</tr>	
					 			@endif
					 		@endforeach	
					 		</tbody>
                		</table>


                	</td>
                	
                </tr>
            @endforeach    
              
        </tbody>
      
    </table>
	<input type="hidden" name="md" value="" />
	</div>
	</div>
</div>	

<script type="text/javascript">

$('.expandable-child-{{ $key }}-{{$id}}').click(function(){

		var id = $(this).attr('rel');
		selector =  id +" .data";
		if($(selector).is(':empty'))
		{
			$(id).show();
			$(this).removeClass('expandable'); $(this).addClass('collapseable'); 
			var url = $(this).attr('data-url');
			//$('.expanded').hide();
			$.get( url , function(data){
				$(selector).html(data);			
				
			})
			$(this).html('<i class="fa fa-minus"></i>');
			$(this).addClass('open');
		} else {
			if($(this).hasClass('open'))
			{
				$(this).html('<i class="fa fa-plus"></i>');
				$(this).removeClass('open');
				$(id).hide();
			} else {
				$(this).html('<i class="fa fa-minus"></i>');
				$(this).addClass('open');

				$(id).show();
			}
			
		}	
	});	

</script>
