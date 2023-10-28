<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = array(
        'hmb',
        'pa',
        'reference',
        'article_name',
        'documentation',
        'notes',
        'turn_over',
        'gross_profit',
        'bti',
        'new',
        'sustainable',
        'sustainable_message',
        'image',
        'article_length',
        'article_width',
        'article_height',
        'article_diameter',
        'description',
        'slug',
        'is_visible',
        'is_featured',
        'type',
        'style_group',
        'short_description',
        'designer_unicode',
        'margin',
        'price_level',
        'price',
        'local_price',
        'sales_start_date',
        'sales_end_date',
        'available_stock',
        'article_per_package',
        'customer_pack_length',
        'customer_pack_width',
        'customer_pack_height',
        'customer_pack_diameter'
    );


}
