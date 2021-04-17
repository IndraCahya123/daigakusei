<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = ['user_id' ,'name', 'phone', 'about', 'thumbnail'];

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function majors(){
        return $this->hasMany(Major::class, 'univ_id');
    }
}
