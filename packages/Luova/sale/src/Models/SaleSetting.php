<?php

namespace Luova\Sale\Models;

use Illuminate\Database\Eloquent\Model;


class SaleSetting extends Model
{

    protected $table = 'sale_settings';
    protected $fillable = [
        'cogs', 'shipping_fee', 'discount', 'tax_vax', 'round_of'
    ];



}
