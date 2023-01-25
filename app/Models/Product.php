<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Product extends Model{
    use HasFactory;

    protected $table = "product";

    protected $fillable = ["product_name", "quantity", "price"];

    protected $appends = ['encId'];

    public function getEncIdAttribute(){
        return Crypt::encryptString($this->id);
    }
}
