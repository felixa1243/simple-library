<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'title', 'author', 'stock'];
    
    public function isAvailable()
    {
        return $this->stock > 0;
    }
}
