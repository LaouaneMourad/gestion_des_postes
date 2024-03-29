<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post()
    {
        return $this->hasMany(Post::class);
    }
    public function comment()
    {
        // return $this->hasMany(Comment::class);
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function tag()
    {
        return $this->hasMany(Tag::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeMostUserPosted(Builder $builder)
    {
        return $builder->withCount('post')->orderBy('post_count','desc');
    }

    public function scopeUsersActiveLastMonth(Builder $builder)
    {
        return $builder->withCount(['post'=>function(Builder $builder){
            $builder->whereBetween(static::CREATED_AT, [now()->subMonth(1), now()]);
        }])->orderBy('post_count' ,'desc');
    }
}
