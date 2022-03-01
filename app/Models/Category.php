<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    //Relaciones
    //Uno a muchos
    public function products() {
        return $this->hasMany(Product::class);
    }

    public function getImagenAttribute(){
        if($this->image == null) {
            return 'categorias/noimg.png';
        }

        if(file_exists('storage/'. $this->image)) {
            return $this->image;
        } else {
            return 'categorias/noimg.png';
        }
    }
}
