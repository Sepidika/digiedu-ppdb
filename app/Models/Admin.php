<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'nama', 'email', 'password', 'no_wa',
        'role', 'status', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'super_admin'         => 'Super Admin',
            'operator_verifikasi' => 'Operator Verifikasi',
            'operator_konten'     => 'Operator Konten',
            'viewer'              => 'Viewer',
            default               => $this->role,
        };
    }
}