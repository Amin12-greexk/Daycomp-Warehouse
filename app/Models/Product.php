<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'category_id',
        'warehouse_id',
        'warehouse_name',
        'purchase_price',
        'sale_price',
        'date_in',
        'image',
        'image_url',
        'rack_id',
        'shelf_id',
        'supplier_id',
    ];



    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with Warehouse
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    // Relationship with Stock
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


}
