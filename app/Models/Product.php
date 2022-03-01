<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'cost',
        'price',
        'stock',
        'alerts',
        'image',
        'category_id',
    ];

    //relacion 
    //uno a muchos inversa
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getImagenAttribute(){
        if($this->image == null) {
            return 'productos/noimg.png';
        }

        if(file_exists('storage/'. $this->image)) {
            return $this->image;
        } else {
            return 'productos/noimg.png';
        }
    }
}
