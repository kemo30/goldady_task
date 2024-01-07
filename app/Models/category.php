<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function posts(){
        return $this->hasMany(post::class,'category_id','id');
    }
}
