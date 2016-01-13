<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class aboutus extends Sximo  {
	
	protected $table = 'aboutus';
	protected $primaryKey = 'aboutus_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT * FROM aboutus  ";
	}	

	public static function queryWhere(  ){
		
		return " Where 1=1  ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static $rules=array(
			"aboutus_name" => "required",
			"aboutus_description" => "required",
			"aboutus_content" => "required",
			"aboutus_file" => "mimes:gif,png,jpg,jpeg|image|max:20000",
		);
	
	public function columnTable(){
		$array = array(
			"aboutus_id" => array("label"=>\Lang::get('core.table_aboutus_id'), "type"=>"text", "name"=>"aboutus_id", "value" => ""),
			"aboutus_name" => array("label"=>\Lang::get('core.table_name'), "type"=>"text", "name"=>"aboutus_name", "value" => ""),
			//"is_home" => array("label"=>'Trang chủ', "type"=>"radio", "name"=>"is_home", "value" => "","option"=>array("0"=>"Không","1"=>"Có")),
			"status" => array("label"=>\Lang::get('core.table_status'), "type"=>"radio", "name"=>"status", "value" => "","option"=>array("0"=>\Lang::get('core.disable'),"1"=>\Lang::get('core.enable'))),
			"created" => array("label"=>\Lang::get('core.table_created'), "type"=>"date", "name"=>"created", "value" => ""),

			//"UnitPrice" => array("label"=>"Price", "type"=>"text", "name"=>"UnitPrice", "value" => ""),
			//"CategoryID" => array("label"=>"Category", "type"=>"select", "name"=>"CategoryID", "value" => "", "model"=>"categories", "id"=>"CategoryID", "show" =>"CategoryName"),
		);
		return $array;
	}
}
