<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class news extends Sximo  {
	
	protected $table = 'news';
	protected $primaryKey = 'news_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT news.* FROM news  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE news.news_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static $rules=array(
			"news_name" => "required",
			"news_content" => "required",
			"news_picture" => "mimes:gif,png,jpg,jpeg|image|max:20000",
		);
	
	public function columnTable(){
		$array = array(
			"news_id" => array("label"=>\Lang::get('core.table_news_id'), "type"=>"text", "name"=>"news_id", "value" => ""),
			"news_name" => array("label"=>\Lang::get('core.table_news_name'), "type"=>"text", "name"=>"news_name", "value" => ""),
			"news_content" => array("label"=>\Lang::get('core.table_news_content'), "type"=>"text", "name"=>"news_content", "value" => ""),
			"status" => array("label"=>\Lang::get('core.table_status'), "type"=>"radio", "name"=>"status", "value" => "","option"=>array("0"=>\Lang::get('core.disable'),"1"=>\Lang::get('core.enable'))),
			"created" => array("label"=>\Lang::get('core.table_created'), "type"=>"date", "name"=>"created", "value" => ""),
		);
		return $array;
	}
}
