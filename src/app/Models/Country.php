<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @mixin Builder
 */
class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'locale_key',
        'code'
    ];
}
