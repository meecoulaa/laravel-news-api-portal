<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\UuidTrait;

class UserFavorite extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'user_favorites';

    protected $fillable = [
        'user_id',
        'url',
        'title',
        'description',
        'urlToImage',
        'publishedAt',
        'author',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    //All favorites with logged in user
    public function allFavorites(){
        $favorites = UserFavorite::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return $favorites;
    }
    public function specificUserFavorites($user_id){
            $favorites = UserFavorite::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
            return $favorites;
    }
    //All user favorites with 2 columns url => id
    public function favoritesUrlId(){
        $favorites = UserFavorite::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->pluck('id', 'url')
            ->mapWithKeys(fn($id, $url) => [$url => $id])
            ->all();
        return $favorites;
    }
    
}
