<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class NewsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'news';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new News();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->lang = \Lang::getLocale() == '' ? CNF_LANG : \Lang::getLocale();
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'news',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'news_id'); 
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
		$pagination->setPath('news');

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
		return view('news.index',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('news'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('news.form',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('news'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['grid']);
		
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('news.view',$this->data);	
	}	

	function postSave( Request $request)
	{
		
		$validator = Validator::make($request->all(), News::$rules);		
		if ($validator->passes()) {
			$data = $this->getDataPost('news');

			$type_pro =  !isset($data['news_id']) ? "add" : "edit";

			//Make alias
			//$data['alias'] =  \SiteHelpers::seoUrl( trim($data['name']));

			$data = \SiteHelpers::processTimeUpdate($type_pro,$data);

			if(!is_null(\Input::file('file')))
			{
				$file = \Input::file('file');

				//Edit Path
				$destinationPath = './uploads/news/';

				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file

				//Edit file name
				$newfilename = 'news_'.time().'.'.$extension;

				$uploadSuccess = \Input::file('file')->move($destinationPath, $newfilename);
				if( $uploadSuccess ) {

					//Edit name of field image
				    $data['news_picture'] = $newfilename;

				    $orgFile = $destinationPath.'/'.$newfilename;
				    $thumbFile = $destinationPath.'/thumb/'.$newfilename;
				    //SiteHelpers::resizewidth("213",$orgFile,$thumbFile);

				    //Edit size thumb image
				    \SiteHelpers::resize_crop_image('600' , '450' , $orgFile ,	 $thumbFile);

				    if($type_pro == "edit")
				    {
				    	$data_old = $this->model->getRow(\Input::get('news_id'));
				    	//Edit folder name and field name
				    	@unlink(ROOT .'/uploads/news/'.$data_old->aboutus_image);
				    	@unlink(ROOT .'/uploads/news/thumb/'.$data_old->aboutus_image);
				    }
				}
			}
			$id = $this->model->insertRow($data , \Input::get('news_id'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'news/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'news?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('news_id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {
			$id =  \Input::get('news_id') ? \Input::get('news_id') : "";
			return Redirect::to('news/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('news')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('news')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}