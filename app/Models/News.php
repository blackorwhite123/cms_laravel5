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


}
