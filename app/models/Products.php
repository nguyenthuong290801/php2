<?php

namespace App\models;

use Illuminate\framework\base\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $columns = [
        'id',
        'product_category_id',
        'name',
        'slug',
        'price',
        'qty',
        'created_at'
    ];
}