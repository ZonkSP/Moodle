<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'alumno_id'); // Adjust the foreign key if needed
    }

    public function enrolledGroups()
    {
        return $this->grupos()->with('materia', 'profesor');
    }

    public function enrollmentRequests()
    {
        return $this->hasMany(EnrollmentRequest::class);
    }

    // App\Models\User.php

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);  // A user belongs to a group (many-to-one)
    }


    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_user', 'user_id', 'grupo_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'profesor_id');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'user_id');
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
}
