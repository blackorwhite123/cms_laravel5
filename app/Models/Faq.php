<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class faq extends Sximo  {
	
	protected $table = 'faq';
	protected $primaryKey = 'faq_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT faq.* FROM faq  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE faq.faq_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static $rules=array(
			"faq_quetion" => "required",
			"faq_answer" => "required",
			
		);
	
	public function columnTable(){
		$array = array(
			"faq_id" => array("label"=>\Lang::get('core.table_faq_id'), "type"=>"text", "name"=>"faq_id", "value" => ""),
			"faq_quetion" => array("label"=>\Lang::get('core.table_faq_quetion'), "type"=>"text", "name"=>"faq_quetion", "value" => ""),
			"faq_answer" => array("label"=>\Lang::get('core.table_faq_answer'), "type"=>"text", "name"=>"faq_answer", "value" => ""),
			"status" => array("label"=>\Lang::get('core.table_status'), "type"=>"radio", "name"=>"status", "value" => "","option"=>array("0"=>\Lang::get('core.disable'),"1"=>\Lang::get('core.enable'))),
			"created" => array("label"=>\Lang::get('core.table_created'), "type"=>"date", "name"=>"created", "value" => ""),

			//"UnitPrice" => array("label"=>"Price", "type"=>"text", "name"=>"UnitPrice", "value" => ""),
			//"CategoryID" => array("label"=>"Category", "type"=>"select", "name"=>"CategoryID", "value" => "", "model"=>"categories", "id"=>"CategoryID", "show" =>"CategoryName"),
		);
		return $array;
	}

}
