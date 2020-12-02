<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "posts";
    protected $dates = ['deleted_at'];
    protected $with = ['user', 'comments'];

    protected $fillable = [
        'category_id', 'user_id', 'title', 'body', 'comments_count'
    ];

    // public function attachments(){
    //     return $this->hasMany(Attachment::class, 'attachment_id')->where('attachment_type', 'posts')->orderBy('id', 'asc');
    // }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'commentable_id')->where('commentable_type', 'posts');
    }

}
