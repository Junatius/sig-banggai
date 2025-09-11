<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'photo_profile', 'desc', 'subdistrict_id',
        'has_facility', 'type', 'legality', 'price', 'latitude', 'longitude'
    ];

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict_id');
    }
    
    public function users()
    {
        return $this->hasMany(User::class, 'attractions_id');
    }

    public function galleries()
    {
        return $this->hasMany(Galery::class, 'attractions_id');
    }
}
