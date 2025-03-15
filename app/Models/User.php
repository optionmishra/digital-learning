<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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
        return $this->belongsToMany(Role::class, 'user_role')->withTimestamps();
    }

    public function assignRole($role)
    {
        $role = Role::firstOrCreate(['name' => $role]);
        $this->roles()->sync($role->id);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function standard()
    {
        return $this->hasOneThrough(
            Standard::class,
            UserProfile::class,
            'user_id',
            'id',
            'id',
            'standard_id'
        );
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'user_books')->withTimestamps();
    }

    public function getBooksIdArrAttribute()
    {
        return $this->books()->select('books.id')->pluck('id')->toArray();
    }

    public function assignBooks($books)
    {
        $this->books()->sync($books);
    }

    public function assignedBooks()
    {
        return $this->hasMany(UserBook::class);
    }

    public function standards()
    {
        return $this->belongsToMany(Standard::class, 'user_standards')->withTimestamps();
    }

    public function assignStandards($standards)
    {
        $this->standards()->sync($standards);
    }

    public function assignedStandards()
    {
        return $this->hasMany(UserStandard::class);
    }

    public function getSubjectsAttribute()
    {
        return Subject::whereHas('books', function ($query) {
            $query->whereHas('users', function ($q) {
                $q->where('users.id', $this->id);
            });
        })->get();
    }
}
