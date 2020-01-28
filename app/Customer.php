<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'kota_id'];
    
    public function kota(){
        return $this->belongsTo(Kota::class);
    }
}
