<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AdminUniversityRegisterRequest extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'admin_name',
        'admin_email',
        'university',
        'phone',
        'password',
    ];

    protected $hidden = [
        'phone',
        'password',
    ];

    public function superAdmin(){
        return $this->belongsTo(User::class);
    }
}
