<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtendedQuestion extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'type', 'request_id', 'address_id'];

    public function address() {
        return $this->belongsTo(Address::class);
    }
}
