<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamRecord extends Model
{
    protected $table = 'stream_records';
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'tokens_price', 'type', 'date_expiration'];
}
