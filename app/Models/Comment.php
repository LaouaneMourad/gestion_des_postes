<?php

namespace App\Models;

use App\Models\Post;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function post()
    {
        return $this->belongsTo(Post::class);
    } 

    public function scopeDernier(Builder $builder)
    {
        return $builder->orderBy(static::UPDATED_AT, 'asc');
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope(new LatestScope);

        
    // }
}
