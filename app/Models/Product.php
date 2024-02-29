<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'product_sale', 'product_id', 'sale_id')
            ->withPivot('quantity'); 
    }
}
