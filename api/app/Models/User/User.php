<?php

namespace App\Models\User;

use App\Models\User\Work\Work;
use BlackParadise\LaravelAdmin\Core\PathManager;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'second_name',
        'surname',
        'avatar',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'desc',
    ];

    protected $appends = [
        'full_name',
        'avatar_url',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->second_name.' '.$this->surname;
    }

    /**
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ?
            (new PathManager())->getFile($this->avatar, 'user_avatar')
            :
            (new PathManager())->getDefaultPicture();
    }

    /**
     * @return HasMany
     */
    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }

    /**
     * @return Collection
     */
    public function forSelect(): Collection
    {
        $collection = $this->newQuery()->get();
        return $collection->pluck('full_name', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'students', 'user_id', 'student_id');
    }

    /**
     * @return BelongsToMany
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'students', 'student_id', 'user_id');
    }
}
