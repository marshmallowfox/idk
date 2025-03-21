<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

/**
 * @mixin Builder
 */
class Guest extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'guests';
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'country_id'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($guest) {
            if (empty($guest->id)) {
                $guest->id = (string) Str::uuid();
            }
        });
    }
}
