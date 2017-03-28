       {!! Form::open(array('url'=>'faqs/section', 'class'=>'form-vertical','files' => true , 'parsley-validate'=>'','novalidate'=>' ' ,'id'=>'formpost'
      )) !!}

        <div class="form-group  " >
          <label for="Topic" class=" control-label text-left"> Title  </label>
          {!! Form::text('title', $row->title ,array('class'=>'form-control', 'placeholder'=>' ','required'=>'true'   )) !!} 

        </div> 

        <div class="form-group  " >
          <div for="Topic" class=" control-label text-left"> Ordering  </div>
           {!! Form::text('orderID', $row->orderID ,array('class'=>'form-control', 'placeholder'=>' ','required'=>'true'   )) !!}
                 </div>   
      
        <div class="form-group  " >
          <button class="btn btn-primary"> Submit</button>
           
        </div>  

      <input type="hidden" name="sectionID" value="{{ $row->sectionID }}">
      <input type="hidden" name="faqID" value="{{ $row->faqID }}">
      {!! Form::close() !!}

    <script language="javascript">
    jQuery(document).ready(function($)  {
    
       $('#formpost').parsley();
    });
    </script>     