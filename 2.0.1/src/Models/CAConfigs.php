<?php
/**
 * Code generated using CrmAdmin
 * Help: http://crmadmin.com
 * CrmAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Kipl IT Solutions
 * Developer Website: http://kipl.com
 */

namespace Kipl\Crmadmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
use Log;
use DB;
use Kipl\Crmadmin\Helpers\CAHelper;

/**
 * Class CAConfigs
 * @package Kipl\Crmadmin\Models
 *
 * Config Class looks after CrmAdmin configurations.
 * Check details on http://crmadmin.com/docs
 */
class CAConfigs extends Model
{
    protected $table = 'ca_configs';

    protected $fillable = [
        "key", "value"
    ];

    protected $hidden = [

    ];

    /**
     * Get configuration string value by using key such as 'sitename'
     *
     * CAConfigs::getByKey('sitename');
     *
     * @param $key key string of configuration
     * @return bool value of configuration
     */
    public static function getByKey($key)
    {
        $row = CAConfigs::where('key', $key)->first();
        if(isset($row->value)) {
            return $row->value;
        } else {
            return false;
        }
    }

    /**
     * Get all configuration as object
     *
     * CAConfigs::getAll();
     *
     * @return object
     */
    public static function getAll()
    {
        $configs = array();
        $configs_db = CAConfigs::all();
        foreach($configs_db as $row) {
            $configs[$row->key] = $row->value;
        }
        return (object)$configs;
    }
}
