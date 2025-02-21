<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\StoreInformation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class StoreInformationController extends Controller
{
//     public function __construct()
// {
//     $this->middleware('auth:admin');
// }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // التحقق من رقم المتجر ما اذ كان موجود سابقا
    public function testNameAndMobileStore(Request $request){
        // يتم اولا التحقق من الاسم
        $nameStore = 'app/stores/'. $request->input('nameStore') ;
        if (File::exists(storage_path($nameStore))) {
            return response()->json(['error' => 'اسم المتجر موجود بالفعل.'], 400);
        }
        
        //تلقائيا هذه ال validate ترجع خطا اذا لم يتحقق الشرط الذي داخلها
        $request->validate([
            'mobile'=>'required|unique:store_information,mobile'
        ]);
        
        return response()->json([
            'msg'=>'واصل عملية التسجيل'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //حفظ الصورة مع اسم عشوائي
        // $path = $request->file('image')->store('public/uploads');

        $user = auth()->guard('admin')->user();
        $request->validate([
            'name'=>'required',
            'mobile'=>'required',
            'description'=>'required',
        ]);
        // return response()->json([
        //     'user' => $user,
        // ]);

        $fullPath = null;

        //التاكد من ان المرسل ارسل صورة
        $validator = Validator::make($request->all(), [
            //النوع mimes يتاكد من ان امتداد الصورة يقع من ضمن القائمة المعطية
            'logo' => 'required|image|mimes:jpeg,png,gif|max:4096',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //التحقق مما اذا كان هناك صورة باسم logo
        if ($request->hasFile('logo')) {
            //حفظ الصورة مع  اسمها الحقيقي
            $image = $request->file('logo');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/' . $user->name, $imagePath);

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


        $name = $request->input('name');
        $location = $request->input('location_sotre');
        $mobile = $request->input('mobile');
        $description = $request->input('description');
        $address_store = $request->input('address_store');
        $num_struct = $request->input('num_struct');
        $id = $user->id;

        //انشاء ملفات المتجر
        // تحديد المسارات
        $sourcePath = storage_path('app/template');
        $destinationPath = storage_path("app/stores/{$name}");

        // نسخ المجلد
        if (!File::exists($destinationPath)) {
                File::copyDirectory($sourcePath, $destinationPath);
        } else {
                return response()->json(['error' => 'اسم المتجر موجود بالفعل.'], 400);
            }

        StoreInformation::create([
            'name' => $name,
            'logo' => $fullPath,
            'location_store' => $location,
            'description' => $description,
            'mobile' => $mobile,
            'address_store' => $address_store,
            'num_struct' => $num_struct,
            'admin_id' => $id,
        ]);

        

        return response()->json([
            'patah' => $fullPath,
            'id' => $id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(StoreInformation $storeInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreInformation $storeInformation)
    {
        $admin = auth()->guard('trader')->user();
        $data = StoreInformation::where('admin_id',$admin->id)->first();
        // dd($data);
        // $data = Settings::first();
        // $user = Auth::user();
        return view('backend.setting')->with([
            'data' => $data,
            'admin' => $admin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function udpate(Request $request,$id,$name)
    {
        //كود حفظ تعديلات بيانات المتجر 
        //اسم المسار updatae.storeInfo
        $this->validate($request, [
            'name' => 'required|string',
            // 'short_des' => 'required|string',
            'description' => 'required|string',
            // 'photo' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:5120',
            // 'bill' => 'required', //ايقونة المتجر
            // 'address' => 'required|string',
            // 'email' => 'required|email',
            // 'phone' => 'required|string',
            'mobile' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'required|string',
            'address3' => 'required|string',
        ]);
        $data = $request->all();

        //i'm adding

        //تعديل الشعار في قاعدة البيانات وفي الملفات
        // $user = Auth::user();

        $storeInfo = StoreInformation::where('admin_id', $id)->first();

        $oldfullPath = $storeInfo->logo;
        $oldImagePath = public_path($oldfullPath);
        $newfullPath = '';

        if ($request->hasFile('logo')) {
            //كود حذف الصورة القديمة
            if (file_exists($oldImagePath)) {  // if(File::exists($oldfullPath))
                unlink($oldImagePath);          //  File::delete($oldfullPath)
            }
            //كود اضافة الصورة الجديدة
            $image = $request->file('logo');
            // $imagePath =date('ymdHi').$image->getClientOriginalName();//اسناد التاريح الى اسم الصورة
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/' . $name, $imagePath);
            $newfullPath = Storage::url($path); //تخزين مسار الصورة
        }

        //تخزين البيانات
        $name = $data['name'];
        $description = $data['description'];
        $mobile = $data['mobile'];

        $location =
            $data['address1'] .
            '/' .
            $data['address2'] .
            '-' .
            $data['address3'];

        //تحديث اسم المتجر في المجلدات
        $oldName = $storeInfo['name'];
        $newName = $name;
        
        $oldPathFolder = storage_path("app/stores/{$oldName}");
        $newPathFolder = storage_path("app/stores/{$newName}");

        if(is_dir($oldPathFolder)){
            rename($oldPathFolder,$newPathFolder);
        }

        //تحديث البيانات
        $logoPath = strlen($newfullPath) > 1 ? $newfullPath : $oldfullPath;
        $status = $storeInfo->update([
            'name' => $name,
            'logo' => $logoPath,
            'location_store' => $location,
            'description' => $description,
            'mobile' => $mobile,
        ]);


        // $storeInfo->save();

        //كود حفظ شعار الفاتورة
        // $status = $settings->update([
        //     'logo'=>$data
        // ]);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreInformation $storeInformation)
    {
        //
    }
}