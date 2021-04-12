@extends('web.layout')
@section('content')
  <!-- login Content -->
  <div class="container-fuild">
    <nav aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
          <li class="breadcrumb-item active" aria-current="page">@lang('website.vendor')</li>

        </ol>
      </div>
      </nav>
    </div> 

  <section class="page-area pro-content" style="padding-top: 50px;">
    <div class="container">     

      <div class="row">
        <div class="col-12 col-sm-12 col-md-3">
        </div>

        <div class="col-12 col-sm-12 col-md-6">
          @if( count($errors) > 0)
            @foreach($errors->all() as $error)
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">@lang('website.Error'):</span>
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endforeach
          @endif

          @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">@lang('website.Error'):</span>
              {!! session('error') !!}

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          @if(session()->has('message'))
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              {{ session()->get('message') }}
            </div>
          @endif

          <div class="col-12"><h4 class="heading login-heading">@lang('website.Vendor Form')</h4></div>

          <div class="registration-process" style="padding-bottom: 55px;">                

            <form name="signup" enctype="multipart/form-data"  action="{{ URL::to('/confirmVendor')}}" method="post">
              {{csrf_field()}}
              <div class="from-group mb-3">
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-6">
                    <div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.First Name')</label></div>
                    <div class="input-group col-12">
                      <input name="firstName" type="text" class="form-control field-validate" id="firstName" placeholder="" value="" required>
                      <span class="help-block" hidden>@lang('website.Please enter your first name')</span>
                    </div>
                  </div>

                  <div class="col-12 col-sm-12 col-md-6">
                    <div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.Last Name')</label></div>
                    <div class="input-group col-12">										
                      <input name="lastName" type="text" class="form-control field-validate" id="lastName" placeholder="" value="" required>
                      <span class="help-block" hidden>@lang('website.Please enter your last name')</span>
                    </div>
                  </div>
                </div>                    
              </div>                  

              <div class="from-group mb-3">
                <div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.address')</label></div>
                <div class="input-group col-12">
                  <input name="vendor_address" type="text" class="form-control field-validate" id="vendor_address" placeholder="" required>
                </div>
              </div>

              <div class="from-group mb-3">
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-6">
                    <div class="col-12">
                      <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.city')</label>
                    </div>
                    <div class="input-group col-12">
                      <input name="vendor_city" type="text" class="form-control field-validate" id="vendor_city" placeholder="" required>
                    </div>                      
                  </div>

                  <div class="col-12 col-sm-12 col-md-6">
                    <div class="col-12" style="display: none;">
                      <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.zipcode')</label>
                    </div>
                    <div class="input-group col-12">
                      <input name="vendor_zipcode" type="hidden" class="form-control" id="vendor_zipcode" placeholder="" value="">
                    </div>

                    <div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.Country')</label></div>
                    <div class="input-group col-12">
                      <select class="form-control field-validate" name="country" id="country" required>
                        <option value="">{{ trans('labels.SelectCountry') }}</option>
                        @foreach($result['countries'] as $countries_data)
                          <option value="{{ $countries_data->countries_id }}">{{ $countries_data->countries_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="from-group mb-3">
                <div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.Phone Number')</label></div>
                <div class="input-group col-12">
                  <input name="phone_number" type="tel" class="form-control field-validate" id="phone_number" placeholder="" required>
                </div>
              </div>

              <div class="from-group mb-3">
                <div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.Vendor Title')</label></div>
                <div class="input-group col-12">
                  <input name="vendor_name" id="vendor_name" type="text" class="form-control field-validate"  placeholder="" required>
                  <span class="help-block" hidden>@lang('website.Please enter vendor title')</span>
                </div>
              </div>

              <div class="from-group mb-3">
                <div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.Vendor Arabic Title')</label></div>
                <div class="input-group col-12">
                  <input name="vendor_arabic_name" id="vendor_arabic_name" type="text" class="form-control field-validate"  placeholder="" required>
                  <span class="help-block" hidden>@lang('website.Please enter vendor arabic title')</span>
                </div>
              </div>

              <div class="from-group mb-3">
                <div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.Email Adrress')</label></div>
                <div class="input-group col-12">
                  <input name="email" type="email" class="form-control email-validate" id="email" placeholder="" value="" required>
                  <span class="help-block" hidden>@lang('website.Please enter your valid email address')</span>
                </div>
              </div>

              <div class="from-group mb-3">
                <div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>&nbsp;@lang('website.Password')</label></div>
                <div class="input-group col-12">
                  <input name="password" type="password" class="form-control field-validate" id="password" placeholder="" value="" required>
                  <span class="help-block" hidden>@lang('website.Please enter your password')</span>
                </div>
              </div>
              
              <div class="from-group mb-3">
                <div class="input-group col-12">
                  <input required style="margin:4px;" class="form-controlt checkbox-validate" type="checkbox">
                  @lang('website.confirm request means you agree on our')  @if(!empty($result['commonContent']['pages'][3]->slug))&nbsp;<a href="{{ URL::to('/page?name='.$result['commonContent']['pages'][3]->slug)}}">@endif @lang('website.Terms and Services')@if(!empty($result['commonContent']['pages'][3]->slug))</a>@endif &nbsp; and &nbsp; @if(!empty($result['commonContent']['pages'][1]->slug))<a href="{{ URL::to('/page?name='.$result['commonContent']['pages'][1]->slug)}}">@endif @lang('website.Privacy Policy')@if(!empty($result['commonContent']['pages'][1]->slug))</a> @endif.
                  <span class="help-block" hidden>@lang('website.Please accept our terms and conditions')</span>
                </div>
              </div>
              <div class="col-12 col-sm-12">
                <button type="submit" class="btn btn-light swipe-to-top">@lang('website.Confirm Request')</button>
              </div>
            </form>
          </div>
        </div>          
      </div>

      <div class="col-12 col-sm-12 col-md-3">
      </div>

    </div>
  </section>

@endsection