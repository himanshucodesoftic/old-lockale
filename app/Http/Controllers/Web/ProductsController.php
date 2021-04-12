<?php
namespace App\Http\Controllers\Web;

//validator is builtin class in laravel
use App\Models\Web\Currency;
use App\Models\Web\Index;
//for password encryption or hash protected
use App\Models\Web\Languages;

//for authenitcate login data
use App\Models\Web\Products;
use Auth;

//for requesting a value
use DB;
//for Carbon a value
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lang;
use Session;
//email
use App\Models\Core\Vendors;
use App\Models\Core\Categories;
use App\Models\Web\Images;

class ProductsController extends Controller
{
    public function __construct(
        Index $index,
        Languages $languages,
        Products $products,
        Currency $currency,
        Vendors $vendors,
        Images $images,
        Categories $categorydata
    ) {
        $this->index = $index;
        $this->languages = $languages;
        $this->products = $products;
        $this->currencies = $currency;
        $this->theme = new ThemeController();
        $this->vendors = $vendors;
        $this->categories = $categorydata;
        $this->images = $images;
    }

    public function reviews(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            $check = DB::table('reviews')
                ->where('customers_id', Auth::guard('customer')->user()->id)
                ->where('products_id', $request->products_id)
                ->first();

            if ($check) {
                return 'already_commented';
            }
            $id = DB::table('reviews')->insertGetId([
                'products_id' => $request->products_id,
                'reviews_rating' => $request->rating,
                'customers_id' => Auth::guard('customer')->user()->id,
                'customers_name' => Auth::guard('customer')->user()->first_name,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('reviews_description')
                ->insert([
                    'review_id' => $id,
                    'language_id' => Session::get('language_id'),
                    'reviews_text' => $request->reviews_text,
                ]);
            return 'done';
        } else {
            return 'not_login';

        }
    }

    //shop
    public function shop(Request $request)
    {
        $title = array('pageTitle' => Lang::get('website.Shop'));
        $result = array();

        $result['commonContent'] = $this->index->commonContent();
        $final_theme = $this->theme->theme();
        if (!empty($request->page)) {
            $page_number = $request->page;
        } else {
            $page_number = 0;
        }

        if (!empty($request->limit)) {
            $limit = $request->limit;
        } else {
            $limit = 15;
        }

        if (!empty($request->type)) {
            $type = $request->type;
        } else {
            $type = '';
        }

        //min_max_price
        if (!empty($request->price)) {
            $d = explode(";", $request->price);
            $min_price = $d[0];
            $max_price = $d[1];
        } else {
            $min_price = '';
            $max_price = '';
        }
        $exist_category = '1';
        $categories_status = 1;
        //category
        if (!empty($request->category) and $request->category != 'all') {
            $category = $this->products->getCategories($request);
            
            if(!empty($category) and count($category)>0){
                $categories_id = $category[0]->categories_id;
                //for main
                if ($category[0]->parent_id == 0) {
                    $category_name = $category[0]->categories_name;
                    $sub_category_name = '';
                    $category_slug = '';
                    $categories_status = $category[0]->categories_status;
                } else {
                    //for sub
                    $main_category = $this->products->getMainCategories($category[0]->parent_id);

                    $category_slug = $main_category[0]->categories_slug;
                    $category_name = $main_category[0]->categories_name;
                    $sub_category_name = $category[0]->categories_name;
                    $categories_status = $category[0]->categories_status;
                }
            }else{
                $categories_id = '';
                $category_name = '';
                $sub_category_name = '';
                $category_slug = '';
                $categories_status = 0;
            }
                            

        } else {
            $categories_id = '';
            $category_name = '';
            $sub_category_name = '';
            $category_slug = '';
            $categories_status = 1;
        }

        $result['category_name'] = $category_name;
        $result['category_slug'] = $category_slug;
        $result['sub_category_name'] = $sub_category_name;
        $result['categories_status'] = $categories_status;

        //search value
        if (!empty($request->search)) {
            $search = $request->search;
        } else {
            $search = '';
        }

        $filters = array();
        if (!empty($request->filters_applied) and $request->filters_applied == 1) {
            $index = 0;
            $options = array();
            $option_values = array();

            $option = $this->products->getOptions();

            foreach ($option as $key => $options_data) {
                $option_name = str_replace(' ', '_', $options_data->products_options_name);

                if (!empty($request->$option_name)) {
                    $index2 = 0;
                    $values = array();
                    foreach ($request->$option_name as $value) {
                        $value = $this->products->getOptionsValues($value);
                        $option_values[] = $value[0]->products_options_values_id;
                    }
                    $options[] = $options_data->products_options_id;
                }
            }

            $filters['options_count'] = count($options);

            $filters['options'] = implode(',',$options);
            $filters['option_value'] = implode(',',$option_values);

            $filters['filter_attribute']['options'] = $options;
            $filters['filter_attribute']['option_values'] = $option_values;

            $result['filter_attribute']['options'] = $options;
            $result['filter_attribute']['option_values'] = $option_values;
        }

        $brand = '';

        if(isset($request->brand)){
            $brand = $request->brand;
        }
        $data = array('page_number' => $page_number, 'type' => $type, 'limit' => $limit,
            'categories_id' => $categories_id, 'search' => $search,
            'filters' => $filters, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price,'brand' => $brand);

        $products = $this->products->products($data);        
        $result['products'] = $products;

        $data = array('limit' => $limit, 'categories_id' => $categories_id);
        $filters = $this->filters($data);
        $result['filters'] = $filters;

        $cart = '';
        $result['cartArray'] = $this->products->cartIdArray($cart);

        if ($limit > $result['products']['total_record']) {
            $result['limit'] = $result['products']['total_record'];
        } else {
            $result['limit'] = $limit;
        }

        //liked products
        $result['liked_products'] = $this->products->likedProducts();
        $result['categories'] = $this->products->categories();

        $result['min_price'] = $min_price;
        $result['max_price'] = $max_price;

        return view("web.shop", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);

    }

    public function filterProducts(Request $request)
    {

        //min_price
        if (!empty($request->min_price)) {
            $min_price = $request->min_price;
        } else {
            $min_price = '';
        }

        //max_price
        if (!empty($request->max_price)) {
            $max_price = $request->max_price;
        } else {
            $max_price = '';
        }

        if (!empty($request->limit)) {
            $limit = $request->limit;
        } else {
            $limit = 15;
        }

        if (!empty($request->type)) {
            $type = $request->type;
        } else {
            $type = '';
        }

        //if(!empty($request->category_id)){
        if (!empty($request->category) and $request->category != 'all') {
            $category = DB::table('categories')->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')->where('categories_slug', $request->category)->where('language_id', Session::get('language_id'))->get();

            $categories_id = $category[0]->categories_id;
        } else {
            $categories_id = '';
        }

        //search value
        if (!empty($request->search)) {
            $search = $request->search;
        } else {
            $search = '';
        }

        //min_price
        if (!empty($request->min_price)) {
            $min_price = $request->min_price;
        } else {
            $min_price = '';
        }

        //max_price
        if (!empty($request->max_price)) {
            $max_price = $request->max_price;
        } else {
            $max_price = '';
        }

        if (!empty($request->filters_applied) and $request->filters_applied == 1) {
            $filters['options_count'] = count($request->options_value);
            $filters['options'] = $request->options;
            $filters['option_value'] = $request->options_value;
        } else {
            $filters = array();
        }

        $data = array('page_number' => $request->page_number, 'type' => $type, 'limit' => $limit, 'categories_id' => $categories_id, 'search' => $search, 'filters' => $filters, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
        $products = $this->products->products($data);
        $result['products'] = $products;

        $cart = '';
        $result['cartArray'] = $this->products->cartIdArray($cart);
        $result['limit'] = $limit;
        $result['commonContent'] = $this->index->commonContent();
        return view("web.filterproducts")->with('result', $result);

    }

    public function ModalShow(Request $request)
    {
        $result = array();
        $result['commonContent'] = $this->index->commonContent();
        $final_theme = $this->theme->theme();
        //min_price
        if (!empty($request->min_price)) {
            $min_price = $request->min_price;
        } else {
            $min_price = '';
        }

        //max_price
        if (!empty($request->max_price)) {
            $max_price = $request->max_price;
        } else {
            $max_price = '';
        }

        if (!empty($request->limit)) {
            $limit = $request->limit;
        } else {
            $limit = 15;
        }

        $products = $this->products->getProductsById($request->products_id);

        $products = $this->products->getProductsBySlug($products[0]->products_slug);
        //category
        $category = $this->products->getCategoryByParent($products[0]->products_id);

        if (!empty($category) and count($category) > 0) {
            $category_slug = $category[0]->categories_slug;
            $category_name = $category[0]->categories_name;
        } else {
            $category_slug = '';
            $category_name = '';
        }
        $sub_category = $this->products->getSubCategoryByParent($products[0]->products_id);

        if (!empty($sub_category) and count($sub_category) > 0) {
            $sub_category_name = $sub_category[0]->categories_name;
            $sub_category_slug = $sub_category[0]->categories_slug;
        } else {
            $sub_category_name = '';
            $sub_category_slug = '';
        }

        $result['category_name'] = $category_name;
        $result['category_slug'] = $category_slug;
        $result['sub_category_name'] = $sub_category_name;
        $result['sub_category_slug'] = $sub_category_slug;

        $isFlash = $this->products->getFlashSale($products[0]->products_id);

        if (!empty($isFlash) and count($isFlash) > 0) {
            $type = "flashsale";
        } else {
            $type = "";
        }

        $data = array('page_number' => '0', 'type' => $type, 'products_id' => $products[0]->products_id, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
        $detail = $this->products->products($data);
        $result['detail'] = $detail;
        $postCategoryId = '';
        if (!empty($result['detail']['product_data'][0]->categories) and count($result['detail']['product_data'][0]->categories) > 0) {
            $i = 0;
            foreach ($result['detail']['product_data'][0]->categories as $postCategory) {
                if ($i == 0) {
                    $postCategoryId = $postCategory->categories_id;
                    $i++;
                }
            }
        }

        $data = array('page_number' => '0', 'type' => '', 'categories_id' => $postCategoryId, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
        $simliar_products = $this->products->products($data);
        $result['simliar_products'] = $simliar_products;

        $cart = '';
        $result['cartArray'] = $this->products->cartIdArray($cart);

        //liked products
        $result['liked_products'] = $this->products->likedProducts();
        return view("web.common.modal1")->with('result', $result);
    }

    //access object for custom pagination
    public function accessObjectArray($var)
    {
        return $var;
    }

     //productDetail
     public function productDetail(Request $request)
     {
 
         $title = array('pageTitle' => Lang::get('website.Product Detail'));
         $result = array();
         $result['commonContent'] = $this->index->commonContent();
         $final_theme = $this->theme->theme();
         //min_price
         if (!empty($request->min_price)) {
             $min_price = $request->min_price;
         } else {
             $min_price = '';
         }
 
         //max_price
         if (!empty($request->max_price)) {
             $max_price = $request->max_price;
         } else {
             $max_price = '';
         }
 
         if (!empty($request->limit)) {
             $limit = $request->limit;
         } else {
             $limit = 15;
         }
 
         $products = $this->products->getProductsBySlug($request->slug);
         if(!empty($products) and count($products)>0){
             
             //category
             $category = $this->products->getCategoryByParent($products[0]->products_id);
 
             if (!empty($category) and count($category) > 0) {
                 $category_slug = $category[0]->categories_slug;
                 $category_name = $category[0]->categories_name;
             } else {
                 $category_slug = '';
                 $category_name = '';
             }
             $sub_category = $this->products->getSubCategoryByParent($products[0]->products_id);
 
             if (!empty($sub_category) and count($sub_category) > 0) {
                 $sub_category_name = $sub_category[0]->categories_name;
                 $sub_category_slug = $sub_category[0]->categories_slug;
             } else {
                 $sub_category_name = '';
                 $sub_category_slug = '';
             }
 
             $result['category_name'] = $category_name;
             $result['category_slug'] = $category_slug;
             $result['sub_category_name'] = $sub_category_name;
             $result['sub_category_slug'] = $sub_category_slug;
 
             $isFlash = $this->products->getFlashSale($products[0]->products_id);
 
             if (!empty($isFlash) and count($isFlash) > 0) {
                 $type = "flashsale";
             } else {
                 $type = "";
             }
             $postCategoryId = '';
             $data = array('page_number' => '0', 'type' => $type, 'products_id' => $products[0]->products_id, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
             $detail = $this->products->products($data);
             $result['detail'] = $detail;
             if (!empty($result['detail']['product_data'][0]->categories) and count($result['detail']['product_data'][0]->categories) > 0) {
                 $i = 0;
                 foreach ($result['detail']['product_data'][0]->categories as $postCategory) {
                     if ($i == 0) {
                         $postCategoryId = $postCategory->categories_id;
                         $i++;
                     }
                 }
             }
 
             $data = array('page_number' => '0', 'type' => '', 'categories_id' => $postCategoryId, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
             $simliar_products = $this->products->products($data);
             $result['simliar_products'] = $simliar_products;
 
             $cart = '';
             $result['cartArray'] = $this->products->cartIdArray($cart);
 
             //liked products
             $result['liked_products'] = $this->products->likedProducts();
 
             $data = array('page_number' => '0', 'type' => 'topseller', 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
             $top_seller = $this->products->products($data);
             $result['top_seller'] = $top_seller;
         }else{
             $products = '';
             $result['detail']['product_data'] = '';
         }
         
         $currency_symbol = session('symbol_left') ? session('symbol_left') : session('symbol_right') ;
         $currency  = DB::table('currencies')->where('symbol_left',$currency_symbol)->orwhere('symbol_right',$currency_symbol)->first();
         $result['currency_value'] = $currency ? $currency->value : 1;
        //  dd($result['currency_value']);
         return view("web.detail", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
     }

    //filters
    public function filters($data)
    {
        $response = $this->products->filters($data);
        return ($response);
    }

    //getquantity
    public function getquantity(Request $request)
    {
        $data = array();
        $data['products_id'] = $request->products_id;
        $data['attributes'] = $request->attributeid;

        $result = $this->products->productQuantity($data);
        print_r(json_encode($result));
    }


    /// add new product
    public function addProduct()
    {
        $title = array('pageTitle' => Lang::get("labels.AddProduct"));
        $allimage = $this->images->getimages();
        $result = array();

        $categories = $this->categories->recursivecategories();        

        $result['categories'] = $categories;

        $final_theme = $this->theme->theme();        

        $result['commonContent'] = $this->index->commonContent();
        
        $languages = DB:: table('languages')->where('status',1)->orderBy('languages_id')->get();
        $result['languages'] = $languages;

        if (empty(session('step_car'))) {
            session(['step_car' => 0]);
        }
        
        return view("web.products.addproducts", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result)->with('allimage', $allimage);
    }

    public function saveinfo(Request $request)
    {
        $title = array('pageTitle' => Lang::get('website.AddProduct'));
        $result = array();
        $result['commonContent'] = $this->index->commonContent();

        if (session('step_car') == 0) {
            session(['step_car' => 1]);
        }

        foreach ($request->all() as $key => $value) {
            $car_info[$key] = $value;
        }        

        $car_detail = (object) $car_info;
        session(['car_info' => $car_detail]);

        $images = array();
        if (empty(session('images'))) {
            session(['images' => $images]);
        }
        
        // $customers_id = auth()->guard('customer')->user()->id;
        // $email = auth()->guard('customer')->user()->email;

        return redirect()->back();
    }

    public function savepics(Request $request)
    {
        if (session('step_car') == 1) {
            session(['step_car' => 2]);
        }

        $categories = $this->categories->recursivecategories();

        foreach ($categories as $key => $cate) {
            if ($cate->categories_id == session('car_info')->category_id) {
                session(['category_name' => $cate->categories_name]);
            }
        }

        if (empty(session('images'))) {
            $car_images = [];
        } else {
            $car_images = session('images');
        }
        
        session(['images' => $car_images]);

        return redirect()->back();
    }

    public function postProduct(Request $request)
    {
        $customers_id = auth()->guard('customer')->user()->id;
        $email = auth()->guard('customer')->user()->email;
        $phone = auth()->guard('customer')->user()->phone;
        $request['customers_id'] = $customers_id;
        $request['email'] = $email;
        $request['phone'] = $phone;
        $request['images'] = session('images');
        $products_id = $this->products->postProduct($request->all());

        session(['images' => []]);
        session(['category_name' => '']);
        session(['step_car' => 0]);
        session(['car_info' => '']);

        return redirect('/');
    }

    public function getMyProduct(Request $request) {
        $title = array('pageTitle' => Lang::get("labels.AddProduct"));
        $results = array();
        $final_theme = $this->theme->theme();
        $results['commonContent'] = $this->index->commonContent();
        
        $products = $this->products->getmyproduct($request);
        $results['products'] = $products;
        
        return view("web.products.myproducts", ['title' => $title, 'final_theme' => $final_theme])->with('result', $results);
    }

    public function editProduct(Request $request) {
        $title = array('pageTitle' => Lang::get('website.EditProduct'));
        $result = array();
        $result['commonContent'] = $this->index->commonContent();
        $final_theme = $this->theme->theme();

        $categories = $this->categories->recursivecategories();
        $result['categories'] = $categories;

        $products = $this->products->getProductsById($request->id);

        if(!empty($products) and count($products)>0) {
            
            //category
            $category = $this->products->getCategoryByParent($products[0]->products_id); 
            if (!empty($category) and count($category) > 0) {
                $category_slug = $category[0]->categories_slug;
                $category_name = $category[0]->categories_name;
                $category_id = $category[0]->categories_id;
            } else {
                $category_slug = '';
                $category_name = '';
                $category_id = '';
            }

            $sub_category = $this->products->getSubCategoryByParent($products[0]->products_id); 
            if (!empty($sub_category) and count($sub_category) > 0) {
                $sub_category_name = $sub_category[0]->categories_name;
                $sub_category_slug = $sub_category[0]->categories_slug;
                $sub_category_id = $sub_category[0]->categories_id;
            } else {
                $sub_category_name = '';
                $sub_category_slug = '';
                $sub_category_id = '';
            }

            $result['category_name'] = $category_name;
            $result['category_id'] = $category_id;
            $result['category_slug'] = $category_slug;
            $result['sub_category_name'] = $sub_category_name;
            $result['sub_category_id'] = $sub_category_id;
            $result['sub_category_slug'] = $sub_category_slug;

            $products_detail = DB::table('products')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')            
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')
                    ->where(function ($query) {
                        $query->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
            })
            ->LeftJoin('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')
            ->where('products.products_id', $products[0]->products_id)->get();

            $product_flash = DB::table('flash_sale')->where('products_id', $products[0]->products_id)->where('flash_status', 1)->get();

            $product_images = DB::table('products_images')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products_images.image')
                    ->where(function ($query) {
                        $query->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
            })->select('products_images.image','products_images.products_id','image_categories.path as image_path')
            ->where('products_images.products_id', $products[0]->products_id)->get();

            $product_special = DB::table('specials')->where('products_id', $products[0]->products_id)->where('status', 1)->get();
            
            $result['products_detail'] = $products_detail;
            $result['product_flash'] = $product_flash;
            $result['product_images'] = $product_images;
            $result['product_special'] = $product_special;
        }else{
            $products = '';
            $result['detail']['product_data'] = '';
        }
        
        $currency_symbol = session('symbol_left') ? session('symbol_left') : session('symbol_right') ;
        $currency  = DB::table('currencies')->where('symbol_left',$currency_symbol)->orwhere('symbol_right',$currency_symbol)->first();
        $result['currency_value'] = $currency ? $currency->value : 1;
    //  dd($result['currency_value']);
        return view("web.products.detail", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
    }

    public function updateProduct(Request $request) {
        if (empty(session('images'))) {
            $car_images = [];
        } else {
            $car_images = session('images');
        }

        $products_detail = DB::table('products')->where('products_id',$request->products_id)->update([
            'updated_by_vendor' => 1,
            'updated_quantity' => $request->products_quantity,
            'updated_images' => $car_images,
            'update_request_status' => 2,
            'updated_at' => date('Y-m-d h:i:s')
        ]);
        
        session(['images' => []]);

        return redirect('/getmyproduct')->with('message', 'Sent request of updating to admin.');
    }

    public function deleteProduct(Request $request) {
        
    }

}
