<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Accessor untuk mendapatkan First Name (fname)
    public function getFnameAttribute()
    {
        $parts = explode(' ', $this->name, 2);
        return $parts[0] ?? '';
    }

    // Accessor untuk mendapatkan Last Name (lname)
    public function getLnameAttribute()
    {
        $parts = explode(' ', $this->name, 2);
        return $parts[1] ?? '';
    }
}
