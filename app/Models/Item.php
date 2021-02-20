<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'status'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
