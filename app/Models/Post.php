<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable =['name','subtitle','abstract','note','author_id'];
    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}

