<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'lastname', 'slastname', 'equis','instagram','tiktok','youtube','website'];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}