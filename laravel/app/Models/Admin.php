<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use App\Models\StoreInformation;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements JWTSubject
{
    // use HasApiTokens, HasFactory, Notifiable;
    use Notifiable, HasApiTokens;

    /**
     * Guard for the model
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
        'status',
        'provider',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() 
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function token(){
        // return $this->tokens()->latest()->first();
        // return $this->currentAccessToken();
    }

    public function storeInformation()
    {
        return $this->hasOne(StoreInformation::class);
    }

    // ارجاع اصناف التاجر
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    // ارجاع منتجات التاجر
    public function products()
    {
        return $this->hasManyThrough(Product::class, Category::class, 'admin_id', 'cat_id', 'id', 'id');
    }

}