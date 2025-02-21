<?php

namespace App\Http\Controllers;
use DB;
use Hash;
use Session;
use App\User;
use Newsletter;
use App\Models\Cart;
use App\Models\Post;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Banner;
use App\Models\PostTag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Validation\Rule;
use App\Models\StoreInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class FrontendController extends Controller
{
    use HttpResponses;

    ////test admin found from website
    
    // public function testAdminFound(Request $request){
    //     // $token = $request->query('token');
    //     $token = session()->get('admin_now');
    //     $admin = auth()->guard('admin')->user();
    //     // $admin = Auth::guard('admin')->setToken($token)->user();
    //     return response()->json([
    //         'admin' => $admin,
    //         'token'=>$token
    //     ]);

    // }
    public function index(Request $request)
    {
        return redirect()->route($request->user()->role);
    }

    public function previous(){
        return redirect()->back();
    }


    public function storeColor(Request $request)
    {
        // dd($request->only(['token', 'color']));
        // dd(Auth::user()->id);
        $request->validate([
            'color' => 'required',
        ]);
        Color::create([
            'color' => $request->color,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json([
            'msg' => 'تم تخزين اللون بنجاح',
        ]);
    }

    public function fetchColor()
    {
        $arr = [];
        $user = User::find(Auth::user()->id);
        $colors = $user->colors;
        foreach ($colors as $color) {
            array_push($arr, $color->color);
        }
        $c = $arr[0];
        // $cc = Str::snake(dechex(hexdec($c)), '');
        return $arr;
    }

    public function home(Request $request)
    {
        $featured = Product::where('status', 'active')
            ->where('is_featured', 1)
            ->orderBy('price', 'DESC')
            ->limit(2)
            ->get();
        $posts = Post::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $banners = Banner::where('status', 'active')
            ->limit(3)
            ->orderBy('id', 'DESC')
            ->get();
        // return $banner;
        $products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(8)
            ->get();
        $category = Category::where('status', 'active')
            ->where('is_parent', 1)
            ->orderBy('title', 'ASC')
            ->get();

        if ($request->isJson() || $request->wantsJson()) {
            return response()->json([
                'featured' => $featured,
                'posts' => $posts,
                'banners' => $banners,
                'products' => $products,
                'category' => $category,
            ]);
        }

        return view('frontend.index')
            ->with('featured', $featured)
            ->with('posts', $posts)
            ->with('banners', $banners)
            ->with('product_lists', $products)
            ->with('category_lists', $category);
    }

    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function productDetail($slug)
    {
        $product_detail = Product::getProductBySlug($slug);
        // dd($product_detail);
        return view('frontend.pages.product_detail')->with(
            'product_detail',
            $product_detail
        );
    }

    public function productGrids()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')
                ->whereIn('slug', $slug)
                ->pluck('id')
                ->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids);
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')
                ->whereIn('slug', $slugs)
                ->pluck('id')
                ->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products
                    ->where('status', 'active')
                    ->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products
                ->where('status', 'active')
                ->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(9);
        }
        // Sort by name , price, category

        // return view('frontend.pages.product-grids')
        //     ->with('products', $products)
        //     ->with('recent_products', $recent_products);

        /////i'm adding

        // $admin_id = auth()->guard('trader')->id();
        // $storeInfo = StoreInformation::where('admin_id',$admin_id)->first();
        // $nameStore = $storeInfo['name'];

        // return redirect()->route('store/',$nameStore);
        
        $user = auth()->user();
        $admin = Admin::where('id',$user->admin_id)->first();

        $storeInfo = StoreInformation::where('admin_id',$admin->id)->first();
        $nameStore = $storeInfo['name'];

        return redirect()->route('store/',$nameStore);
        
    }
    public function productLists()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')
                ->whereIn('slug', $slug)
                ->pluck('id')
                ->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids)->paginate;
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')
                ->whereIn('slug', $slugs)
                ->pluck('id')
                ->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products
                    ->where('status', 'active')
                    ->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products
                ->where('status', 'active')
                ->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(6);
        }
        // Sort by name , price, category

        return view('frontend.pages.product-lists')
            ->with('products', $products)
            ->with('recent_products', $recent_products);
    }
    public function productFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $showURL = '';
        if (!empty($data['show'])) {
            $showURL .= '&show=' . $data['show'];
        }

        $sortByURL = '';
        if (!empty($data['sortBy'])) {
            $sortByURL .= '&sortBy=' . $data['sortBy'];
        }

        $catURL = '';
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $brandURL = '';
        if (!empty($data['brand'])) {
            foreach ($data['brand'] as $brand) {
                if (empty($brandURL)) {
                    $brandURL .= '&brand=' . $brand;
                } else {
                    $brandURL .= ',' . $brand;
                }
            }
        }
        // return $brandURL;

        $priceRangeURL = '';
        if (!empty($data['price_range'])) {
            $priceRangeURL .= '&price=' . $data['price_range'];
        }
        if (request()->is('e-shop.loc/product-grids')) {
            return redirect()->route(
                'product-grids',
                $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL
            );
        } else {
            return redirect()->route(
                'product-lists',
                $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL
            );
        }
    }
    public function productSearch(Request $request)
    {
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $products = Product::orwhere(
            'title',
            'like',
            '%' . $request->search . '%'
        )
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('price', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate('9');
        return view('frontend.pages.product-grids')
            ->with('products', $products)
            ->with('recent_products', $recent_products);
    }

    public function productBrand(Request $request)
    {
        $products = Brand::getProductByBrand($request->slug);
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')
                ->with('products', $products->products)
                ->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')
                ->with('products', $products->products)
                ->with('recent_products', $recent_products);
        }
    }
    public function productCat(Request $request)
    {
        $products = Category::getProductByCat($request->slug);
        // return $request->slug;
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')
                ->with('products', $products->products)
                ->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')
                ->with('products', $products->products)
                ->with('recent_products', $recent_products);
        }
    }
    public function productSubCat(Request $request)
    {
        $products = Category::getProductBySubCat($request->sub_slug);
        // return $products;
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')
                ->with('products', $products->sub_products)
                ->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')
                ->with('products', $products->sub_products)
                ->with('recent_products', $recent_products);
        }
    }

    public function blog()
    {
        $post = Post::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = PostCategory::select('id')
                ->whereIn('slug', $slug)
                ->pluck('id')
                ->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id', $cat_ids);
            // return $post;
        }
        if (!empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            // dd($slug);
            $tag_ids = PostTag::select('id')
                ->whereIn('slug', $slug)
                ->pluck('id')
                ->toArray();
            // return $tag_ids;
            $post->where('post_tag_id', $tag_ids);
            // return $post;
        }

        if (!empty($_GET['show'])) {
            $post = $post
                ->where('status', 'active')
                ->orderBy('id', 'DESC')
                ->paginate($_GET['show']);
        } else {
            $post = $post
                ->where('status', 'active')
                ->orderBy('id', 'DESC')
                ->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post = Post::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        return view('frontend.pages.blog')
            ->with('posts', $post)
            ->with('recent_posts', $rcnt_post);
    }

    public function blogDetail($slug)
    {
        $post = Post::getPostBySlug($slug);
        $rcnt_post = Post::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        // return $post;
        return view('frontend.pages.blog-detail')
            ->with('post', $post)
            ->with('recent_posts', $rcnt_post);
    }

    public function blogSearch(Request $request)
    {
        // return $request->all();
        $rcnt_post = Post::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $posts = Post::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('quote', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(8);
        return view('frontend.pages.blog')
            ->with('posts', $posts)
            ->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = '';
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $tagURL = '';
        if (!empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag=' . $tag;
                } else {
                    $tagURL .= ',' . $tag;
                }
            }
        }
        // return $tagURL;
        // return $catURL;
        return redirect()->route('blog', $catURL . $tagURL);
    }

    public function blogByCategory(Request $request)
    {
        $post = PostCategory::getBlogByCategory($request->slug);
        $rcnt_post = Post::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        return view('frontend.pages.blog')
            ->with('posts', $post->post)
            ->with('recent_posts', $rcnt_post);
    }

    public function blogByTag(Request $request)
    {
        // dd($request->slug);
        $post = Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post = Post::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        return view('frontend.pages.blog')
            ->with('posts', $post)
            ->with('recent_posts', $rcnt_post);
    }

    // Login
    public function login(Request $request)
    {
        $nameStore = $request->nameStore;
        
        $admin_id = auth()->guard('trader')->id();
        // dd($admin_id);

        if(!$nameStore){
            $store_info_by_admin_id = StoreInformation::where('admin_id',$admin_id)->first();
            $nameStore = $store_info_by_admin_id['name'];
            $store_info = StoreInformation::where('name',$nameStore)->first();
        } else {
            $storeInfo = StoreInformation::where('name',$nameStore)->first();
            $admin_id = $storeInfo['admin_id'];
        }

        
        $admin_id = $store_info['admin_id'] ?? $admin_id;
        if (Auth::guest()) {
            return view('frontend.pages.login',compact('nameStore','admin_id'));
        } else {
            // return redirect()->route('home');
            $user = auth()->user();
            $admin = Admin::where('id',$user->admin_id)->first();
            
            // $users=Admin::where('role','admin')->where('id',$user->admin_id)->first();
            $storeInfo = StoreInformation::where('admin_id',$admin->id)->first();
            $nameStore = $storeInfo['name'];

            return redirect()->route('store/',$nameStore);
        }
    }
    public function loginSubmit(Request $request)
    {
        //api for this => http://127.0.0.1:8000/api/user/login
        $admin_id = $request->input('admin_id');
        $data = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        
        
        // كود التسجيل القديم
        try {
            $user = User::where('admin_id',$admin_id)->where('email',$data['email'])->first();
            // dd($user);
            
            
            // $credentials = [
                //     'email' =>  $data['email'],
                //     'password' =>  $data['password'],
                //     'admin_id' => $admin_id,
                //     // fn (Builder $query) => $query->from('users')->where('admin_id', $admin_id),
                // ];
                
                if($user){
                    //فحص ما اذا المستخدم نشط ام لا
                    if($user->status === 'inactive'){
                        
                        return back()->withErrors(['email'=>'تم توقيف هذا الايميل لاسباب امنية'])->withInput();
                    }
                $data['id'] = $user->id;
                if (Auth::attempt([
                    'id' =>  $data['id'],
                    'password' =>  $data['password'],
                ]))
                {
                    Session::put('user', $data['email']);
                    // dd(Auth::user());
                    if ($request->isJson() || $request->wantsJson()) {
                        return $this->sucess([
                            'user' => $user,
                            'token' => $user->createToken(
                                'Api Token of' . $user->name
                            )->plainTextToken,
                        ]);
                    } else {
                        request()
                            ->session()
                            ->flash('success', 'Successfully login');
                        
                        if($request->nameStore){
                            return redirect()->route('store/',$request->nameStore);
                        } else{
                            return redirect()->route('home');
                        }
                        
                    }
                } else {
                    if ($request->isJson() || $request->wantsJson()) {
                        return response()->json(
                            [
                                'success' => false,
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
            }else{
                request()
                        ->session()
                        ->flash(
                            'error',
                            'لا يوجد مستخدم بهذا الايميل الرجاء انشاء حساب'
                        );
                    return redirect()->back();
            }

        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'messagge' => 'حدث خطا'.$e,
                ],
                422
            );
        }


        // كود التسجيل الجديد
            // if(!empty($user)){
            //     if (\Hash::check($data['password'], $user->password)) {
            //         // تسجيل الدخول ناجح
            //         Auth::login($user);
            //         //  تجديد الجلسة
            //         $request->session()->regenerate();
            //         Session::put('user', $data['email']);
            //         // dd(Auth::user());
    
            //         if ($request->isJson() || $request->wantsJson()) {
            //             return $this->sucess([
            //                 'user' => $user,
            //                 'token' => $user->createToken(
            //                     'Api Token of' . $user->name
            //                 )->plainTextToken,
            //             ]);
            //         } else {
            //             request()
            //                 ->session()
            //                 ->flash('success', 'Successfully login');
                        
            //             if($request->nameStore){
            //                 return redirect()->route('store/',$request->nameStore);
            //             } else{
            //                 return redirect()->route('home');
            //             }
                        
            //         }
            //     } else {
            //         if ($request->isJson() || $request->wantsJson()) {
            //             return response()->json(
            //                 [
            //                     'success' => true,
            //                     'messagge' => 'فشل تسجيل الدخول',
            //                 ],
            //                 422
            //             );
            //         } else {
            //             request()
            //                 ->session()
            //                 ->flash(
            //                     'error',
            //                     'Invalid email and password pleas try again!'
            //                 );
            //             return redirect()->back();
            //         }
            //     }
            // }else{
            //     request()
            //             ->session()
            //             ->flash(
            //                 'error',
            //                 'Invalid email and password pleas try again!'
            //             );
            //         return redirect()->back();
            // }
    }


    public function show()
    {
        $users = User::all();
        return response()->json([
            'user' => $users,
        ]);
    }

    public function logout(Request $request)
    {
        //api for this => http://127.0.0.1:8000/api/user/logout

        //test the code
        // Auth::user()->currentAccessToken()->delete();

        //method one
        Session::forget('user');
        Auth::logout();

        //method tow
        // Auth::logout();
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
                if($request->nameStore){
                    return redirect()->route('login.form', ['nameStore'=>$request->nameStore]);
                }
            return redirect()->route('login.form');
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
    

    public function register(Request $request)
    {
        $nameStore = $request->nameStore;
        $store_info = StoreInformation::where('name',$nameStore)->first();
        $admin_id = $store_info['admin_id'];
        if (Auth::guest()) {
            return view('frontend.pages.register',compact('nameStore','admin_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function registerSubmit(Request $request)
    {
        //كود انشاء حساب
        //API for this => http://127.0.0.1:8000/api/user/register
        // return $request->all();
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('admin_id', $request->admin_id);
                }),
            ],
            // 'admin_id' => 'required|exists:admins,id',
            'password' => 'required|min:6|confirmed', //هذا الشرط confirmed يعني انه يجب ان تضع حقل باسم password_confirmation
        ]);


        $data = $request->all();

        // $nameStore = StoreInformation::where('name',$request->nameStore)->first();
        
        $data['admin_id']= $request->admin_id;

        // return response()->json([
        //     'data'=>$data
        // ]);

        // dd($data);

        //فحص ما اذا كان المستخدم سجل من المنصة باستخدام api
        //او انه سجل من متجر التاجر
        // if ($request->isJson() || $request->wantsJson()) {
        //     $data['role'] = 'store';
        // } else {
        //     $data['role'] = 'user';
        // }

        /////
        $check = $this->create($data);
        auth()->login($check);
        // $admin_id = auth()->guard('admin')->user();
        // $user = auth()->user();
        Session::put('user', $data['email']);
        // return response()->json([
        //     'admin'=>'admin '.$admin_id ,
        //     'user'=>'user '.$user 
        // ]);
        if ($check) {
            if ($request->isJson() || $request->wantsJson()) {
                $token = $check->createToken('api Token of ' . $check->name)
                    ->plainTextToken;

                return response()->json([
                    'user' => $check,
                    'token' => $token,
                ]);
            } else {
                request()
                    ->session()
                    ->flash('success', 'Successfully registered');
                // return redirect()->route('home');
                return redirect()->route('store/',$request->nameStore);
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
        // $admin_id = auth()->guard('admin')->id();
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
            'admin_id' => $data['admin_id'],
        ]);
    }
    // Reset password
    public function showResetForm()
    {
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request)
    {
        if (!Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribePending($request->email);
            if (Newsletter::lastActionSucceeded()) {
                request()
                    ->session()
                    ->flash('success', 'Subscribed! Please check your email');
                return redirect()->route('home');
            } else {
                Newsletter::getLastError();
                return back()->with(
                    'error',
                    'Something went wrong! please try again'
                );
            }
        } else {
            request()
                ->session()
                ->flash('error', 'Already Subscribed');
            return back();
        }
    }
}