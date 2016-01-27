<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Aboutus;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class AboutusController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'aboutus';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Aboutus();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->lang = \Lang::getLocale() == '' ? CNF_LANG : \Lang::getLocale();
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'aboutus',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : ''); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
		$filter .=  " AND lang = '$this->lang'";
		
		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results = $this->model->getRows( $params );		
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		$pagination->setPath('aboutus');

		$test 						= $this->model->columnTable();
		$arr_search 				= \SiteHelpers::arraySearch(Input::get('search'));
		foreach($arr_search as $key=>$val){
			if($key != "sort" && $key != "order" && $key != "rows"){
				$test[$key]['value'] = $val;
			}
		}

		$this->data['test'] = $test;
		
		$this->data['rowData']		= $results['rows'];
		// Build Pagination 
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();	
		// Row grid Number 
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// Grid Configuration 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('aboutus.index',$this->data);
	}	



	function getUpdate(Request $request, $id = null)
	{
	
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}				
				
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('aboutus'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('aboutus.form',$this->data);
	}	

	public function getShow( $id = null)
	{
	
		if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
					
		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('aboutus'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['grid']);
		
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('aboutus.view',$this->data);	
	}	

	function postSave( Request $request)
	{

		$validator = Validator::make($request->all(), Aboutus::$rules);	

		if ($validator->passes()) {
			$data = $this->getDataPost('aboutus');
			//print_r($data);die;
			$type_pro =  !isset($data['aboutus_id']) ? "add" : "edit";
			$data['aboutus_alias'] =  \SiteHelpers::seoUrl( trim($data['aboutus_name']));
			$data = \SiteHelpers::processTimeUpdate($type_pro,$data);

			if(!is_null(\Input::file('file')))
			{
				$file = \Input::file('file');
				$destinationPath = './uploads/aboutus/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = 'aboutus_'.time().'.'.$extension;
				$uploadSuccess = \Input::file('file')->move($destinationPath, $newfilename);
				if( $uploadSuccess ) {
				    $data['aboutus_image'] = $newfilename;
				    $orgFile = $destinationPath.'/'.$newfilename;
				    $thumbFile = $destinationPath.'/thumb/'.$newfilename;
				    //SiteHelpers::resizewidth("213",$orgFile,$thumbFile);
				    \SiteHelpers::resize_crop_image('600' , '450' , $orgFile ,	 $thumbFile);
				    if($type_pro == "edit")
				    {
				    	$data_old = $this->model->getRow(\Input::get('aboutus_id'));
				    	@unlink(ROOT .'/uploads/aboutus/'.$data_old->aboutus_image);
				    	@unlink(ROOT .'/uploads/aboutus/thumb/'.$data_old->aboutus_image);
				    }
				}
			}

			$id = $this->model->insertRow($data , \Input::get('aboutus_id'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'aboutus/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'aboutus?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('aboutus_id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {
			$id =  \Input::get('aboutus_id') ? \Input::get('aboutus_id') : "";
			return Redirect::to('aboutus/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
	}	

	public function postDelete( Request $request)
	{
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows 
		if(count($request->input('ids')) >=1)
		{
			$this->model->destroy($request->input('ids'));
			
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('ids'))."  , Has Been Removed Successfull");
			// redirect
			return Redirect::to('aboutus')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('aboutus')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}