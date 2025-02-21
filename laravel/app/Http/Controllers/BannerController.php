<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner=Banner::orderBy('id','DESC')->where('admin_id',auth()->guard('trader')->id())->paginate(10);
        return view('backend.banner.index')->with('banners',$banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
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
        // return $request->all();
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            // 'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();

      //كود رفع الصورة
        //التاكد من انه تم رفع صورة++
        $validator = Validator::make($request->all(), [
            //النوع mimes يتاكد من ان امتداد الصورة يقع من ضمن القائمة المعطية
            'photo' => 'required|image|mimes:jpeg,png,gif|max:4096',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        //التحقق مما اذا كان هناك صورة باسم logo
        if ($request->hasFile('photo')) {
            //حفظ الصورة مع  اسمها الحقيقي
            $image = $request->file('photo');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/' . $trader->name, $imagePath);

            $fullPath = Storage::url($path); //تخزين مسار الصورة
            $data['photo'] = $fullPath;
        }


        $slug=Str::slug($request->title);
        $count=Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['admin_id']= $trader_id;
        // return $slug;
        $status=Banner::create($data);
        if($status){
            request()->session()->flash('success','Banner successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding banner');
        }
        return redirect()->route('banner.index');
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
    public function edit($id)
    {
        $banner=Banner::findOrFail($id);
        return view('backend.banner.edit')->with('banner',$banner);
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
        $banner=Banner::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            //النوع mimes يتاكد من ان امتداد الصورة يقع من ضمن القائمة المعطية
            'photo' => 'nullable|image|mimes:jpeg,png,gif|max:4096',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();


        //كود رفع الصورة
        //التاكد من انه تم رفع صورة++
        $oldfullPath = $banner->photo;
        $oldImagePath = public_path($oldfullPath);
        // dd($oldImagePath);
        $newfullPath = '';

        // $validator = Validator::make($request->all(), [
        //     //النوع mimes يتاكد من ان امتداد الصورة يقع من ضمن القائمة المعطية
        //     'photo' => 'nullable|image|mimes:jpeg,png,gif|max:4096',
        // ]);
        // if ($validator->fails()) {
        //     return back()->withErrors($validator->errors());
        // }



        //التحقق مما اذا كان هناك صورة باسم logo
        if ($request->hasFile('photo')) {
            //كود حذف الصورة القديمة
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            //حفظ الصورة مع  اسمها الحقيقي
            $image = $request->file('photo');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/' . $trader->name, $imagePath);

            $newfullPath = Storage::url($path); //تخزين مسار الصورة
        }

        $photoPath = strlen($newfullPath) > 1 ? $newfullPath : $oldfullPath;
        $data['photo'] = $photoPath;




        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        $status=$banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Banner successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating banner');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner=Banner::findOrFail($id);
        $status=$banner->delete();
        if($status){
            request()->session()->flash('success','Banner successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}