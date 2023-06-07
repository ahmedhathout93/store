<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory , SoftDeletes;
    protected  $fillable = ['name', 'parent_id', 'description', 'slug', 'image', 'status'];


    public function scopeFilter (Builder $builder , $filters){
        $builder->when($filters['name']??false , function($builder , $value){
            $builder->where ('categories.name','LIKE' , "%{$value}%");
        });
        $builder->when($filters['status']??false , function($builder , $value){
            $builder->where ('categories.status','=' , $value);
        });
    }

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                "unique:categories,name,$id"
            ],  // or Rule::unique('categories' , 'name')->ignore($id)

            'parent_id' => ['nullable', ' int', 'exists:categories,id'],
            'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'status' => 'in:active,archived'
        ];
    }
}
