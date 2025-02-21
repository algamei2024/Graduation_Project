<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Helper;

class SenddataToReact extends Controller
{
    public $folder_name;
    public function __construct()
    {
        $this->folder_name = 'myFolder';
    }

    public function getDataFooter($fileName)
    {
        $settings = \DB::table('settings')->get();
        $data = $settings->map(function ($setting) {
            return [
                'short_description' => $setting->short_des,
                'phone' => $setting->phone,
                'address' => $setting->address,
                'email' => $setting->email,
            ];
        });

        $path_fileContent = "$this->folder_name/$fileName.htm";
        $path_fileStyle = "$this->folder_name/$fileName.css";

        $content = Storage::get($path_fileContent);
        $style = Storage::get($path_fileStyle);

        return response()->json([
            'data' => $data,
            'content' => $content,
            'style' => $style,
        ]);
    }

    public function getDataHeader($fileName)
    {
        $folder_second = 'layout';
        $settings = \DB::table('settings')->get();
        $data = $settings->map(function ($setting) {
            return [
                'short_description' => $setting->short_des,
                'phone' => $setting->phone,
                'address' => $setting->address,
                'email' => $setting->email,
            ];
        });

        $allCategory = Helper::getAllCategory();
        $wishlistCount = Helper::wishlistCount();
        // $countWishlist = count(Helper::getAllProductFromWishlist());
        $allProdFromWish = Helper::getAllProductFromWishlist();
        $allProdFromCart = Helper::getAllProductFromCart();
        $allProdFromCartWishlist = Helper::getAllProductFromWishlist();
        $cartCount = Helper::cartCount();
        // $countProdfromCart = count(Helper::getAllProductFromCart());
        $countProdfromCart = Helper::getAllProductFromCart();
        // $headerCat = Helper::getHeaderCategory();

        $path_fileContent = "$this->folder_name/$folder_second/$fileName.htm";
        $path_fileStyle = "$this->folder_name/$folder_second/$fileName.css";

        $content = Storage::get($path_fileContent);
        $style = Storage::get($path_fileStyle);

        return response()->json([
            'data' => $data,
            'content' => $content,
            'style' => $style,
            'allCategory' => $allCategory,
            'wishlistCount' => $wishlistCount,
            'allProdFromWish' => $allProdFromWish,
            'allProdFromCart' => $allProdFromCart,
            'allProdFromCartWishlist' => $allProdFromCartWishlist,
            'cartCount' => $cartCount,
            'countProdfromCart' => $countProdfromCart,
            // 'headerCat' => $headerCat,
        ]);
    }
}
