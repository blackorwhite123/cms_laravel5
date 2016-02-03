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
		<li><a href="{{ URL::to('faq?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	  
    </div>
 
 	<div class="page-content-wrapper">

<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	

		 {!! Form::open(array('url'=>'faq/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> FAQ</legend>
									
								  
									  {!! Form::hidden('faq_id', $row['faq_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					
								  <div class="form-group  " >
									<label for="Faq Quetion" class=" control-label col-md-4 text-left"> Faq Quetion </label>
									<div class="col-md-6">
									  {!! Form::textarea('faq_quetion', $row['faq_quetion'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									  <br/>
									 	<p class="text-danger">{{ $errors->first('faq_quetion') }}</p>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Faq Answer" class=" control-label col-md-4 text-left"> Faq Answer </label>
									<div class="col-md-6">
									  {!! Form::textarea('faq_answer', $row['faq_answer'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									  <br/>
									 	<p class="text-danger">{{ $errors->first('faq_answer') }}</p>
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
										
								</fieldset>
			</div>
			
		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('faq?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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