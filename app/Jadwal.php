<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwals';
    public function getWaktuAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['waktu'])
        // ->diffForHumans();
        ->translatedFormat('l, d F Y H:i');
    }
}
