<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasApiTokens, AuditableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getAllPermissions()
    {
        // Load roles and their associated permissions
        return $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->pluck('name');
    }


    // app/Models/User.php

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }




    public function hasPermission($permission)
    {
        // Load roles and their associated permissions
        $roles = $this->roles()->with('permissions')->get();

        // Get all permissions for the user by flattening the nested collections
        $permissions = $roles->pluck('permissions')->flatten()->pluck('name');

        // Return whether the user has the required permission
        return $permissions->contains($permission);
    }
}
