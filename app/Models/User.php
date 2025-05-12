<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia, LogsActivity, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'decoded_password',
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

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('user');
    }

    public function binaryNode()
    {
        return $this->hasOne(BinaryTree::class, 'user_id');
    }

    public function leftUsers()
    {
        return $this->hasMany(BinaryTree::class, 'parent_id')
            ->where('position', 'left');
    }

    public function rightUsers()
    {
        return $this->hasMany(BinaryTree::class, 'parent_id')
            ->where('position', 'right');
    }

    public function binaryTreeNode()
    {
        return $this->hasOne(BinaryTree::class, 'user_id');
    }

    public function kyc()
    {
        return $this->hasOne(Kyc::class);
    }

    /**
     * Relationship with UserProfile
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Relationship with Address
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    /**
     * Relationship with BankDetail
     */
    public function bankDetails()
    {
        return $this->hasOne(BankDetail::class);
    }

    /**
     * Relationship with Nominee
     */
    public function nominee()
    {
        return $this->hasOne(Nominee::class);
    }

    /**
     * Relationship with profile image media
     */
    public function profileImage()
    {
        return $this->belongsTo(Media::class, 'profile_image_id');
    }

}
