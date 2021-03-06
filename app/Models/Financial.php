<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id', 'address', 'bank'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function requests() {
        return $this->hasMany(Request::class);
    }
}
