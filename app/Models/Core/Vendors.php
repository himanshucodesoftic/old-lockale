<?php

namespace App\Models\Core;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Core\User;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\AdminControllers\AlertController;

class Vendors extends Model
{
    //
    use Sortable;
    protected $table = 'vendors';
    public function address_book(){
        return $this->belongsTo('App\address_book');
    }

    public function customer_info(){
        return $this->belongsTo('App\Customer_info');
    }

    public function countryrelation(){
        return $this->belongsTo('App\Country');
    }

    public function zone(){
        return $this->belongsTo('App\Zone');
    }

    public function images(){
        return $this->belongsTo('App\Images');
    }

    public function requests() {
        $requests = DB::table('vendor_requests')
        ->LeftJoin('countries', 'countries.countries_id' ,'=', 'vendor_requests.country_id')
        ->select('vendor_requests.*', 'countries.countries_name')
        // ->where('vendor_requests.status','<>', 0)
        ->orderBy('vendor_requests.status', 'DESC')
        ->orderBy('vendor_requests.id', 'DESC')
        ->get();

        return $requests;
    }

    public function accept($id){
        $vendors = DB::table('vendor_requests')
        ->LeftJoin('countries', 'countries.countries_id' ,'=', 'vendor_requests.country_id')
        ->where('vendor_requests.id','=', $id)
        ->select('vendor_requests.*', 'countries.countries_name')->first();

        return $vendors;
    }

    public function acceptRequest($request) {
      $vendor_type =  DB::table('user_types')->where('user_types_name', 'Vendors')->first();

      if (!empty($vendor_type)) {
        $vendor_role_id = $vendor_type->user_types_id;
      } else {
        return false;
        exit();
      }

      if (isset($request->image_id) && !empty($request->image_id)) {
        $image_id = $request->image_id;
      } else {
        $image_id = '';
      }

      $vendor_id = DB::table('users')->insertGetId([
        'role_id' => $vendor_role_id,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,        
        'phone' => $request->vendor_phone,
        'country_code' => $request->country_id,
        'password' => Hash::make($request->password),
        'status' => $request->isActive,
        'avatar' => $image_id,
        'created_at' => date('Y-m-d H:i:s')
      ]);
      
      $customers_id = DB::table('vendors')->insertGetId([
          'vendor_id' => $vendor_id,
          'role_id' => $vendor_role_id,
          'vendor_name' => $request->vendor_name,
          'vendor_name_arabic' => $request->vendor_name_arabic,
          'email' => $request->email,            
          'address' => $request->vendor_address,
          'isopened' => $request->vendor_open,
          'phone' => $request->vendor_phone,
          'status' => $request->isActive,
          'image' => $image_id,
          'created_date' => date('Y-m-d H:i:s')
      ]);

      $exist = DB::table('user_to_address')->where('user_id','=', $customers_id)->first();

     if($exist){
       $address_book_id = $exist->address_book_id;
       DB::table('address_book')->where('address_book_id','=', $address_book_id)->update([
         'entry_firstname'	      =>	$request->first_name,
         'entry_lastname'		      =>	$request->last_name,
         'entry_street_address'		=>	$request->home_address,
         'entry_city'			        =>	$request->city,         
         'entry_postcode'		     	=>	$request->zipcode,
         'entry_country_id'		    =>	$request->country_id,
       ]);

     }else{
      $address_book_id = DB::table('address_book')->insertGetId([
         'user_id'		            =>	$customers_id,
         'entry_firstname'	      =>	$request->first_name,
         'entry_lastname'		      =>	$request->last_name,
         'entry_street_address'		=>	$request->home_address,
         'entry_city'			        =>	$request->city,         
         'entry_postcode'		     	=>	$request->zipcode,
         'entry_country_id'		    =>	$request->country_id,
       ]);

       if($address_book_id){
         $user_to_address =  DB::table('user_to_address')->insertGetId([
            'user_id'		            =>	$customers_id,
            'address_book_id'	      =>	$address_book_id,
            'is_default'    =>  1
          ]);
       }
     }

      $customers_id = DB::table('vendor_requests')->where('id', $request->request_id)->update([
          'status' => 1
      ]);

      $statusData['status'] = 1;
      $statusData['request_email'] = $request->email;
      $statusData['vendor_title'] = $request->vendor_name;
      $statusData['message'] = Lang::get("labels.requestAccepted");
      $statusData['password'] = 'Password: ' .$request->password;
      // $statusData['url'] = 'Url: /public/admin/login';

      $notification = new AlertController();
      $send = $notification->vendorRequestStatus($statusData);

      return true;
    }

    public function decline($request_id) {
        $vendor_request_data = DB::table('vendor_requests')->where('id','=', $request_id)->first();
        DB::table('vendor_requests')->where('id','=', $request_id)->delete();
        
        // DB::table('vendor_requests')->where('id','=', $request_id)->update([
        //   'status' => 0
        // ]);

        $statusData['status'] = 0;
        $statusData['request_email'] = $vendor_request_data->email;
        $statusData['vendor_title'] = $vendor_request_data->title;
        $statusData['message'] = Lang::get("labels.requestRejected");
        $statusData['password'] = '';
        // $statusData['url'] = '';

        $notification = new AlertController();
        $send = $notification->vendorRequestStatus($statusData);
    }



    public function paginator(){
      $vendors = DB::table('vendors')
      ->LeftJoin('image_categories', function ($join) {
        $join->on('image_categories.image_id', '=', 'vendors.image')
            ->where(function ($query) {
              $query->where('image_categories.image_type', '=', 'THUMBNAIL');
      });
      })
      ->leftJoin('users','users.id','=','vendors.vendor_id')
      ->select('vendors.*', 'image_categories.path as image_path','users.first_name','users.last_name')->orderBy('vendors.id', 'asc')->get();

      return $vendors;
    }

    public function email($request){
        $existEmail = DB::table('users')->where('email', '=', $request->email)->get();
        return $existEmail;
    }

    public function insert($request){
      $vendor_type =  DB::table('user_types')->where('user_types_name', 'Vendors')->first();

      if (!empty($vendor_type)) {
        $vendor_role_id = $vendor_type->user_types_id;
      } else {
        return false;
        exit();
      }

      $vendor_id = DB::table('users')->insertGetId([
        'role_id' => $vendor_role_id,
        'user_name' => '',
        'first_name' => $request->vendor_name,
        'last_name' => '',
        'email' => $request->email,        
        'phone' => $request->vendor_phone,
        'password' => Hash::make($request->password),
        'status' => $request->isActive,
        'avatar' => $request->image_id,
        'created_at' => date('Y-m-d H:i:s')
    ]);
      
      $customers_id = DB::table('vendors')->insertGetId([
          'vendor_id' => $vendor_id,
          'role_id' => $vendor_role_id,
          'vendor_name' => $request->vendor_name,
          'vendor_name_arabic' => $request->vendor_name_arabic,
          'email' => $request->email,            
          'address' => $request->vendor_address,
          'isopened' => $request->vendor_open,
          'phone' => $request->vendor_phone,
          'status' => $request->isActive,
          'image' => $request->image_id,
          'created_date' => date('Y-m-d H:i:s')
      ]);      

      return true;
    }

    public function  country(){
        $countries = DB::table('countries')->get();
        return $countries;
    }

    public function countries(){
        $countries = DB::table('countries')->get();
        return $countries;
    }

    public function edit($id){
      $vendors = DB::table('vendors')
        ->LeftJoin('image_categories', function ($join) {
          $join->on('image_categories.image_id', '=', 'vendors.image')
            ->where(function ($query) {
              $query->where('image_categories.image_type', '=', 'THUMBNAIL');
          });
        })
        ->leftJoin('users','users.id','=','vendors.vendor_id')
        ->where('vendors.vendor_id','=', $id)
        ->select('vendors.*', 'image_categories.path as image_path','users.first_name','users.last_name')->first();

      return $vendors;
    }

    public function updaterecord($user_id, $user_data_users, $user_data_vendors){
      DB::table('users')->where('id', '=', $user_id)->update($user_data_users);
      DB::table('vendors')->where('vendor_id', '=', $user_id)->update($user_data_vendors);
    }

    public function extendemail($request){
      $existEmail = DB::table('users')->where('email', '=', $request->email)->get();
      return $existEmail;
    }

    public function destroyrecord($user_id){
        $vendor_email = DB::table('vendors')->where('vendor_id','=', $user_id)->first()->email;        
        DB::table('users')->where('id','=', $user_id)->delete();
        DB::table('vendors')->where('vendor_id','=', $user_id)->delete();
        DB::table('vendor_requests')->where('email','=', $vendor_email)->delete();
    }

    public function filter($request){

        $filter = $request->FilterBy;
        $parameter = $request->parameter;
        switch ( $filter )
        {
            case 'Name':
                $user = DB::table('users')
                    ->LeftJoin('user_to_address', 'user_to_address.user_id' ,'=', 'users.id')
                    ->LeftJoin('address_book','address_book.address_book_id','=', 'user_to_address.address_book_id')
                    ->LeftJoin('countries','countries.countries_id','=', 'address_book.entry_country_id')
                    ->LeftJoin('zones','zones.zone_id','=', 'address_book.entry_zone_id')
                    ->leftJoin('images','images.id', '=', 'users.avatar')
                    ->leftJoin('image_categories','image_categories.image_id', '=', 'users.avatar')
                    ->select('users.*', 'address_book.entry_gender as entry_gender', 'address_book.entry_company as entry_company',
                    'address_book.entry_firstname as entry_firstname', 'address_book.entry_lastname as entry_lastname',
                    'address_book.entry_street_address as entry_street_address', 'address_book.entry_suburb as entry_suburb',
                    'address_book.entry_postcode as entry_postcode', 'address_book.entry_city as entry_city',
                    'address_book.entry_state as entry_state', 'countries.*', 'zones.*','image_categories.path as path')
                    ->where(function($query) {
                        $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                            ->where('image_categories.image_type','!=',   'THUMBNAIL')
                            ->orWhere('image_categories.image_type','=',   'ACTUAL');
                    })
                    ->where('first_name', 'LIKE', '%' .  $parameter . '%')
                    ->orwhere('last_name', 'LIKE', '%' .  $parameter . '%')
                    ->orWhereRaw("concat(first_name, ' ', last_name) like '%$parameter%' ")
                    ->where('users.role_id','=','2')
                    ->orderBy('users.id','ASC')
                    ->groupby('users.id')
                    ->paginate(10);

            break;
            case 'E-mail':
            $user = DB::table('users')
                ->LeftJoin('user_to_address', 'user_to_address.user_id' ,'=', 'users.id')
                ->LeftJoin('address_book','address_book.address_book_id','=', 'user_to_address.address_book_id')
                ->LeftJoin('countries','countries.countries_id','=', 'address_book.entry_country_id')
                ->LeftJoin('zones','zones.zone_id','=', 'address_book.entry_zone_id')
                ->leftJoin('images','images.id', '=', 'users.avatar')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'users.avatar')
                ->select('users.*', 'address_book.entry_gender as entry_gender', 'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname', 'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address', 'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode', 'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state', 'countries.*', 'zones.*','image_categories.path as path')
                ->where(function($query) {
                    $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                        ->where('image_categories.image_type','!=',   'THUMBNAIL')
                        ->orWhere('image_categories.image_type','=',   'ACTUAL');
                })
                ->where('email', 'LIKE', '%' .  $parameter . '%')
                ->where('users.role_id','=','2')
                ->orderBy('users.id','ASC')
                ->groupby('users.id')
                ->paginate(10);
            break;

            case 'Phone':
            $user = DB::table('users')
                ->LeftJoin('user_to_address', 'user_to_address.user_id' ,'=', 'users.id')
                ->LeftJoin('address_book','address_book.address_book_id','=', 'user_to_address.address_book_id')
                ->LeftJoin('countries','countries.countries_id','=', 'address_book.entry_country_id')
                ->LeftJoin('zones','zones.zone_id','=', 'address_book.entry_zone_id')
                ->leftJoin('images','images.id', '=', 'users.avatar')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'users.avatar')
                ->select('users.*', 'address_book.entry_gender as entry_gender', 'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname', 'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address', 'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode', 'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state', 'countries.*', 'zones.*','image_categories.path as path')
                ->where(function($query) {
                    $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                        ->where('image_categories.image_type','!=',   'THUMBNAIL')
                        ->orWhere('image_categories.image_type','=',   'ACTUAL');
                })
                ->where('phone', 'LIKE', '%' .  $parameter . '%')
                ->where('users.role_id','=','2')
                ->orderBy('users.id','ASC')
                ->groupby('users.id')
                ->paginate(10);
            break;

            case 'Address':
            $user = DB::table('users')
                ->LeftJoin('user_to_address', 'user_to_address.user_id' ,'=', 'users.id')
                ->LeftJoin('address_book','address_book.address_book_id','=', 'user_to_address.address_book_id')
                ->LeftJoin('countries','countries.countries_id','=', 'address_book.entry_country_id')
                ->LeftJoin('zones','zones.zone_id','=', 'address_book.entry_zone_id')
                ->leftJoin('images','images.id', '=', 'users.avatar')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'users.avatar')
                ->select('users.*', 'address_book.entry_gender as entry_gender', 'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname', 'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address', 'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode', 'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state', 'countries.*', 'zones.*','image_categories.path as path')
                ->where(function($query) {
                    $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                        ->where('image_categories.image_type','!=',   'THUMBNAIL')
                        ->orWhere('image_categories.image_type','=',   'ACTUAL');
                })
                ->where('address_book.entry_street_address', 'LIKE', '%' .  $parameter . '%')
                ->orWhere('address_book.entry_city', 'LIKE', '%' .  $parameter . '%')
                ->orWhere('address_book.entry_state', 'LIKE', '%' .  $parameter . '%')
                ->where('users.role_id','=','2')
                ->orderBy('users.id','ASC')
                ->groupby('users.id')
                ->paginate(10);

            break;

            case 'Postcode':
            $user = DB::table('users')
                ->LeftJoin('user_to_address', 'user_to_address.user_id' ,'=', 'users.id')
                ->LeftJoin('address_book','address_book.address_book_id','=', 'user_to_address.address_book_id')
                ->LeftJoin('countries','countries.countries_id','=', 'address_book.entry_country_id')
                ->LeftJoin('zones','zones.zone_id','=', 'address_book.entry_zone_id')
                ->leftJoin('images','images.id', '=', 'users.avatar')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'users.avatar')
                ->select('users.*', 'address_book.entry_gender as entry_gender', 'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname', 'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address', 'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode', 'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state', 'countries.*', 'zones.*','image_categories.path as path')
                ->where(function($query) {
                    $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                        ->where('image_categories.image_type','!=',   'THUMBNAIL')
                        ->orWhere('image_categories.image_type','=',   'ACTUAL');
                })
                ->where('address_book.entry_postcode', 'LIKE', '%' .  $parameter . '%')
                ->where('users.role_id','=','2')
                ->orderBy('users.id','ASC')
                ->groupby('users.id')
                ->paginate(10);
            break;

            case 'City':
            $user = DB::table('users')
                ->LeftJoin('user_to_address', 'user_to_address.user_id' ,'=', 'users.id')
                ->LeftJoin('address_book','address_book.address_book_id','=', 'user_to_address.address_book_id')
                ->LeftJoin('countries','countries.countries_id','=', 'address_book.entry_country_id')
                ->LeftJoin('zones','zones.zone_id','=', 'address_book.entry_zone_id')
                ->leftJoin('images','images.id', '=', 'users.avatar')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'users.avatar')
                ->select('users.*', 'address_book.entry_gender as entry_gender', 'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname', 'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address', 'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode', 'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state', 'countries.*', 'zones.*','image_categories.path as path')
                ->where(function($query) {
                    $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                        ->where('image_categories.image_type','!=',   'THUMBNAIL')
                        ->orWhere('image_categories.image_type','=',   'ACTUAL');
                })
                ->where('address_book.entry_city', 'LIKE', '%' .  $parameter . '%')
                ->where('users.role_id','=','2')
                ->orderBy('users.id','ASC')
                ->groupby('users.id')
                ->paginate(10);
            break;

            case 'State':
            $user = DB::table('users')
                ->LeftJoin('user_to_address', 'user_to_address.user_id' ,'=', 'users.id')
                ->LeftJoin('address_book','address_book.address_book_id','=', 'user_to_address.address_book_id')
                ->LeftJoin('countries','countries.countries_id','=', 'address_book.entry_country_id')
                ->LeftJoin('zones','zones.zone_id','=', 'address_book.entry_zone_id')
                ->leftJoin('images','images.id', '=', 'users.avatar')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'users.avatar')
                ->select('users.*', 'address_book.entry_gender as entry_gender', 'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname', 'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address', 'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode', 'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state', 'countries.*', 'zones.*','image_categories.path as path')
                ->where(function($query) {
                    $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                        ->where('image_categories.image_type','!=',   'THUMBNAIL')
                        ->orWhere('image_categories.image_type','=',   'ACTUAL');
                })
                ->where('zones.zone_name', 'LIKE', '%' .  $parameter . '%')
                ->where('users.role_id','=','2')
                ->orderBy('users.id','ASC')
                ->groupby('users.id')
                ->paginate(10);
            break;

            case 'Country':
            $user = DB::table('users')
                ->LeftJoin('user_to_address', 'user_to_address.user_id' ,'=', 'users.id')
                ->LeftJoin('address_book','address_book.address_book_id','=', 'user_to_address.address_book_id')
                ->LeftJoin('countries','countries.countries_id','=', 'address_book.entry_country_id')
                ->LeftJoin('zones','zones.zone_id','=', 'address_book.entry_zone_id')
                ->leftJoin('images','images.id', '=', 'users.avatar')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'users.avatar')
                ->select('users.*', 'address_book.entry_gender as entry_gender', 'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname', 'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address', 'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode', 'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state', 'countries.*', 'zones.*','image_categories.path as path')
                ->where(function($query) {
                    $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                        ->where('image_categories.image_type','!=',   'THUMBNAIL')
                        ->orWhere('image_categories.image_type','=',   'ACTUAL');
                })
                ->where('countries.countries_name', 'LIKE', '%' .  $parameter . '%')
                ->where('users.role_id','=','2')
                ->orderBy('users.id','ASC')
                ->groupby('users.id')
                ->paginate(10);
            break;
            default: $user = $this->paginator();
        }
        return $user;

    }
}
