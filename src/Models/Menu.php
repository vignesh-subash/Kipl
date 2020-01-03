<?php

namespace Kipl\Crmadmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Kipl\Crmadmin\Helpers\CAHelper;

class Menu extends Model
{
    protected $table = 'ca_menus';

    protected $guarded = [

    ];
}
