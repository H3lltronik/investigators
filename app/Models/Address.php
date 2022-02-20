<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'phone', 'city', 'address', 'status', 'request_id',];

    public function request() {
        return $this->belongsTo(Request::class);
    }

    public function extendedQuestions() {
        return $this->hasMany(ExtendedQuestion::class);
    }
}
