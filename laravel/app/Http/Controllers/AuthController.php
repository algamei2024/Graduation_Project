<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\User;
use App\Models\Admin;
use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Models\StoreInformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login','register', 'testRegister', 'testNameAndMobileStore']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $test = Admin::where('email',request('email'))->first();
        if($test){
            if($test['role'] != 'owner')
            return response()->json(['error'=>'البريد الالكتروني غير موجود'],400);
        }

        if (! $token = auth()->guard('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $admin = Auth::guard('admin')->user();
        $token = $this->respondWithToken($token);


        //
        // if($admin['role'] == 'admin'){
        //     $email = $admin['email'];
        //     $password = $admin['password'];

        //     return redirect()->route('login.submit',['email'=>$email,'password'=>$password]);
        // }

        return response()->json([
            'admin'=> $admin,
            'token'=>$token
        ]);
    }
    
    public function testRegister(Request $request){
        $request->validate([
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:admins,email',
            'password' => 'required|min:6|confirmed', //هذا الشرط confirmed يعني انه يجب ان تضع حقل باسم password_confirmation
        ]);
        return response()->json([
            'msg'=>'واصل عملية التسجيل',
            'password'=>$request->input('password'),
            'password_confirmation'=>$request->input('password_confirmation'),
        ],200);
        
    }
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:admins,email',
            'password' => 'required|min:6|confirmed',
        ]);
        

    //////اكواد حفظ بيانات المتجر/////
        
         //حفظ الصورة مع اسم عشوائي
        // $path = $request->file('image')->store('public/uploads');
        $request->validate([
            'nameStore'=>'required',
            'mobile'=>'required',
            'description'=>'required',
            'num_struct'=>'nullable'
        ]);

        $fullPath = null;

        //التاكد من ان المرسل ارسل صورة
        $validator = Validator::make($request->all(), [
            //النوع mimes يتاكد من ان امتداد الصورة يقع من ضمن القائمة المعطية
            'logo' => 'required|image|mimes:jpeg,png,gif|max:4096',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //بدء حفظ البيانات
        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
        ]);
        // $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        //التحقق مما اذا كان هناك ملف مرسل باسم logo
        if ($request->hasFile('logo')) {
            //حفظ الصورة مع  اسمها الحقيقي
            $image = $request->file('logo');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/' . $admin->name, $imagePath);

            $fullPath = Storage::url($path); //تخزين مسار الصورة
        }

        //الاسهل
        // $path = $request
        //     ->file('image')
        //     ->storeAs(
        //         'public/uploads',
        //         $request->file('image')->getClientOriginalName()
        //     );

        // $data = $request->all();
        // $data['image_path'] = $imagePath;
        // $data['location_store'] = 'location one';
        // $data['mobile'] = '772520163';
        // $data['user_id'] = 2;
        // $model = Information::create($data);

        // $fullPath = 'public/uploads/' . $imagePath;


        $nameStor = $request->input('nameStore');
        $location = $request->input('location_sotre');
        $mobile = $request->input('mobile');
        $description = $request->input('description');
        $address_store = $request->input('address_store');
        $num_struct = 'one';
        $id = $admin->id;

        //انشاء ملفات المتجر
        // تحديد المسارات
        $sourcePath = storage_path('app/template'); //نسخ ملفات القالب
        $destinationPath = storage_path("app/stores/{$nameStor}"); //مسار حفظ ملفات المتجر الجديد في مجلد باسم التاجر

        // نسخ المجلد
        //للحماية اكثر يتم فحص اسم المتجر مرة اخرى
        if (!File::exists($destinationPath)) {
                File::copyDirectory($sourcePath, $destinationPath);
        } else {
                return response()->json(['error' => 'اسم المتجر موجود بالفعل.'], 400);
            }

        StoreInformation::create([
            'name' => $nameStor,
            'logo' => $fullPath,
            'location_store' => $location,
            'description' => $description,
            'mobile' => $mobile,
            'address_store' => $address_store,
            'num_struct' => $num_struct,
            'admin_id' => $id,
        ]);


        return $this->respondWithToken($token);
    }



    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->guard('admin')->user());
    }

    public function getReport(Request $request){
        $lastTraders = Admin::where('role','admin')->get()->count();
        $lastUsers = User::where('role','user')->get()->count();
        return response()->json([
            'lastTraders'=>$lastTraders,
            'lastUsers'=>$lastUsers
        ]);
    }





    //التحكم في اعدادات المتجر 
    public function settings()
    {
        $data = Settings::first();
        $user = Auth::user();
        return view('backend.setting')->with([
            'data' => $data,
            'user' => $user,
        ]);
    }


    
    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        Admin::find(auth()->guard('admin')->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);
        if($request->isJson() || $request->wantsJson()){
            return response()->json([
                'msg'=>'تم تغيير كلمة السر بنجاح'
            ]);
        }

        return redirect()->route('store/',$request->nameStore);

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('admin')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = $this->respondWithToken(auth()->guard('admin')->refresh());
        $admin = auth()->guard('admin')->user();
        $admin_id =session()->get('admin->id');
        return response()->json([
            'token'=>$token,
            'admin'=>$admin,
            'admin_id'=>$admin_id
        ]);
    }


    public function tokenIsFound(Request $request)
    {
        // الكود القديم
        $user = $request->user();
        // $token = $this->respondWithToken(auth()->guard('admin')->refresh());
        return response()->json([
            'user' => $user,
            // 'token' => $token,
        ]);

        //  الكود الجديد
        // $token = $request->cookie('token');
        // if ($token) {
        //     $user = Auth::guard('admin')->user();
        //     if ($user) {
        //         return response()->json([
        //             'status' => 'success',
        //             'user' => $user,
        //         ]);
        //     }
        // }

        // return response()->json(
        //     [
        //         'status' => 'error',
        //         'message' => 'User not Found or token is invalid.',
        //     ],
        //     404
        // );
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('admin')->factory()->getTTL() * 99999
        ]);
    }



    ////////////////////

    //from another website
    // public function loginUser(Request $request) {
    //     $credentials = $request->only('email', 'password');
    //     try {
    //         if (!$token = auth()->guard('admin')->attempt($credentials)) {
    //             return response()->json(['success' => false, 'error' => 'Some Error Message'], 401);
    //         }
    //     } catch (JWTException $e) {
    //         return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
    //     }
    //     return $this->respondWithToken($token);
    //   }
    //   public function loginAdmin(Request $request) {
    //     $credentials = $request->only('email', 'password');
    //     try {
    //         if (!$token = auth()->guard('admin')->guard('admin')->attempt($credentials)) {
    //             return response()->json(['success' => false, 'error' => 'Some Error Message'], 401);
    //         }
    //     } catch (JWTException $e) {
    //         return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
    //     }
    //     return $this->respondWithToken($token);
    //   }
    //   /**
    //    * Construct a json object to send to client
    //    * @param string token
    //    * @return Illuminate\Http\JsonResponse
    //   */
    //   protected function respondWithToken($token)
    //   {
    //       return response()->json([
    //           'success' => true,
    //           'data' => [
    //               'access_token' => $token,
    //               'token_type' => 'bearer',
    //               'expires_in' => auth()->guard('admin')->factory()->getTTL() * 60
    //           ]
    //       ], 200);
    //   }

    ///////////////////


}