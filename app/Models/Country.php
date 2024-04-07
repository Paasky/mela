<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'code'
    ];

    protected $appends = [
        'name',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function getNameAttribute(): string
    {
        return __("countries.$this->code");
    }
}
