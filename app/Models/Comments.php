<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\UuidTrait;

class Comments extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'user_comments';

    protected $fillable = [
        'user_id',
        'url',
        'comment',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    //All favorites with logged in user
    public function allComments(){
        $comments = Comments::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return $comments;
    }
    public function specificUserComments($user_id){
        $comments = Comments::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        return $comments;
    }
}
