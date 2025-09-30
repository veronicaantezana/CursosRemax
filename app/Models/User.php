<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'username',
        'name_to_show', 
        'first_name',
        'last_name',
        'role_id',
        'role',
        'external_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        
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
            //'password' => 'hashed',
        ];
    }
     public function getAuthPassword()
    {
        return '';
    }
    /**
     * Get the name of the unique identifier for the user.
     * Usamos 'username' en lugar de 'email'
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }
     /**
     * Para Passport/OAuth - siempre válido ya que la auth es externa
     */
    public function validateForPassportPasswordGrant($password)
    {
        return true;
    }

     public function isAdmin()
    {
        return $this->role_id === 2;
    }

    /**
     * Verificar si es Agente
     */
    public function isAgent()
    {
        return $this->role_id === 4;
    }

    /**
     * Relación: Un usuario (ADMIN) puede crear muchas categorías
     */
    public function categories()
    {
        return $this->hasMany(Categoria::class, 'created_by');
    }

    /**
     * Relación: Un usuario (ADMIN) puede crear muchos cursos
     */
    public function courses()
    {
        return $this->hasMany(Curso::class, 'created_by');
    }

    /**
     * Attribute para obtener el tipo de usuario
     */
    public function getTypeAttribute()
    {
        return $this->isAdmin() ? 'admin' : 'agent';
    }
}
