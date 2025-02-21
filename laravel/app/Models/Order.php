<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon'];

    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return Order::with('cart_info')->find($id);
    }
    public static function countActiveOrder(){
        $admin_id = auth()->guard('trader')->id();
        $users_id = User::where('admin_id',$admin_id)->pluck('id'); ///ارجاع جميع المستخدمين الذين ينتمون لجدول التاجر الحالي
        $data=Order::whereIn('user_id',$users_id)->count(); /// ارجاع جميع الطلبات التي تحمل uers_id في قائمة المستخدمين في هذا المتجر
        if($data){
            return $data;
        }
        return 0;
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}