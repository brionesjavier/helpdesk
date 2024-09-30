<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\SlaTimeFormatter;

class User extends Authenticatable
{
    use SlaTimeFormatter;
    use HasFactory, Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'birthdate',
        'address',
        'city',
        'password',
        'assignable'
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

    public function getFormattedSla($seconds)
    {
        return $this->getSlaTimeFormattedAttribute($seconds);
    }

    public function assignedTickets():BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'ticket_assigns')
                                                                    ->withPivot('details', 'is_active')
                                                                    ->withTimestamps();
    }

    public function ticket(){
        return $this->hasMany(Ticket::class);
    }
}
