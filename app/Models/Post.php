<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable =['title','descriptions','image','post_category_id'] ;
    
    public function post_category(){
        return $this->belongsTo(PostCategory::class);
    }
   
}

