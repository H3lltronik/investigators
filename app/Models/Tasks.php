<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [  'completed_date', 'status', 'responses', 'form', 'user_id', 'request_id', ];

    public function request() {
        return $this->belongsTo(Request::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
