<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    public function getFnameAttribute()
    {
        $parts = explode(' ', $this->name, 2);

        return $parts[0] ?? '';
    }

    public function getLnameAttribute()
    {
        $parts = explode(' ', $this->name, 2);

        return $parts[1] ?? '';
    }

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }
}
