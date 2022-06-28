<?php

namespace Luova\Sale\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{

    protected $table = 'customers';
    protected $fillable = [
        'name', 'phone', 'email', 'address','city',
        'zip', 
    ];
}
