<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamType extends Model
{
    protected $table = 'stream_types';
    protected $fillable = ['name'];

    protected function streamRecords()
    {
        return $this->hasMany(StreamRecord::class, 'type');
    }
}
