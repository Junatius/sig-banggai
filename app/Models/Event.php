<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'users_id', 'name', 'photo_url', 'start_date',
        'end_date', 'desc', 'link', 'manager', 'contact'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
