<?php

namespace Kipl\Crmadmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
use Log;
use DB;
use Kipl\Crmadmin\Helpers\CAHelper;

class CAConfigs extends Model
{
	protected $table = 'ca_configs';

	protected $fillable = [
		"key", "value"
	];

	protected $hidden = [

	];

	// CAConfigs::getByKey('sitename');
	public static function getByKey($key) {
		$row = CAConfigs::where('key',$key)->first();
		if(isset($row->value)) {
			return $row->value;
		} else {
			return false;
		}
	}

	// CAConfigs::getAll();
	public static function getAll() {
		$configs = array();
		$configs_db = CAConfigs::all();
		foreach ($configs_db as $row) {
			$configs[$row->key] = $row->value;
		}
		return (object) $configs;
	}
}
