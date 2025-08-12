<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
    ];

    public function attractions()
    {
        return $this->hasMany(Attraction::class);
    }
}
