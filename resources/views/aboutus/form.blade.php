@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('sximo/js/preview-image/jquery.tmpl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('sximo/js/preview-image/modernizr.custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('sximo/js/preview-image/script.js') }}"></script> 

<script id="imageTemplate" type="text/x-jquery-tmpl"> 
    <div class="imageholder">
		<figure>
			<img src="${filePath}" alt="${fileName}"/>
			<figcaption>
			</figcaption>
		</figure>
	</div>
</script>

  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ \Lang::get('core.'.$pageTitle) }} <small>{{ \Lang::get('core.'.$pageNote) }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('aboutus?return='.$return) }}">{{ \Lang::get('core.'.$pageTitle) }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	  
    </div>
 
 	<div class="page-content-wrapper">
<div class="sbox">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	

		 {!! Form::open(array('url'=>'aboutus/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> {{ \Lang::get('core.title_aboutus') }}</legend>

								{!! Form::hidden('aboutus_id', $row['aboutus_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					
								  <div class="form-group  " >
									<label for="Aboutus Name" class=" control-label col-md-4 text-left"> {{\Lang::get('core.form_aboutus_name')}}* </label>
									<div class="col-md-6">
									  {!! Form::text('aboutus_name', $row['aboutus_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									 	<br/>
									 	<p class="text-danger">{{ $errors->first('aboutus_name') }}</p>
									 </div>
									 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 										
								  <div class="form-group  " >
									<label for="Aboutus Description" class=" control-label col-md-4 text-left"> {{\Lang::get('core.form_aboutus_description')}}*</label>
									<div class="col-md-6">
									  <textarea name='aboutus_description' rows='5' id='aboutus_description' class='form-control '  
				           >{{ $row['aboutus_description'] }}</textarea> 
				           				<br/>
									 	<p class="text-danger">{{ $errors->first('aboutus_description') }}</p>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Aboutus Content" class=" control-label col-md-4 text-left"> {{\Lang::get('core.form_aboutus_content')}}* </label>
									<div class="col-md-6">
									  <textarea name='aboutus_content' rows='5' id='aboutus_content' class='form-control editor'  
				           >{{ $row['aboutus_content'] }}</textarea> 
				           				<br/>
									 	<p class="text-danger">{{ $errors->first('aboutus_content') }}</p>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Aboutus Image" class=" control-label col-md-4 text-left"> {{\Lang::get('core.form_aboutus_image')}} </label>
									<div class="col-md-6">
									   <input  type='file' name='file' id='upload' @if($row['aboutus_image'] =='') class='required' @endif style='width:150px !important;'  /> 
									   <div id="result">
											@if($row['aboutus_image'] != "")
												<img width="150px" src="/uploads/images_upload/thumb/{{$row['aboutus_image']}}">
											@endif
										</div>
									   <br/>
									 	<p class="text-danger">{{ $errors->first('aboutus_image') }}</p>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					 					
								  <div class="form-group  " >
									<label for="Status" class=" control-label col-md-4 text-left"> {{\Lang::get('core.form_status')}} </label>
									<div class="col-md-6">
									  	<label class='radio radio-inline'>
										<input type='radio' name='status' value ='0' required @if($row['status'] == '0' || $row['status'] == '') checked="checked" @endif > {{\Lang::get('core.form_status_disable')}} </label>
										<label class='radio radio-inline'>
										<input type='radio' name='status' value ='1' required @if($row['status'] == '1') checked="checked" @endif > {{\Lang::get('core.form_status_enable')}} </label> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Aboutus Content" class=" control-label col-md-4 text-left"> {{\Lang::get('core.form_meta_keywords')}}</label>
									<div class="col-md-6">
									  <textarea name='meta_keywords' rows='5' id='meta_keywords' class='form-control'  
				           >{{ $row['meta_keywords'] }}</textarea> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Aboutus Content" class=" control-label col-md-4 text-left"> {{\Lang::get('core.form_meta_description')}}</label>
									<div class="col-md-6">
									  <textarea name='meta_description' rows='5' id='meta_description' class='form-control'  
				           >{{ $row['meta_description'] }}</textarea> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  </fieldset>
			</div>
			
			

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('aboutus?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 		
	});
	</script>		 
@stop