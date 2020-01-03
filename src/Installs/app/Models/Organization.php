<?php
/**
 * Model genrated using CRM Admin
 * Help: http://
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

	protected $table = 'organizations';

	protected $hidden = [

    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}
