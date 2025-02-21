<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Hash;
use Session;
use App\User;
use Carbon\Carbon;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Rules\MatchOldPasswordAdmin;
use App\Models\StoreInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use App\Traits\HttpResponses;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

// use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //iam wtitten in here
    use HttpResponses;

    public  $token;
    public $folder_name = 'stores';
    
    public function newTitle()
    {
        $data = config('app.name', 'Laravel');
        return response()->json($data);
    }
    // public function testtoken(){
    //     $trader_id = auth()->guard('trader')->id();
    //     //ارسال توكن التاجر
    //     $trader = Admin::where('id',$trader_id)->first();
    //     $token = $trader->createToken('api token'.$trader->name)->plainTextToken;
    //     return response()->json([
    //         'token'=>$token,
    //     ]);
    // }

    public function showStore(Request $request){
        $trader_id = auth()->guard('trader')->id();
        $store_info = StoreInformation::where('admin_id', $trader_id)->first();
        $nameStore = $store_info['name'];
        $logo = $store_info['logo'];
        return redirect()->route('store/',['name'=>$nameStore]);
    }

    // send data design to react project
    public function sendDataDesign(Request $request){
        // http://localhost:5173/gotoReact   مسار صفحة رياكت
        $trader_id = auth()->guard('trader')->id();
        //ارسال توكن التاجر
        $trader = Admin::where('id',$trader_id)->first();
        $token = $trader->createToken('api token'.$trader->name)->plainTextToken;

        $nameFile = $request->input('nameFile');
        
        return response()->json([
            'trader_id'=>$trader_id,
            'token'=>$token,
            'nameFile'=>$nameFile,
        ]);
            
    }
    public function getData(Request $request){
        $trader_id = $request->input('id');

         //الحصول على اسم الملف الذي تم طلب التعديل عليه
         $nameFile = $request->input('nameFile');
        
        // الحصول على اسم المتجر بناء على id التاجر
        $store_info = StoreInformation::where('admin_id', $trader_id)->first();
        $nameStore = $store_info['name'];

        
        
        // $filePath = 'storage/public/stores/one/card/1.html'; // قم بتحديث المسار إلى الملف الصحيح
        
        $dataHtml = "$this->folder_name/$nameStore/$nameFile.html";
        $dataCss = "$this->folder_name/$nameStore/css/style-prefix.css";
        $html = Storage::get($dataHtml);
        $css = Storage::get($dataCss);
        // $token = $request->header('X-CSRF-TOKEN');

        return response()->json([
            'nameFile'=>$nameFile,
            // 'filePath'=>$filePath,
            'nameStore'=>$nameStore,
            'html'=>$html,
            'css'=>$css,
        ]);
    }

    public function saveDataDesign(Request $request){
        
        $trader = $request->user();
        // $admin = Admin::where('id',$admin_id)->first();
        // $token = $admin->createToken('api token trader'.$admin->name)->plainTextToken;
        // $token = $admin->currentAccessToken();
        // $token = JWTAuth::fromUser($admin);
        $nameFile = $request->input('nameFile');
        $dataCode = $request->input('dataCode');

        $decodeDataCard = urldecode($dataCode);

        $store_info = StoreInformation::where('admin_id', $trader->id)->first();
        $nameStore = $store_info['name'];

        Storage::put("$this->folder_name/$nameStore/$nameFile.html", $decodeDataCard);
        return response()->json([
            'msg'=>'تم التعديل بنجاح',
        ]);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required|max:30',
            'email' => 'string|required|unique:users',
            'password' => 'string|required',
            // 'role' => 'required|in:admin,owner',
            // 'status' => 'required|in:active,inactive',
            'photo' => 'nullable|string',
        ]);
        // dd($request->all());
        $data = $request->all();
        // $data['role']='store';
        $data['password'] = Hash::make($request->password);
        $data['role']= 'owner';
        // dd($data);
        $status = Admin::create($data);
        // dd($status);
        if ($status) {
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json([
                    'msg' => 'تم إضافة مستخدم جديد',
                ]);
            } else {
                request()
                    ->session()
                    ->flash('success', 'Successfully added user');
            }
        } else {
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json([
                    'msg' => 'حدث خطا اثناء اضافة مستخدم جديد',
                ]);
            } else {
                request()
                    ->session()
                    ->flash('error', 'Error occurred while adding user');
            }
        }
        return redirect()->route('users.index');
    }

    public function fetchDataDesign(){
        $admin =auth()->guard('trader')->user();
        return response()->json([
            'msg'=>'تم ارسال بيانات التصميم بنجاح',
            'admin'=>$admin
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $admin = Admin::findOrFail($id);
        if($request->isJson()|| $request->wantsJson()) {
            return response()->json([
                'admin' => $admin,
            ]);
        } else {
            return view('backend.users.edit')->with('user', $admin);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $request->validate([
            'name' => 'string|required|max:30',
            'email' => 'string|required',
            'role' => 'required|in:admin,owner',
            // 'status' => 'required|in:active,inactive',
            'photo' => 'nullable|string',
        ]);
        // dd($request->all());
        $data = $request->all();
        // dd($data);

        $status = $admin->fill($data)->save();
        if ($status) {
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json([
                    'msg' => 'تم تعديل المتسخدم بنجاح',
                ]);
            } else {
                request()
                    ->session()
                    ->flash('success', 'Successfully updated');
            }
        } else {
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json([
                    'msg' => 'حدث خطا اثناء تعديل المستخدم',
                ]);
            } else {
                request()
                    ->session()
                    ->flash('error', 'Error occured while updating');
            }
        }
        return redirect()->route('users.index');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $delete = Admin::findorFail($id);
        $status = $delete->delete();
        if ($status) {
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json(['msg' => 'تم الحذف']);
            } else {
                request()
                    ->session()
                    ->flash('success', 'User Successfully deleted');
            }
        } else {
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json(['msg' => 'فشل الحذف']);
            } else {
                request()
                    ->session()
                    ->flash('error', 'There is an error while deleting users');
            }
        }
        return redirect()->route('users.index');
    }

    public function getOwner()
    {
        return auth()->guard('admin')->user();
    }


        // Login
    public function login()
    {
        if (Auth::guest()) {
            return view('auth.loginTrader');
        } 
        // else {
        //     return redirect()->route('home');
        // }
    }
        public function loginSubmit(Request $request)
        {
            //api for this => http://127.0.0.1:8000/api/user/login
                $request->validate([
                    // 'email' => 'required|email|exists:admins,email',
                    'email' => [
                        'required',
                        'email',
                        Rule::exists('admins','email')->where(function ($query){
                            $query->where('role','admin');
                        }),
                    ],
                    'password' => 'required|min:6',
                ], [
                    'email.required' => 'البريد الإلكتروني مطلوب.',
                    'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
                    'email.exists' => 'هذا البريد الإلكتروني غير موجود.',
                    'password.required' => 'كلمة المرور مطلوبة.',
                    'password.min' => 'يجب أن تكون كلمة المرور على الأقل 6 أحرف.',
                ]);
            $data = $request->all();
            
            try {
                if (
                    auth()->guard('trader')->attempt([
                        'email' => $data['email'],
                        'password' => $data['password'],
                        'status' => 'active',
                    ],$request->remember)
                ) {
                    Session::put('trader', $data['email']);
                    
                    $admin = Admin::where('email', $request->email)->first();
    
                    if ($request->isJson() || $request->wantsJson()) {
                        
                        return $this->sucess([
                            'user' => $admin,
                            'token' => $admin->createToken(
                                'Api Token of' . $admin->name
                            )->plainTextToken,
                        ]);
                    } else {

                        request()
                            ->session()
                            ->flash('success', 'Successfully login');
                        return redirect()->route('admin');
                    }
                } else {
                    if ($request->isJson() || $request->wantsJson()) {
                        return response()->json(
                            [
                                'success' => true,
                                'messagge' => 'فشل تسجيل الدخول',
                            ],
                            422
                        );
                    } else {

                        request()
                            ->session()
                            ->flash(
                                'error',
                                'Invalid email and password pleas try again!'
                            );
                        return redirect()->back();
                    }
                }
            } catch (\Exception $e) {
                return response()->json(
                    [
                        'success' => false,
                        'messagge' => 'حدث خطا',
                    ],
                    422
                );
            }
    
            return response()->json([
                'msg' => 'تم التسجيل',
            ]);
        }
    
        public function show()
        {
            $users = Admin::all();
            return response()->json([
                'user' => $users,
            ]);
        }
    
        public function logout(Request $request)
        {
            //api fo this => http://127.0.0.1:8000/api/user/logout
    
            // لم تستخدم هذه الدالة
            Auth::guard('admin')->logout();  //auth('admin') = تساوي = Auth::guard('admin')
            Session::forget('admin');
            // $request->session()->invalidate();
            // $request->session()->regenerateToken();
    
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json([
                    'mssagge' => 'تم تسجيل الخروج بنجاح',
                ]);
            } else {
                request()
                    ->session()
                    ->flash('success', 'Logout successfully');
                return redirect()->route('login.form');
            }
        }

        public function logoutTrader(Request $request)
        {
            auth()->guard('trader')->logout(); //تسجيل خروج المستخدم الحالي (التاجر)  //auth('admin') = تساوي = Auth::guard('admin')
            // Session::forget('admin');
            $request->session()->invalidate(); //إنهاء الجلسة الحالية (حذف جميع البيانات المرتبطة بها)
            $request->session()->regenerateToken(); // تجديد رمز CSRF لتوفير أمان إضافي


    
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json([
                    'mssagge' => 'تم تسجيل الخروج بنجاح',
                ]);
            } else {
                request()
                    ->session()
                    ->flash('success', 'Logout successfully');
                return redirect()->route('trader.login');
            }
        }
    
        public function refresh(Request $request)
        {
            $user = $request->user();
            $user->tokens()->delete();
    
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('Api of ' . $user->name)
                    ->plainTextToken,
            ]);
        }
        public function tokenIsFound(Request $request)
        {
            //الكود القديم
            $user = $request->user();
            return response()->json([
                'user' => $user,
            ]);
    
            //  الكود الجديد
            // $token = $request->cookie('token');
    
            // if ($token) {
            //     $user = Auth::guard('api')->user();
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
    
        public function register()
        {
            if (Auth::guard('admin')->guest()) {
                return view('frontend.pages.register');
            } else {
                return redirect()->route('home');
            }
        }
        public function registerSubmit(Request $request)
        {
            //كود انشاء حساب
            //API for this => http://127.0.0.1:8000/api/user/register
            // return $request->all();
            $data = $request->validate([
                'name' => 'string|required|min:2',
                'email' => 'string|required|unique:admins,email',
                'password' => 'required|min:6|confirmed', //هذا الشرط confirmed يعني انه يجب ان تضع حقل باسم password_confirmation
            ]);
    
            // $data = $request->all();
            // dd($data);
    
            // //فحص ما اذا كان المستخدم سجل من المنصة باستخدام api
            // //او انه سجل من متجر التاجر
            // if ($request->isJson() || $request->wantsJson()) {
            //     $data['role'] = 'store';
            // } else {
            //     $data['role'] = 'user';
            // }
            $check = Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status' => 'active',
            ]);
            // Session::put('admin', $data['email']);
            // Auth::guard('admin')->login($check);
            $credentials = request(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            if ($check) {
                if ($request->isJson() || $request->wantsJson()) {
                    // $token = $check->createToken('api Token of ' . $check->name)
                    //     ->plainTextToken;
                    $admin = Auth::guard('admin')->user();
    
                    return response()->json([
                        'user' => $admin,
                        'token' => $token,
                    ]);
                } else {
                    request()
                        ->session()
                        ->flash('success', 'Successfully registered');
                    return redirect()->route('home');
                }
            } else {
                if ($request->isJson() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'messagge' => 'فشل إنشاء حساب  ',
                    ]);
                } else {
                    request()
                        ->session()
                        ->flash('error', 'Please try again!');
                    return back();
                }
            }
        }
    public function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
        ]);
    }


    public function getAllAdmins(){
        $admins = Admin::where('role','admin')->get();
        return response()->json([
            'admins'=>$admins
        ]);
    }

    ///////////



    public function index()
    {
        $data = User::select(
            \DB::raw('COUNT(*) as count'),
            \DB::raw('DAYNAME(created_at) as day_name'),
            \DB::raw('DAY(created_at) as day')
        )
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('users', json_encode($array));
    }

    public function profile()
    {
        $profile = auth()->guard('trader')->user();
        // return $profile;
        return view('backend.users.profile')->with('profile', $profile);
    }

    public function adminProfileUpdate(Request $request, $id){
        $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:admins,email,'.auth()->guard('trader')->id() ,//الجزء الاخيرمن هذا السطر معنا استثناء الايميل الحالي من الشرط
            'profile-img' => 'nullable|image|mimes:jpeg,png,gif|max:4096',
        ]);

        $data = $request->all();
        $trader = Admin::where('id',$id)->first();

        $oldfullPath =$trader->photo;
        $oldPhoto = public_path($oldfullPath);

        $newPath = '';
        if($request->hasFile('photo')){
             //كود حذف الصورة القديمة
            if(file_exists($oldPhoto) && strlen($oldfullPath)>0){
                unlink($oldPhoto);
            }
            //كود اضافة الصورة الجديدة
            $image = $request->file('photo');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/' . $trader->name, $imagePath);
            $newPath = Storage::url($path); //تخزين مسار الصورة
        }
        

        $newPhotoPath = strlen($newPath) > 1 ? $newPath : $oldfullPath;
        $data['photo'] = $newPhotoPath;

        $status = $trader->fill($data)->save();
        if ($status) {
            request()
                ->session()
                ->flash('success', 'Successfully updated your profile');
        } else {
            request()
                ->session()
                ->flash('error', 'Please try again!');
        }
        return redirect()->back();
    }

    public function profileUpdate(Request $request, $id)
    {
        // return $request->all();
        $user = User::findOrFail($id);
        $data = $request->all();
        $status = $user->fill($data)->save();
        if ($status) {
            request()
                ->session()
                ->flash('success', 'Successfully updated your profile');
        } else {
            request()
                ->session()
                ->flash('error', 'Please try again!');
        }
        return redirect()->back();
    }

    //قم بحذف دوال settings فقد تم نقلها الى AuthController
    public function settings()
    {
        $data = Settings::first();
        $user = Auth::user();
        return view('backend.setting')->with([
            'data' => $data,
            'user' => $user,
        ]);
    }

    public function settingsUpdate(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'short_des' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required',
            // 'logo' => 'required',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);
        $data = $request->all();
        // return $data;
        $settings = Settings::first();
        // return $settings;
        $status = $settings->fill($data)->save();


        //i'm adding
        //تعديل الشعار في قاعدة البيانات وفي الملفات
        // $user = Auth::user();

        // $storeInfo = StoreInformation::where('user_id', $user->id)->first();

        // $oldImagePath = $storeInfo->logo;
        // if ($request->hasFile('newlogo')) {
        //     //كود حذف الصورة القديمة
        //     $fullPath = public_path($oldImagePath);
        //     if (file_exists($fullPath)) {
        //         unlink($fullPath);
        //     }

        //     //كود اضافة الصورة الجديدة
        //     $image = $request->file('newlogo');
        //     $imagePath = $image->getClientOriginalName();
        //     $path = $image->storeAs('public/images/' . $user->name, $imagePath);

        //     $fullPath = Storage::url($path); //تخزين مسار الصورة
        //     $storeInfo->update([
        //         'logo' => $fullPath,
        //     ]);

        //     $storeInfo->save();
        // }

        //end adding
        if ($status) {
            request()
                ->session()
                ->flash('success', 'Setting successfully updated');
        } else {
            request()
                ->session()
                ->flash('error', 'Please try again');
        }
        return redirect()->route('admin');
    }

    public function changePassword()
    {
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        // dd(auth()->user()->id);
        $request->validate([
            'current_password' => ['required', new MatchOldPasswordAdmin()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        // User::find(auth()->user()->id)->update([
        //     'password' => Hash::make($request->new_password),
        // ]);
        Admin::find(auth()->guard('trader')->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()
            ->route('admin')
            ->with('success', 'Password successfully changed');
    }

    // Pie chart مخطط دائري
    public function userPieChart(Request $request)
    {
        // لم يتم استخدام هذا الكود
        // dd($request->all());
        // تقارير بعدد الاشخاص المسجلين باخر 6 ايام عدد المسجلين في كل يوم
        $data = User::select(
            \DB::raw('COUNT(*) as count'), //العدد
            \DB::raw('DAYNAME(created_at) as day_name'),//اسم اليوم
            \DB::raw('DAY(created_at) as day')//رقم ترتيب اليوم مثلا السبت = 1
        )
            ->where('created_at', '>', Carbon::today()->subDay(6)) // Crabon دالة في php لتسهيل التعامل مع التاريخ والوقت
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('course', json_encode($array));
    }

    // public function activity(){
    //     return Activity::all();
    //     $activity= Activity::all();
    //     return view('backend.layouts.activity')->with('activities',$activity);
    // }

    public function storageLink()
    {
        // check if the storage folder already linked;
        if (File::exists(public_path('storage'))) {
            // removed the existing symbolic link
            File::delete(public_path('storage'));

            //Regenerate the storage link folder
            try {
                Artisan::call('storage:link');
                request()
                    ->session()
                    ->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            } catch (\Exception $exception) {
                request()
                    ->session()
                    ->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        } else {
            try {
                Artisan::call('storage:link');
                request()
                    ->session()
                    ->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            } catch (\Exception $exception) {
                request()
                    ->session()
                    ->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        }
    }
}