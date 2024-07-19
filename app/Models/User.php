<?php

namespace App\Models;

use App\Traits\HasUuid;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    use HasFactory;
    use HasUuid;
    
    protected $guarded = [];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = config('app.url') . '/api/password/reset/' . $token;
        $this->notify(new ResetPasswordNotification($url));
    }
}
