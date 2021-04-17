<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = ['univ_id', 'name', 'about'];

    protected $casts = [
        'about' => 'array'
    ];

    public function university(){
        return $this->belongsTo(University::class, 'univ_id');
    }
}
