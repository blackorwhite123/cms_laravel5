@extends('layouts.app')

@section('content')

  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('news?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	  
    </div>
 
 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	

		 {!! Form::open(array('url'=>'news/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> News</legend>
									
					
									  {!! Form::hidden('news_id', $row['news_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									 
											
								  <div class="form-group  " >
									<label for="News Name" class=" control-label col-md-4 text-left"> News Name </label>
									<div class="col-md-6">
									  {!! Form::text('news_name', $row['news_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="News Content" class=" control-label col-md-4 text-left"> News Content </label>
									<div class="col-md-6">
									  <textarea name='news_content' rows='5' id='news_content' class='form-control'>{{ $row['news_content'] }}</textarea> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 							
								 <div class="form-group  " >
									<label for="Status" class=" control-label col-md-4 text-left"> Status </label>
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
									  <label for="News Image" class=" control-label col-md-4 text-left"> {{\Lang::get('core.table_news_picture')}} </label>
									  <div class="col-md-6">
										   <input  type='file' name='file' id='upload' @if($row['news_picture'] =='') class='required' @endif style='width:150px !important;'  /> 
										   <div id="result">
												@if($row['news_picture'] != "")
													<img width="150px" src="/uploads/news/thumb/{{$row['news_picture']}}">
												@endif
											</div>
										   <br/>
										 	<p class="text-danger">{{ $errors->first('news_picture') }}</p>
									  </div>
									  <div class="col-md-2">
									 	
									  </div>
								  </div> 				
								  <div class="form-group  " >
									<label for="Cat Id" class=" control-label col-md-4 text-left"> Cat Id </label>
									<div class="col-md-6">
									  {!! Form::text('cat_id', $row['cat_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="News Description" class=" control-label col-md-4 text-left"> News Description </label>
									<div class="col-md-6">
									  <textarea name='news_description' rows='5' id='news_description' class='form-control'>{{ $row['news_description'] }}</textarea> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Lang" class=" control-label col-md-4 text-left"> Lang </label>
									<div class="col-md-6">
									  {!! Form::text('lang', $row['lang'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> </fieldset>
			</div>

			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('news?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop