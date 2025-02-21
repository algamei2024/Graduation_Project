<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable=['user_id','product_id','rate','review','status'];

    public function user_info(){
        return $this->hasOne('App\User','id','user_id');
    }

    // public static function getAllReview(){
    //     return ProductReview::with('user_info')->paginate(10);
    // }
    public static function getAllReview($admin_id=null){
        if($admin_id != null){
        return ProductReview::with('user_info')->whereHas('user_info', function($query) use ($admin_id) {
            $query->where('admin_id', $admin_id);
        })->paginate(10);
    } else {
        return ProductReview::with('user_info')->paginate(10);
    }
    }
    public static function getAllUserReview(){
        return ProductReview::where('user_id',auth()->user()->id)->with('user_info')->paginate(10);
    }

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

}