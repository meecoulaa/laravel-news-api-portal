<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\UuidTrait;

class UserLogs extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'user_logs';

    protected $fillable = [
        'user_id',
        'action',
        'description',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function allUserLogs(){
        return $logs = UserLogs::select('user_id','action', 'description', 'created_at')->get();
    }
}
