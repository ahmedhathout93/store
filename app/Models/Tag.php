<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false; // because we removed it from migration file

    protected $fillable = [
        'name', 'slug'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class); 
    }
}
