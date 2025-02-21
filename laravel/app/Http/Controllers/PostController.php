<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts=Post::getAllPost();


        $admin_id = auth()->guard('trader')->id(); //id التاجر الحالي
        $users_id  = User::where('admin_id',$admin_id)->pluck('id'); // المستخدمسن المرتبظين بالتاجر الحالي
        $posts=Post::whereIn('added_by',$users_id)->orderBy('id','DESC')->paginate(10); //  ال post المرتبطه بهؤلاء المستخدمين


        return view('backend.post.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=PostCategory::get();
        $tags=PostTag::get();
        $users=User::get();
        return view('backend.post.create')->with('users',$users)->with('categories',$categories)->with('tags',$tags);
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
        // return $request->all();
        $this->validate($request,[
            'title'=>'string|required',
            'quote'=>'string|nullable',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            // 'photo'=>'string|nullable',
            'tags'=>'nullable',
            'added_by'=>'nullable',
            'post_cat_id'=>'required',
            'status'=>'required|in:active,inactive'
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
        $count=Post::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;

        $tags=$request->input('tags');
        if($tags){
            $data['tags']=implode(',',$tags);
        }
        else{
            $data['tags']='';
        }
        // return $data;

        $status=Post::create($data);
        if($status){
            request()->session()->flash('success','Post Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('post.index');
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
        $post=Post::findOrFail($id);
        $categories=PostCategory::get();
        $tags=PostTag::get();
        $users=User::get();
        return view('backend.post.edit')->with('categories',$categories)->with('users',$users)->with('tags',$tags)->with('post',$post);
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
        $post=Post::findOrFail($id);
         // return $request->all();
         $this->validate($request,[
            'title'=>'string|required',
            'quote'=>'string|nullable',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            // 'photo'=>'string|nullable',
            'tags'=>'nullable',
            'added_by'=>'nullable',
            'post_cat_id'=>'required',
            'status'=>'required|in:active,inactive'
        ]);

        $data=$request->all();

         //كود رفع الصورة
        //التاكد من انه تم رفع صورة++
        $oldfullPath = $post->photo;
        $oldImagePath = public_path($oldfullPath);
        $newfullPath = '';

        $validator = Validator::make($request->all(), [
            //النوع mimes يتاكد من ان امتداد الصورة يقع من ضمن القائمة المعطية
            'photo' => 'nullable|image|mimes:jpeg,png,gif|max:4096',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

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
        
        $tags=$request->input('tags');
        // return $tags;
        if($tags){
            $data['tags']=implode(',',$tags);
        }
        else{
            $data['tags']='';
        }
        // return $data;

        $status=$post->fill($data)->save();
        if($status){
            request()->session()->flash('success','Post Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::findOrFail($id);
       
        $status=$post->delete();
        
        if($status){
            request()->session()->flash('success','Post successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting post ');
        }
        return redirect()->route('post.index');
    }
}