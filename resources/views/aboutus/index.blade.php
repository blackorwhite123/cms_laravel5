@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3>{{ Lang::get('core.'.$pageTitle) }} <small>{{ Lang::get('core.'.$pageNote) }}</small></h3>
      </div>

      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li class="active">{{ Lang::get('core.'.$pageTitle) }}</li>
      </ul>	  
	  
    </div>
	
	
	<div class="page-content-wrapper m-t">	 	

<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h5> <i class="fa fa-table"></i> </h5>
	</div>
	<div class="sbox-content"> 	
	    <div class="toolbar-line ">
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('aboutus/update') }}" class="tips btn btn-sm btn-white"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa fa-plus-circle "></i>&nbsp;{{ Lang::get('core.btn_create') }}</a>
			@endif  
			@if($access['is_remove'] ==1)
			<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_remove') }}">
			<i class="fa fa-minus-circle "></i>&nbsp;{{ Lang::get('core.btn_remove') }}</a>
			@endif 			
		 
		</div> 		

	
	
	 {!! Form::open(array('url'=>'aboutus/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
	 <div class="table-responsive" style="min-height:300px;">
    <table class="table table-striped ">
        <thead>
			<tr>
				<th class="number"> No </th>
				<th> <input type="checkbox" class="checkall" /></th>
				
				@foreach ($test as $t)
						<th>{{ $t['label'] }}</th>
				@endforeach
				<th width="70" >{{ Lang::get('core.btn_action') }}</th>
			  </tr>
        </thead>

        <tbody>    
        	<tr id="sximo-quick-search" >
				<td> # </td>
				<td> </td>
				@foreach ($test as $t)
					<td>						
						<?php echo SiteHelpers::transFormsearch($t) ?>							
					</td>
				@endforeach
				<td style="width:130px;">
				<input type="hidden"  value="Search">
				<button type="button"  class=" do-quick-search btn btn-sx btn-info"> GO</button></td>
			  </tr>    						
            @foreach ($rowData as $row)
                <tr>
					<td width="30"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="ids[]" value="{{ $row->aboutus_id }}" />  </td>									
				 @foreach ($test as $field)
					 <td>					 
					 	{{ SiteHelpers::transSelect($field,$row) }}
					 </td>
				 @endforeach
				 <td>
					 	@if($access['is_detail'] ==1)
						<a href="{{ URL::to('aboutus/show/'.$row->aboutus_id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_view') }}"><i class="fa  fa-search "></i></a>
						@endif
						@if($access['is_edit'] ==1)
						<a  href="{{ URL::to('aboutus/update/'.$row->aboutus_id.'?return='.$return) }}" class="tips btn btn-xs btn-success" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i></a>
						@endif
												
					
				</td>				 
                </tr>
				
            @endforeach
              
        </tbody>
      
    </table>
	<input type="hidden" name="md" value="" />
	</div>
	@include('footer_new')
	{!! Form::close() !!}

	</div>
</div>	
	</div>	  
</div>	
<script>
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("aboutus/multisearch")}}');
		$('#SximoTable').submit();
	});

	$("#filter_footer").click(function(){
		$('#SximoTable').attr('action','{{ URL::to("aboutus/multisearch")}}');
		$('#SximoTable').submit();
	});
	
	
});	
</script>		
@stop