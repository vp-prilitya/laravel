<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['customer_id'];

    public function detail(){
        return $this->hasMany(Detail::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
