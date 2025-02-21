<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'logo',
        'location_store',
        'mobile',
        'description',
        'address_store',
        'num_struct',
        'admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}