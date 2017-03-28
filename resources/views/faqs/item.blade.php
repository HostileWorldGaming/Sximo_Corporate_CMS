   {!! Form::open(array('url'=>'faqs/item', 'class'=>'form-vertical','files' => true , 'parsley-validate'=>'','novalidate'=>' ' ,'id'=>'formpost'
  )) !!}

    <div class="form-group  " >
      <label for="Topic" class=" control-label text-left"> Section  </label>
      <select name="sectionID" required="true" class="form-control">
      		<option value=""> -- Select Section </option>
      		@foreach($section as $sec)
      		<option value="{{ $sec->sectionID }}" @if($sec->sectionID == $row->sectionID) selected @endif >{{ $sec->title }}</option>
      		@endforeach
      </select>
    </div> 

    <div class="form-group  " >
      <label for="Topic" class=" control-label text-left"> Question  </label>
      {!! Form::text('question', $row->question ,array('class'=>'form-control', 'placeholder'=>' ','required'=>'true'   )) !!} 

    </div> 

    <div class="form-group  " >
      <div for="Topic" class=" control-label text-left"> Answer  </div>
       <textarea name="answer" rows="15" class="form-control" required="true">{{  $row->answer }}</textarea>
    </div>
    <div class="form-group  " >
      <label for="Topic" class=" control-label text-left"> OrderList  </label>
      {!! Form::text('ordering', $row->ordering ,array('class'=>'form-control', 'placeholder'=>' ','required'=>'true'   )) !!} 

    </div> 

  
    <div class="form-group  " >
      <button class="btn btn-primary"> Submit</button>
       <button class="btn btn-danger closeItem" type="button"> Cancel </button>
       
    </div>  
  <input type="hidden" name="faqID" value="{{ $row->faqID }}">
  <input type="hidden" name="id" value="{{ $row->id }}">
  {!! Form::close() !!}


    <script language="javascript">
    jQuery(document).ready(function($)  {
    
       $('#formpost').parsley();
    });
    </script>    
