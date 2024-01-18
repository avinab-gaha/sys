<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    // protected $fillable = ['name', 'price'];
    protected $fillable = ['id', 'product_code', 'name', 'filename', 'price', 'detail'];

    public function filebox()
    {
        return $this->hasOne('App\Models\Filebox', 'id');
    }

    // public function getProducts()-+
    // {
    //     $result = DB::table("products")->select('name', 'price', 'detail', 'image', 'imgpath')->get();
    //     return $result;
    // }

    // public function addProducts($data)
    // {
    //     $result = DB::table("products")->insert($data);
    //     return $result;
    // }


}
