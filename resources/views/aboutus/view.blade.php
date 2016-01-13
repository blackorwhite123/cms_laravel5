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
		<li><a href="{{ URL::to('aboutus?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox animated fadeInRight">
	<div class="sbox-title"> 
   		<a href="{{ URL::to('aboutus?return='.$return) }}" class="tips btn btn-xs btn-default pull-right" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
		@if($access['is_add'] ==1)
   		<a href="{{ URL::to('aboutus/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary pull-right" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
		@endif 
	</div>
	<div class="sbox-content" style="background:#fff;"> 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>Aboutus Id</td>
						<td>{{ $row->aboutus_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Aboutus Name</td>
						<td>{{ $row->aboutus_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Aboutus Alias</td>
						<td>{{ $row->aboutus_alias }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Aboutus Description</td>
						<td>{{ $row->aboutus_description }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Aboutus Content</td>
						<td>{{ $row->aboutus_content }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Aboutus Image</td>
						<td>{{ $row->aboutus_image }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created</td>
						<td>{{ $row->created }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Updated</td>
						<td>{{ $row->updated }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status</td>
						<td>{{ $row->status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Is Home</td>
						<td>{{ $row->is_home }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Lang</td>
						<td>{{ $row->lang }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Views</td>
						<td>{{ $row->views }} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop