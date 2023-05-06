<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    protected $casts=[
        'images'            => 'array',
        'specifications'    => 'array',
        'meta_keyword'      => 'array',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function scopeHasCategory(){
        return $this->whereHas('category',function($q){
            $q->where('status',1);
        });
    }
}
