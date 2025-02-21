<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Trader = auth()->guard('trader')->user();
        $products = $Trader->products()->orderBy('created_at','desc')->paginate(10);
        // $products = Product::getAllProduct();
        return view('backend.product.index')->with('products', $products);
        // return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin_id = auth()->guard('trader')->id();
        $brand = Brand::get();
        // $category = Category::where('is_parent', 1)->get();
        $category = Category::where('admin_id', $admin_id)->get();
        // return $category;
        return view('backend.product.create')
            ->with('categories', $category)
            ->with('brands', $brand);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            //النوع mimes يتاكد من ان امتداد الصورة يقع من ضمن القائمة المعطية
            'photo' => 'required|image|mimes:jpeg,png,gif|max:4096',
            'size' => 'nullable',
            'stock' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1', //sometimes=> تعني أن التحقق من هذا الحقل سيتم فقط إذا كان موجودًا في الطلب
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $data = $request->all();

        //الحصول على اسم التاجر
        $cat = Category::where('id',$request->input('cat_id'))->first();
        $trader = Admin::where('id',$cat['admin_id'])->first();

        //التحقق مما اذا كان هناك صورة باسم logo
        if ($request->hasFile('photo')) {
            //حفظ الصورة مع  اسمها الحقيقي
            $image = $request->file('photo');
            $imagePath = $image->getClientOriginalName();
            $path = $image->storeAs('public/images/' . $trader->name .'/products', $imagePath);

            $fullPath = Storage::url($path); //تخزين مسار الصورة
            $data['photo'] = $fullPath;
        }
        
        
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count(); // للتحقق من ان المنتج فريد وذلك بالتاكد من انه لا يوجد slug مشابه لل slug المنتج الجديد
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);// لكي نضمن انه منتج فريد
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size); // دمج عناصر مصفوفة size مع بعضها في سلسلة نصية
        } else {
            $data['size'] = '';
        }
        // return $size;
        // return $data;
        $status = Product::create($data);
        if ($status) {
            request()
                ->session()
                ->flash('success', 'Product Successfully added');
            // return response()->json([
            //     'mssagge' => 'تم اضافة المنتج بنجاح',
            // ]);
        } else {
            request()
                ->session()
                ->flash('error', 'Please try again!!');
            // return response()->json([
            //     'mssagge' => 'فشل اضافة المنتج',
            // ]);
        }

        return redirect()->route('product.index');
        // return response()->json([
        //     'mssagge' => 'لم يتم اضافة المنتج',
        // ]);
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
        $brand = Brand::get();
        $product = Product::findOrFail($id); // اذا لم يكن موجود يتم اظهار صفحة خطا 404
        $category = Category::where('is_parent', 1)->get();
        // $items = Product::where(column: 'id', $id)->get();
        $items = Product::where('id',$id)->get();
        // return $items;
        return view('backend.product.edit')
            ->with('product', $product)
            ->with('brands', $brand)
            ->with('categories', $category)
            ->with('items', $items);
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
        $product = Product::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            //النوع mimes يتاكد من ان امتداد الصورة يقع من ضمن القائمة المعطية
            'photo' => 'nullable|image|mimes:jpeg,png,gif|max:4096',
            'size' => 'nullable',
            'stock' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $data = $request->all();

         //كود رفع الصورة
        //التاكد من انه تم رفع صورة++
        $oldfullPath = $product->photo;
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
            $path = $image->storeAs('public/images/' . $trader->name . '/products', $imagePath);

            $newfullPath = Storage::url($path); //تخزين مسار الصورة
        }

        $photoPath = strlen($newfullPath) > 1 ? $newfullPath : $oldfullPath;
        $data['photo'] = $photoPath;


        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }
        // return $data;
        $status = $product->fill($data)->save();
        if ($status) {
            request()
                ->session()
                ->flash('success', 'Product Successfully updated');
        } else {
            request()
                ->session()
                ->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // حذف الصورة من الملفات
        $photo = $product->photo;
        $photoPath = public_path($photo);
        if (file_exists($photoPath)) {
            unlink($photoPath); // unlink=> تحذف الملف او الصورة من النظام
        }
        $status = $product->delete();

        if ($status) {
            request()
                ->session()
                ->flash('success', 'Product successfully deleted');
        } else {
            request()
                ->session()
                ->flash('error', 'Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}