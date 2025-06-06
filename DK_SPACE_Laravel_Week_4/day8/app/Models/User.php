<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
{
    return $this->hasOne(Profile::class);
}

protected static function booted()
{
    static::created(function ($user) {
        // Tạo profile
        $user->profile()->create();

        // Gửi email chào mừng
        Mail::to($user->email)->send(new \App\Mail\WelcomeMail($user));

        // Gửi notification cho admin
        $admin = \App\Models\User::where('is_admin', true)->first();
        if ($admin) {
            $admin->notify(new \App\Notifications\NewUserRegistered($user));
        }
    });
}

}
