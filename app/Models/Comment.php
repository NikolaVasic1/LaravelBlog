<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'post_id',
        'user_id',
        'is_approved',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts(){
        return $this->belongsTo(Post::class, 'post_id');
    }
}
