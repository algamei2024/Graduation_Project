<?php

use Illuminate\Http\Request;
use App\Http\Controllers\MyFiles;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SenddataToReact;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\StoreInformationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Fetch data for design  page in react
Route::post('fetchDataDesign', [AdminController::class, 'fetchDataDesign']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/newtitle', [AdminController::class, 'newTitle'])->middleware(
    'cors'
);


// تسجيل دخول التاجر
Route::post('trader/login',[AdminController::class,'loginSubmit'])->name('trader.loginSubmit');

// Route::middleware('auth:trader')->post('saveDataDesign', [AdminController::class,'saveDataDesign']);
Route::middleware('auth:sanctum')->group(function(){
    Route::post('saveDataDesign', [AdminController::class,'saveDataDesign']);
    Route::post('getData', [AdminController::class,'getData']);
});

//كود خاطئ
// Route::middleware(['api','auth.redirect:trader'])->get('saveDataDesign', [AdminController::class,'saveDataDesign']);

///
///////////////////////

////// for register
// Route::get('user/register', [FrontendController::class, 'register'])->name(
//     'register.form'
// );

//تسجيل التاجر
// Route::post('store/register', [
//     AdminController::class,
//     'registerSubmit',
// ])->name('register.store.submit');



// تسجيل المستخدم العادي في متجر التاجر
Route::post('user/register', [
    FrontendController::class,
    'registerSubmit',
])->name('register.submit');




///// for login
//api for this => http://127.0.0.1:8000/api/user/login
Route::post('user/login', [FrontendController::class, 'loginSubmit'])->name(
    'login.submit'
);
//login for admin
// Route::post('admin/login', [AdminController::class, 'loginSubmit'])->name(
//     'login.admin.submit'
// );

Route::get('user/logout', [FrontendController::class, 'logout'])->name(
    'user.logout'
);
// Route::get('admin/logout', [AdminController::class, 'logout'])->name(
//     'admin.logout'
// );


//update user profile self not admin
Route::post('udpate/profile',[UsersController::class,'update']);

// Route::get('user/update/{id}', [UsersController::class, 'update']);


Route::middleware('auth:sanctum')->group(function () {

    
    
    //API for this => http://127.0.0.1:8000/api/user/register

    // Route::get('user/show', [FrontendController::class, 'show']);
    // Route::get('user/del/{id}', [FrontendController::class, 'delete']);

    Route::resource('user', UsersController::class)->middleware('admin');

    //for get user id
    //api fo this => http://127.0.0.1:8000/api/getId
    Route::get('getId', function () {
        $user = Auth::id();
        return response()->json([
            'user_id' => $user,
        ]);
        dd(Auth::user()->id);
    });

    Route::post('getuser', [UsersController::class, 'getuser']);

    Route::post('refresh', [FrontendController::class, 'refresh']);
    // Route::get('tokenIsFound', [FrontendController::class, 'tokenIsFound']);

    // Route::middleware('auth:admin')->group(function () {
        //store information electronic store
    
    // });

    ///// for logout
    //api fo this => http://127.0.0.1:8000/api/user/logout
});




////code create and send files
Route::post('create/file/{fileName}', [MyFiles::class, 'create']);
Route::get('send/file/{fileName}', [MyFiles::class, 'sendFile']);

///// for stor product
//api fo this =>
Route::post('product/store', [ProductController::class, 'store'])->name(
    'product.store'
);

///// for stor getAllProducts
//api fo this => http://127.0.0.1:8000/api/product/getAll
Route::post('product/getAll', [ProductController::class, 'index'])->name(
    'product.getAll'
);

///// for stor getAllCategory
//api fo this => http://127.0.0.1:8000/api/category/getAll
Route::get('category/getAll', [CategoryController::class, 'index']);

///// for stor frontEnd Home
//api fo this => http://127.0.0.1:8000/api/category/getAll
Route::get('frontEnd/home', [FrontendController::class, 'home']);

// Route::get('getId', [FrontendController::class, 'getID'])->middleware('cors');

////
//send all data of laravel to react project

Route::middleware('cors')->group(function () {
    Route::get('data/footer{nameFile}', [
        SenddataToReact::class,
        'getDataFooter',
    ]);
    Route::get('data/header{nameFile}', [
        SenddataToReact::class,
        'getDataHeader',
    ]);
});


require_once __DIR__ . '/admin.php';