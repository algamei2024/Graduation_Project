<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;

    public $fillable = ['color', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
