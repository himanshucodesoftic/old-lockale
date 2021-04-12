<!-- login Content -->
<div class="container-fuild">
  <nav aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('website.Login')</li>
      </ol>
    </div>
  </nav>
</div>

<section class="page-area pro-content bg_gray" style="padding-top: 40px; padding-bottom: 35px;">

  <link href="{!! asset('web/css/theme_css/account.css') !!}" rel="stylesheet">

  <div class="container">
    <div class="page_header">
      <h1>@lang('website.Sign In or Create an Account')</h1>
    </div>

    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-6 col-md-8">
        <div class="box_account">
          <h3 class="client">@lang('website.LOGIN')</h3>
          <div class="form_container">
						@if($result['commonContent']['setting'][61]->value==1 || $result['commonContent']['setting'][2]->value==1)
            <div class="row no-gutters">
							@if($result['commonContent']['setting'][2]->value==1)
              <div class="col-lg-6 pr-lg-1">
                <a href="login/google" class="social_bt facebook">@lang('website.Facebook')</a>
              </div>
							@endif
							@if($result['commonContent']['setting'][61]->value==1)
              <div class="col-lg-6 pl-lg-1">
                <a href="login/facebook" class="social_bt google">@lang('website.Google')</a>
              </div>
							@endif
            </div>
            <div class="divider"><span>@lang('website.Or')</span></div>
						@endif

						<form enctype="multipart/form-data" class="form-validate-login" action="{{ URL::to('/process-login')}}"
            method="post">
						{{csrf_field()}}
            <div class="form-group">
							<label for="inlineFormInputGroup">@lang('website.Email')</label>         
							<input type="email" name="email" id="email"
                  placeholder="@lang('website.Please enter your valid email address')"
                  class="form-control email-validate-login">
							<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your valid email address')</span>
            </div>
            <div class="form-group">
							<label for="inlineFormInputGroup">@lang('website.Password')</label>
							<input type="password" name="password" id="password-login" placeholder="@lang('website.Please Enter Password')"
                  class="form-control password-login">
							<span class="form-text text-muted error-content" hidden>@lang('website.This field is required')</span>
            </div>

            <div class="clearfix add_bottom_15">
              <div class="checkboxes float-left">
                <label class="container_check">@lang('website.Remember me')
                  <input type="checkbox">
                  <span class="checkmark"></span>
                </label>
              </div>
              <div class="float-right"><a style='color: #b3b1b1;' href="{{ URL::to('/forgotPassword')}}">@lang('website.Forgot Password')</a></div>
            </div>

            <div class="text-center"><input type="submit" value="@lang('website.Login')" class="btn_1 full-width"></div>
            
            @if($result['checkout_button'] == 1)
              <p style="text-align:center; margin-top:30px;">
                <strong> @lang('website.OR')</strong>
              </p>
              <a href="{{url('/guest_checkout')}}" type="submit" class="btn btn-light swipe-to-top btn-block">
                @lang('website.Guest Checkout')
              </a>
            @endif

			</form>

            <!-- <div id="forgot_pw">
              <div class="form-group">
                <input type="email" class="form-control" name="email_forgot" id="email_forgot"
                  placeholder="Type your email">
              </div>
              <p>A new password will be sent shortly.</p>
              <div class="text-center"><input type="submit" value="Reset Password" class="btn_1"></div>
            </div> -->

          </div>
          <!-- /form_container -->
        </div>
        <!-- /box_account -->
        <!-- <div class="row">
          <div class="col-md-6 d-none d-lg-block">
            <ul class="list_ok">
              <li>Find Locations</li>
              <li>Quality Location check</li>
              <li>Data Protection</li>
            </ul>
          </div>
          <div class="col-md-6 d-none d-lg-block">
            <ul class="list_ok">
              <li>Secure Payments</li>
              <li>H24 Support</li>
            </ul>
          </div>
        </div> -->
        <!-- /row -->
      </div>
      <div class="col-xl-6 col-lg-6 col-md-8">
        <div class="box_account">
          <h3 class="new_client">@lang('website.NEW CUSTOMER')</h3>
          <div class="form_container">
						<form name="signup" enctype="multipart/form-data" class="form-validate"
            action="{{ URL::to('/signupProcess')}}" method="post">
						{{csrf_field()}}
            <div class="form-group">
							<label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Email Adrress')</label>           
							<input name="email" type="text" class="form-control email-validate" id="inlineFormInputGroup"
								placeholder="Enter Your Email or Username" value="{{ old('email') }}">
							<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your valid email address')</span>
            </div>
            <div class="form-group">
							<label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Password')</label>        
							<input name="password" id="password" type="password" class="form-control password"
								placeholder="@lang('website.Please enter your password')">
							<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your password')</span>
            </div>
						<div class="form-group">
							<label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Confirm Password')</label>            
							<input type="password" class="form-control password" id="re_password" name="re_password"
								placeholder="Enter Your Password">
							<span class="form-text text-muted error-content" hidden>@lang('website.Please re-enter your password')</span>
							<span class="form-text text-muted re-password-content" hidden>@lang('website.Password does not match the confirm password')</span>
            </div>

            <hr>
            <!-- <div class="form-group">
              <label class="container_radio" style="display: inline-block; margin-right: 15px;">Private
                <input type="radio" name="client_type" checked value="private">
                <span class="checkmark"></span>
              </label>
              <label class="container_radio" style="display: inline-block;">Company
                <input type="radio" name="client_type" value="company">
                <span class="checkmark"></span>
              </label>
            </div> -->
            <div class="private box">
              <div class="row no-gutters">
                <div class="col-6 pr-1">
                  <div class="form-group">
										<label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.First Name')</label>                
										<input name="firstName" type="text" class="form-control field-validate" id="firstName"
											placeholder="@lang('website.Please enter your first name')" value="{{ old('firstName') }}">
										<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your first name')</span>
                  </div>
                </div>
                <div class="col-6 pl-1">
                  <div class="form-group">
										<label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Last Name')</label>               
										<input name="lastName" type="text" class="form-control field-validate" id="lastName"
											placeholder="@lang('website.Please enter your first name')" value="{{ old('lastName') }}">
										<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your last name')</span>
                  </div>
                </div>
                <!-- <div class="col-12">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Full Address*">
                  </div>
                </div> -->
              </div>
              <!-- /row -->
              <div class="row no-gutters">
                <div class="col-6 pr-1">
                  <div class="form-group">
										<label for="inlineFormInputGroup">@lang('website.Date of Birth')</label>               
										<input name="customers_dob" type="text" class="form-control customers_dob" data-provide="datepicker"
											id="customers_dob" placeholder="@lang('website.Please enter your date of birth')"
											value="{{ old('customers_dob') }}">
										<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your date of birth')</span>
                  </div>
                </div>
                <div class="col-6 pl-1">
                  <div class="form-group">
										<label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Gender')</label>
										<select class="form-control field-validate" name="gender" id="inlineFormCustomSelect">
											<option selected value="">@lang('website.Choose...')</option>
											<option value="0" @if(!empty(old('gender')) and old('gender')==0) selected @endif)>
												@lang('website.Male')</option>
											<option value="1" @if(!empty(old('gender')) and old('gender')==1) selected @endif>
												@lang('website.Female')</option>
										</select>
										<span class="form-text text-muted error-content" hidden>@lang('website.Please select your gender')</span>
                  </div>
                </div>
              </div>
              <!-- /row -->

              <div class="row no-gutters">
                <!-- <div class="col-6 pr-1">
                  <div class="form-group">
                    <div class="custom-select-form">
                      <select class="wide add_bottom_10" name="country" id="country">
                        <option value="" selected>Country*</option>
                        <option value="Europe">Europe</option>
                        <option value="United states">United states</option>
                        <option value="Asia">Asia</option>
                      </select>
                    </div>
                  </div>
                </div> -->
                <div class="col-12 pl-1">
                  <div class="form-group">
										<label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Phone Number')</label>                
										<input name="phone" type="text" class="form-control phone-validate" id="phone"
											placeholder="@lang('website.Please enter your valid phone number')" value="{{ old('phone') }}">
										<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your valid phone number')</span>
                  </div>
                </div>
              </div>
              <!-- /row -->

            </div>
            <!-- /private -->
            
            <!-- /company -->
            <hr>
            <div class="form-group">
              <label class="container_check">@lang('website.Accept') <a href="{{url('/page?name=term-services')}}">@lang('website.Terms & Condtions')</a>
                <input type="checkbox">
                <span class="checkmark"></span>
              </label>
            </div>
            <div class="text-center"><input type="submit" value="@lang('website.Create an Account')" class="btn_1 full-width"></div>

						</form>

          </div>
          <!-- /form_container -->
        </div>
        <!-- /box_account -->
      </div>
    </div>   

  </div>
</section>