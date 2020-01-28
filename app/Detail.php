<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = ['transaction_id', 'item', 'qty', 'price', 'total'];
}
