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
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox animated fadeInRight">
	<div class="sbox-title"> 
   		<a href="{{ URL::to('news?return='.$return) }}" class="tips btn btn-xs btn-default pull-right" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
		@if($access['is_add'] ==1)
   		<a href="{{ URL::to('news/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary pull-right" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
		@endif 
	</div>
	<div class="sbox-content" style="background:#fff;"> 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>News Id</td>
						<td>{{ $row->news_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>News Name</td>
						<td>{{ $row->news_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>News Content</td>
						<td>{{ $row->news_content }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>News Alias</td>
						<td>{{ $row->news_alias }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status</td>
						<td>{{ $row->status }} </td>
						
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
						<td width='30%' class='label-view text-right'>News Picture</td>
						<td>{{ $row->news_picture }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Cat Id</td>
						<td>{{ $row->cat_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>News Description</td>
						<td>{{ $row->news_description }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Lang</td>
						<td>{{ $row->lang }} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop