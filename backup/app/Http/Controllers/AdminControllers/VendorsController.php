<?php
namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Vendors;
use App\Models\Core\Images;
use App\Models\Core\Setting;
use App\Models\Core\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Kyslik\ColumnSortable\Sortable;

class VendorsController extends Controller
{
    //
    public function __construct(Vendors $vendors, Setting $setting)
    {
        $this->Vendors = $vendors;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->Setting = $setting;
    }

    public function requests() {
      $title = array('pageTitle' => Lang::get("labels.ListingVendors"));
      $language_id = '1';
      $customerData = array();
      $message = array();
      $errorMessage = array();
      $requests = $this->Vendors->requests();
      $customerData['requests'] = json_decode($requests);
      $customerData['message'] = $message;
      $customerData['errorMessage'] = $errorMessage;
      $result['commonContent'] = $this->Setting->commonContent();
      return view("admin.vendors.requests", $title)->with('data', $customerData)->with('result', $result);
    }

    public function accept(Request $request) {
      $images           = new Images;
      $allimage         = $images->getimages();
      $title            = array('pageTitle' => Lang::get("labels.EditVendor"));
      $language_id      =   '1';
      $id               =   $request->id;

      $customerData = array();
      $message = array();
      $errorMessage = array();
      $vendors = $this->Vendors->accept($id);

      $customerData['full_address'] = $vendors->address. ', ' .$vendors->city.', ' .$vendors->countries_name;

      $customerData['message'] = $message;
      $customerData['errorMessage'] = $errorMessage;
      $customerData['vendors'] = $vendors;
      $result['commonContent'] = $this->Setting->commonContent();

      return view("admin.vendors.accept", $title)->with('data', $customerData)->with('result', $result)->with('allimage', $allimage);
    }

    public function acceptRequest(Request $request) {
      $language_id = '1';

      //check email already exists
      $existEmail = $this->Vendors->email($request);

      $this->validate($request, [
          'vendor_name' => 'required',
          'vendor_name_arabic' => 'required',
          'vendor_phone' => 'required',
          'vendor_address' => 'required',            
          'email' => 'required|email',
          // 'password' => 'required',
          // 'confirm_password' => 'required',
          'vendor_open' => 'required',
          'isActive' => 'required',
      ]);
      
      // if($request->password != $request->confirm_password) {
      //   $messages = Lang::get("labels.Password not matched");
      //   return Redirect::back()->withErrors($messages)->withInput($request->all());
      // } else 
      if (count($existEmail)> 0 ) {
        $messages = Lang::get("labels.Email address already exist");
        return Redirect::back()->withErrors($messages)->withInput($request->all());
      } else {
        $vendor_status = $this->Vendors->acceptRequest($request);
        if ($vendor_status == false) {
          $messages = Lang::get("labels.noVendorsType");
          return Redirect::back()->withErrors($messages)->withInput($request->all());
        } else {
          return redirect('admin/vendors/display/');
        }          
      }
    }

    public function decline(Request $request) {
      $this->Vendors->decline($request->users_id);
    //   return redirect()->back()->withErrors([Lang::get("labels.VendorDeclineMessage")]);
    return redirect('admin/vendors/requests');
    }




    public function display()
    {
        $title = array('pageTitle' => Lang::get("labels.ListingVendors"));
        $language_id = '1';

        $vendors = $this->Vendors->paginator();

        $result = array();
        $index = 0;
        
        $vendorData = array();
        $message = array();
        $errorMessage = array();

        $vendorData['message'] = $message;
        $vendorData['errorMessage'] = $errorMessage;
        $vendorData['result'] = json_decode($vendors);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.vendors.index", $title)->with('vendors', $vendorData)->with('result', $result);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddVendor"));
        $images = new Images;
        $allimage = $images->getimages();
        $language_id = '1';
        $customerData = array();
        $message = array();
        $errorMessage = array();
        $customerData['countries'] = $this->Vendors->countries();
        $customerData['message'] = $message;
        $customerData['errorMessage'] = $errorMessage;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.vendors.add", $title)->with('vendors', $customerData)->with('allimage',$allimage)->with('result', $result);
    }


    //add addcustomers data and redirect to address
    public function insert(Request $request)
    {
      $language_id = '1';

      //check email already exists
      $existEmail = $this->Vendors->email($request);

      $this->validate($request, [
          'vendor_name' => 'required',
          'vendor_name_arabic' => 'required',
          'vendor_phone' => 'required',
          'vendor_address' => 'required',            
          'email' => 'required|email',
          'password' => 'required',
          'confirm_password' => 'required',
          'vendor_open' => 'required',
          'isActive' => 'required',
      ]);
      
      if($request->password != $request->confirm_password) {
        $messages = Lang::get("labels.Password not matched");
        return Redirect::back()->withErrors($messages)->withInput($request->all());
      } else if (count($existEmail)> 0 ) {
        $messages = Lang::get("labels.Email address already exist");
        return Redirect::back()->withErrors($messages)->withInput($request->all());
      } else if(empty($request->image_id)) {
        $messages = Lang::get("labels.NotImage");
        return Redirect::back()->withErrors($messages)->withInput($request->all());
      } else {
        $vendor_status = $this->Vendors->insert($request);
        if ($vendor_status == false) {
          $messages = Lang::get("labels.noVendorsType");
          return Redirect::back()->withErrors($messages)->withInput($request->all());
        } else {
          return redirect('admin/vendors/display/');
        }          
      }
    }
    
    //editcustomers data and redirect to address
    public function edit(Request $request){

      $images           = new Images;
      $allimage         = $images->getimages();
      $title            = array('pageTitle' => Lang::get("labels.EditVendor"));
      $language_id      =   '1';
      $id               =   $request->id;

      $customerData = array();
      $message = array();
      $errorMessage = array();
      $vendors = $this->Vendors->edit($id);

      $customerData['message'] = $message;
      $customerData['errorMessage'] = $errorMessage;
      $customerData['countries'] = $this->Vendors->countries();
      $customerData['vendors'] = $vendors;
      $result['commonContent'] = $this->Setting->commonContent();

      return view("admin.vendors.edit", $title)->with('data', $customerData)->with('result', $result)->with('allimage', $allimage);
    }

    //add addcustomers data and redirect to address
    public function update(Request $request){
        $language_id  =   '1';
        $user_id				  =	$request->vendor_id;

        $customerData = array();
        $message = array();
        $errorMessage = array();

        if ($request->changePassword == 'yes') {
          if($request->password != $request->confirm_password) {
            $messages = Lang::get("labels.Password not matched");
            return Redirect::back()->withErrors($messages)->withInput($request->all());
          }
        }

        //get function from other controller
        if($request->image_id !== null){
          $vendor_image = $request->image_id;
        }	else{
          $vendor_image = $request->oldImage;
        }

        $user_data_users = array(
          'user_name' => $request->vendor_name,
          'phone' => $request->vendor_phone,          
          'avatar' => $vendor_image,          
          'status' => $request->isActive,
          'updated_at'    => date('Y-m-d H:i:s'),
        );

        $user_data_vendors = array(
            'vendor_name' => $request->vendor_name,
            'vendor_name_arabic' => $request->vendor_name_arabic,
            'phone' => $request->vendor_phone,
            'address' => $request->vendor_address,
            'image' => $vendor_image,
            'isopened' => $request->vendor_open,
            'status' => $request->isActive,
            'updated_date'    => date('Y-m-d H:i:s'),
        );

        if ($request->changePassword == 'yes'){
          $new_pass = Hash::make($request->password);
          $user_data_users['password'] = $new_pass;
        }

        $this->Vendors->updaterecord($user_id, $user_data_users, $user_data_vendors);
        $message = Lang::get("labels.Vendor has been updated successfully");
		    return redirect()->back()->with('message', $message);
    }

    public function delete(Request $request){
      $this->Vendors->destroyrecord($request->users_id);
      return redirect()->back()->withErrors([Lang::get("labels.DeleteVendorMessage")]);
    }

    public function filter(Request $request){
      $filter    = $request->FilterBy;
      $parameter = $request->parameter;

      $title = array('pageTitle' => Lang::get("labels.ListingCustomers"));
      $customers  = $this->Customers->filter($request);

      $result = array();
      $index = 0;
      foreach($customers as $customers_data){
          array_push($result, $customers_data);

          $devices = DB::table('devices')->where('user_id','=',$customers_data->id)->orderBy('created_at','DESC')->take(1)->get();
          $result[$index]->devices = $devices;
          $index++;
      }

      $customerData = array();
      $message = array();
      $errorMessage = array();

      $customerData['message'] = $message;
      $customerData['errorMessage'] = $errorMessage;
      $customerData['result'] = $customers;
      $result['commonContent'] = $this->Setting->commonContent();

      return view("admin.customers.index",$title)->with('result', $result)->with('customers', $customerData)->with('filter',$filter)->with('parameter',$parameter);
    }
}
