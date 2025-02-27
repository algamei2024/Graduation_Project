<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Trader = auth()->guard('trader')->user();
        // dd($Trader->categories);
        // $category = Category::getAllCategory(); //الكود القديم
        $category = $Trader->categories()->paginate(10);

        return view('backend.category.index')->with('categories', $category);
        // return response()->json($category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats = Category::where('is_parent', 1)
            ->orderBy('title', 'ASC')
            ->get();
        return view('backend.category.create')->with(
            'parent_cats',
            $parent_cats
        );
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
        // dd($trader_id);

        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|nullable',
            'photo' => 'required|image|mimes:jpeg,png,gif,jfif|max:4096',
            'status' => 'required|in:active,inactive',
            'is_parent' => 'sometimes|in:1',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $data = $request->all();

        
        

        //التحقق مما اذا كان هناك صورة باسم logo
        if ($request->hasFile('photo')) {
            //حفظ الصورة مع  اسمها الحقيقي
            $image = $request->file('photo');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/' . $trader->name . '/categories', $imagePath);

            $fullPath = Storage::url($path); //تخزين مسار الصورة
            $data['photo'] = $fullPath;
        }

        $slug = Str::slug($request->title);
        $count = Category::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_parent'] = $request->input('is_parent', 0);
        $data['admin_id']= $trader_id;
        // return $data;
        $status = Category::create($data);
        if ($status) {
            request()
                ->session()
                ->flash('success', 'Category successfully added');
        } else {
            request()
                ->session()
                ->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('category.index');
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
        $parent_cats = Category::where('is_parent', 1)->get();
        $category = Category::findOrFail($id);
        return view('backend.category.edit')
            ->with('category', $category)
            ->with('parent_cats', $parent_cats);
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
        // $trader_id = auth()->guard('trader')->id();
        // return $request->all();
        $category = Category::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|nullable',
            //النوع mimes يتاكد من ان امتداد الصورة يقع من ضمن القائمة المعطية
            'photo' => 'nullable|image|mimes:jpeg,png,gif,jfif|max:4096',
            'status' => 'required|in:active,inactive',
            'is_parent' => 'sometimes|in:1',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $data = $request->all();

        
        //كود رفع الصورة
        //التاكد من انه تم رفع صورة++
        $oldfullPath = $category->photo;
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
            $path = $image->storeAs('public/images/' . $trader->name . '/categories', $imagePath);

            $newfullPath = Storage::url($path); //تخزين مسار الصورة
        }

        $photoPath = strlen($newfullPath) > 1 ? $newfullPath : $oldfullPath;
        $data['photo'] = $photoPath;


        $data['is_parent'] = $request->input('is_parent', 0);
        // return $data;
        $status = $category->fill($data)->save();
        if ($status) {
            request()
                ->session()
                ->flash('success', 'Category successfully updated');
        } else {
            request()
                ->session()
                ->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $child_cat_id = Category::where('parent_id', $id)->pluck('id');
        // return $child_cat_id;
        $status = $category->delete();

        if ($status) {
            if (count($child_cat_id) > 0) {
                Category::shiftChild($child_cat_id);
            }
            request()
                ->session()
                ->flash('success', 'Category successfully deleted');
        } else {
            request()
                ->session()
                ->flash('error', 'Error while deleting category');
        }
        return redirect()->route('category.index');
    }

    public function getChildByParent(Request $request)
    {
        // return $request->all();
        $category = Category::findOrFail($request->id);
        $child_cat = Category::getChildByParentID($request->id);
        // return $child_cat;
        if (count($child_cat) <= 0) {
            return response()->json([
                'status' => false,
                'msg' => '',
                'data' => null,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'msg' => '',
                'data' => $child_cat,
            ]);
        }
    }
}