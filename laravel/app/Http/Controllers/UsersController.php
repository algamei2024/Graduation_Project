<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Models\StoreInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_id = auth()->guard('trader')->id();
        $users = User::where('admin_id',$admin_id)->orderBy('id', 'ASC')->paginate(10); //لاجل ان يتم عرض 10 مستخديمن في كل صفحة

        // $users = User::all();

        if ($request->isJson() || $request->wantsJson()) {
            return response()->json([
                'user' => $users,
            ]);
        }

        return view('backend.users.index')->with('users', $users);
    }

    //الذهاب الى صفحة تعديل الملف الشخصي
    public function profile(Request $request,$name){//name هنا هو اسم المتجر
        if(Auth::check()){
            $profile = Auth::user();

            return view('storeSections.profile',compact('profile','name'));
        }
    }

    // تعديل الملف الشخصي
    public function updateProfile(Request $request){
        $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:users,email,'. auth()->id() ,//الجزء الاخيرمن هذا السطر معنا استثناء الايميل الحالي من الشرط
            'profile-img' => 'nullable|image|mimes:jpeg,png,gif|max:4096',
        ]);
        $data = $request->all();
        $user = User::where('id',$data['user_id'])->first();

        $oldfullPath =$user->photo;
        $oldPhoto = public_path($oldfullPath);

        $newPath = '';
        if($request->hasFile('profile-img')){
             //كود حذف الصورة القديمة
            if(file_exists($oldPhoto) && strlen($oldfullPath)>0){
                unlink($oldPhoto);
            }
            //كود اضافة الصورة الجديدة
            $image = $request->file('profile-img');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/users/' . $user->name, $imagePath);
            $newPath = Storage::url($path); //تخزين مسار الصورة
        }
        

        $newPhotoPath = strlen($newPath) > 1 ? $newPath : $oldfullPath;
        $user->update([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'photo'=>$newPhotoPath
        ]);
        $user->save();

        return redirect()->route('store/',$request->nameStore);


    }

    // الصفحة الرئيسية
    public function homeStore(Request $request){
        return redirect()->route('store/',$request->name);
    }
    //رؤية منتجات صنف معين
    public function listCategory(Request $request,$name,$id){
        // if($id == 'الرئيسية'){
        //     $store_info = StoreInformation::where('name',$name)->first();
        //     $admin = Admin::find($store_info['admin_id']);
        //     $cat = $admin->categories;
        //     $dataB =Banner::orderBy('id','DESC')->where('admin_id',$admin->id)->paginate(10);
        //     $products = $admin->products()->paginate(8);
        //     if($name){
        //         $namecat = $name;
        //         return view('storeSections.home',compact('name','products','cat','dataB'));
                
        //         // return view('storeSections.home',compact('namecat'));
        //     }
        //     // return view('storeSections.list');
        // }



        $products = Product::where('cat_id',$id)->get();
        return view('storeSections.list', compact('products','name'));
        // $name  = $request->input('name');
        // $category = $request->input('category');
        // return view('storeSections.list',compact('name','category'));
    }

    // الذهاب الى صفحة تغيير كلمة السر
    public function changePassword(Request $request){
        $name = $request->input('name');
        return view('storeSections.changePassword', compact('name'));
    }

    // تغيير كلمة السر
    public function changePasswordStore(Request $request){
        
        $request->validate([
            'current_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('store/',$request->nameStore);

        // return redirect()
        //     ->route('admin')
        //     ->with('success', 'Password successfully changed');
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trader = auth()->guard('trader')->user();
        $trader_id = auth()->guard('trader')->id();
        $this->validate($request, [
            'name' => 'string|required|max:30',
            'email' => 'string|required|unique:users',
            'password' => 'string|required',
            // 'role' => 'required|in:admin,store,user',
            'status' => 'required|in:active,inactive',
            // 'photo' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,gif|max:4096',
        ]);
        $data = $request->all();

        //كود رفع الصورة
        //التحقق مما اذا كان هناك صورة باسم logo
        if ($request->hasFile('photo')) {
            //حفظ الصورة مع  اسمها الحقيقي
            $image = $request->file('photo');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/users/' . $trader->name , $imagePath);

            $fullPath = Storage::url($path); //تخزين مسار الصورة
            $data['photo'] = $fullPath;
        }

        
        // $data['role']='store';
        $data['password'] = Hash::make($request->password);
        $data['admin_id'] = $trader_id;
        // dd($data);
        $status = User::create($data);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $user = User::findOrFail($id);
        if($request->isJson()|| $request->wantsJson()) {
            return response()->json([
                'user' => $user,
            ]);
        } else {
            return view('backend.users.edit')->with('user', $user);
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
        $trader = auth()->guard('trader')->user();
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'string|required|max:30',
            'email' => 'string|required',
            'role' => 'required|in:admin,store,user',
            'status' => 'required|in:active,inactive',
            // 'photo' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,gif|max:4096',
        ]);
        // dd($request->all());
        $data = $request->all();


        //كود رفع الصورة
        //التاكد من انه تم رفع صورة++
        $oldfullPath = $user->photo;
        $oldImagePath = public_path($oldfullPath);
        $newfullPath = '';

        //التحقق مما اذا كان هناك صورة باسم logo
        if ($request->hasFile('photo')) {
            //كود حذف الصورة القديمة
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            //حفظ الصورة مع  اسمها الحقيقي
            $image = $request->file('photo');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/users/' . $trader->name , $imagePath);

            $newfullPath = Storage::url($path); //تخزين مسار الصورة
        }

        $photoPath = strlen($newfullPath) > 1 ? $newfullPath : $oldfullPath;
        $data['photo'] = $photoPath;



        $status = $user->fill($data)->save();
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
        $delete = User::findorFail($id);
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

    public function getuser()
    {
        return Auth::user();
    }
}