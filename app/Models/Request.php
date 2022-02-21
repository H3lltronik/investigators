<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [ 'status', 'financial_id', 'user_id',];

    public function address() {
        return $this->hasMany(Address::class);
    }

    public function financial() {
        return $this->belongsTo(Financial::class);
    }

    public function user() {
        return $this->hasOneThrough(User::class, Financial::class, 'user_id', 'id');
    }
    
    public function task() {
        return $this->hasOne(Tasks::class);
    }
}
