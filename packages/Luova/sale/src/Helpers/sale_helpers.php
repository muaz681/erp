<?php

use Luova\Sale\Models\SaleSetting;

if (!function_exists('is_sale')) {
    function is_sale()
    {
        return true;
    }
}
if (!function_exists('sale_setting')) {
    function sale_setting()
    {
        return SaleSetting::first();
    }
}
