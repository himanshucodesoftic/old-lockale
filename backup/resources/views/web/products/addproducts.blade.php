@extends('web.layout')
@section('content')

<!-- checkout Content -->
<section class="checkout-area"> 
  @php
  $product_name_en = 'products_name_'.session('en_id');
  $product_name_ar = 'products_name_'.session('ar_id');

  $products_description_en = 'products_description_'.session('en_id');
  $products_description_ar = 'products_description_'.session('ar_id');
  @endphp
  <div class="container-fuild">
    <nav aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)">@lang('website.addProduct')</a></li>
          <li class="breadcrumb-item">
            <a href="javascript:void(0)">
              @if(session('step_car')== 0)
                @lang('website.Product Information')
              @elseif(session('step_car')==1)
                @lang('website.Product Pictures')
              @elseif(session('step_car')==2)
                @lang('website.Summary')
              @endif
            </a>
          </li>
        </ol>
      </div>
    </nav>
  </div>

  <section class="pro-content" style="padding-top: 50px;">

    <div class="container">
      <div class="page-heading-title">
        <h2> @lang('website.addProduct') </h2>
      </div>
    </div>
  
    <section class="checkout-area">
      <div class="container">
        <div class="row">
          <div class="col-xl-2">
          </div>

          <div class="col-12 col-xl-9 checkout-left">            

            <div class="row">
              <div class="checkout-module">
                <ul class="nav nav-pills mb-3 checkoutd-nav d-none d-lg-flex" id="pills-tab" role="tablist">
                  <li class="nav-item" style="width: calc(30% - 17px);">
                    <a style="padding-left: 25%;" class="nav-link @if(session('step_car')==0) active @elseif(session('step_car')>0)  @endif" id="pills-shipping-tab" data-toggle="pill" href="#pills-shipping" role="tab" aria-controls="pills-shipping" aria-selected="true">
                      <span class="d-flex d-lg-none">1</span>
                      <span class="d-none d-lg-flex">@lang('website.Product Information')</span></a>
                  </li>
                  <li class="nav-item" style="width: calc(30% - 17px);">
                    <a style="padding-left: 25%;" class="nav-link @if(session('step_car')==1) active @elseif(session('step_car')>1) @endif" @if(session('step_car')>=1) id="pills-billing-tab" data-toggle="pill" href="#pills-billing" role="tab" aria-controls="pills-billing" aria-selected="false"  @endif >@lang('website.Product Pictures')</a>
                  </li>
                  <li class="nav-item" style="width: calc(30% - 17px);">
                    <a style="padding-left: 25%;" class="nav-link @if(session('step_car')==2) active @elseif(session('step_car')>2)  @endif" @if(session('step_car')>=2) id="pills-method-tab" data-toggle="pill" href="#pills-method" role="tab" aria-controls="pills-method" aria-selected="false" @endif> @lang('website.Summary')</a>
                  </li>                  
                </ul>

                <ul class="nav nav-pills mb-3 checkoutd-nav d-flex d-lg-none" id="pills-tab" role="tablist">
                  <li class="nav-item" style="width: calc(30% - 17px);">
                    <a class="nav-link @if(session('step_car')==0) active @elseif(session('step_car')>0) active-check @endif" id="pills-shipping-tab" data-toggle="pill" href="#pills-shipping" role="tab" aria-controls="pills-shipping" aria-selected="true">1</a>
                  </li>
                  <li class="nav-item second" style="width: calc(30% - 17px);">
                    <a class="nav-link @if(session('step_car')==1) active @elseif(session('step_car')>1) active-check @endif" @if(session('step_car')>=1) id="pills-billing-tab" data-toggle="pill" href="#pills-billing" role="tab" aria-controls="pills-billing" aria-selected="false"  @endif >2</a>
                  </li>
                  <li class="nav-item third" style="width: calc(30% - 17px);">
                    <a class="nav-link @if(session('step_car')==2) active @elseif(session('step_car')>2) active-check @endif" @if(session('step_car')>=2) id="pills-method-tab" data-toggle="pill" href="#pills-method" role="tab" aria-controls="pills-method" aria-selected="false" @endif>3</a>
                  </li>                  
                </ul>

                <div class="tab-content" id="pills-tabContent">

                  <div class="tab-pane fade @if(session('step_car') == 0) show active @endif" id="pills-shipping" role="tabpanel" aria-labelledby="pills-shipping-tab">
                    <form name="signup" enctype="multipart/form-data" action="{{ URL::to('/saveinfo')}}" method="post">
                      <input type="hidden" required name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <div class="form-row">
                        <div class="form-group">
                          <label for=""> @lang('website.Product Name') (@lang('website.English'))<span style="color:red;">*</span></label>
                          <input type="text" class="form-control field-validate" id="{{$product_name_en}}" name="{{$product_name_en}}" value="@if(!empty(session('car_info'))){{session('car_info')->$product_name_en}} @endif" aria-describedby="NameHelp1" placeholder="">
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter car name')</span>
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('website.Product Name') (@lang('website.Arabic'))<span style="color:red;">*</span></label>
                          <input type="text" class="form-control field-validate" id="{{$product_name_ar}}" name="{{$product_name_ar}}" value="@if(!empty(session('car_info'))){{session('car_info')->$product_name_ar}} @endif" aria-describedby="NameHelp1" placeholder="">
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter car name')</span>
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('website.Categories')<span style="color:red;">*</span></label>
                          <div class="input-group select-control">
                            <select required class="form-control field-validate" id="category_id" name="category_id" type="button" onChange="getSubCategories(this.value);">
                              <option value="" selected disabled>@lang('website.Select Categories')</option>
                              @if(!empty($result['categories']))
                                @foreach($result['categories'] as $brand)
                                  <option value="{{$brand->categories_id}}" @if(!empty(session('car_info'))) @if(session('car_info')->category_id == $brand->categories_id) selected @endif @endif >{{$brand->categories_name}}</option>
                                @endforeach
                              @endif
                            </select>
                          </div>
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please select category')</span>
                          <input type="hidden" class="form-control" id="category_name" name="category_name">
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('website.Sub Categories')</label>
                          <div class="input-group select-control">
                            <select class="form-control" id="sub_category_id" name="sub_category_id" type="button" onChange="changeSubCategories(this.value);">
                              <option value="" selected disabled>@lang('website.Select Sub Categories')</option>
                            </select>
                          </div>
                          <input type="hidden" class="form-control" id="sub_category_name" name="sub_category_name">
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('labels.IsFeature')</label>
                          <div class="input-group select-control">
                            <select class="form-control" name="is_feature" type="button">
                              <option value="0" @if(!empty(session('car_info'))) @if(session('car_info')->is_feature == '0') selected @endif @endif>{{ trans('labels.No') }}</option>
                              <option value="1" @if(!empty(session('car_info'))) @if(session('car_info')->is_feature == '1') selected @endif @endif>{{ trans('labels.Yes') }}</option>
                            </select>
                          </div>
                          <small id="stateHelp" class="form-text text-muted"></small>
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('website.Price')<span style="color:red;">*</span></label>
                          <input required type="number" class="form-control field-validate" id="price" name="price" value="@if(!empty(session('car_info'))){{session('car_info')->price}}@endif" placeholder="">
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter price')</span>
                        </div>

                        <!-- <div class="form-group">
                          <label for="name">{{ trans('labels.Min Order Limit') }}<span style="color:red;">*</span></label>
                          <div>
                            {!! Form::text('products_min_order', '1', array('class'=>'form-control field-validate number-validate', 'id'=>'products_min_order')) !!}
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                {{ trans('labels.Min Order Limit Text') }}
                            </span>
                          </div>
                        </div> -->

                        <div class="form-group">
                          <label for="name">{{ trans('labels.Max Order Limit') }}<span style="color:red;">*</span></label>
                          <div>                            
                            <input type="text" class="form-control field-validate" id="products_max_stock" name="products_max_stock" value="@if(!empty(session('car_info'))){{session('car_info')->products_max_stock}}@else 9999 @endif" aria-describedby="NameHelp1" placeholder="">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="name">{{ trans('labels.ProductsQuantity') }}<span style="color:red;">*</span></label>
                          <div>                            
                            <input type="text" class="form-control field-validate" id="products_quantity" name="products_quantity" value="@if(!empty(session('car_info'))){{session('car_info')->products_quantity}} @else 20 @endif" aria-describedby="NameHelp1" placeholder="">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="name">{{ trans('labels.ProductsWeight') }}<span style="color:red;">*</span></label>
                          <div>                            
                            <input type="number" class="form-control field-validate number-validate" id="products_weight" name="products_weight" value="@if(!empty(session('car_info'))){{session('car_info')->products_weight}}@endif" aria-describedby="NameHelp1" placeholder="">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('website.Unit')</label>
                          <div class="input-group select-control">
                            <select class="form-control" name="products_weight_unit" type="button">
                              <option value="gm">Gm</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="name">{{ trans('labels.Description') }}<span style="color:red;">*</span> (@lang('website.English'))</label>
                          <div>
                            <textarea id="editor{{session('en_id')}}" name="{{$products_description_en}}" class="form-control" rows="5">@if(!empty(session('car_info'))){{session('car_info')->$products_description_en}}@endif</textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                              {{ trans('labels.EnterProductDetailIn') }} (@lang('website.English'))</span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="name">{{ trans('labels.Description') }}<span style="color:red;">*</span> (@lang('website.Arabic'))</label>
                          <div>
                            <textarea id="editor{{session('ar_id')}}" name="{{$products_description_ar}}" class="form-control" rows="5">@if(!empty(session('car_info'))){{session('car_info')->$products_description_ar}}@endif</textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                              {{ trans('labels.EnterProductDetailIn') }} (@lang('website.Arabic'))</span>
                          </div>
                        </div>

                        
                        <div class="form-group flash-sale-link">
                          <label for="name">{{ trans('labels.FlashSale') }}</label>
                          <div>
                            <select class="form-control" onChange="showFlash();" name="isFlash" id="isFlash" type="button">
                              <option value="no" @if(!empty(session('car_info'))) @if(session('car_info')->isFlash == 'no') selected @endif @endif>{{ trans('labels.No') }}</option>
                              <option value="yes" @if(!empty(session('car_info'))) @if(session('car_info')->isFlash == 'yes') selected @endif @endif>{{ trans('labels.Yes') }}</option>
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.FlashSaleText') }}</span>
                          </div>                        

                          <div class="flash-container" style="display: none; margin-top: 10px;">
                            <div>
                              <label for="name">{{ trans('labels.FlashSalePrice') }}<span style="color:red;">*</span></label>
                              <div>
                                <input class="form-control" type="text" name="flash_sale_products_price" id="flash_sale_products_price" value="@if(!empty(session('car_info'))){{session('car_info')->flash_sale_products_price}} @endif">
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.FlashSalePriceText') }}</span>
                              </div>
                            </div>

                            <div style="margin-top: 10px;">
                              <label for="name">{{ trans('labels.FlashSaleDate') }}<span style="color:red;">*</span></label>
                              <div style="display: flex;">
                                <div class="col-xs-12 col-md-6">
                                  <input class="form-control" type="date" name="flash_start_date" id="flash_start_date" value="@if(!empty(session('car_info'))){{session('car_info')->flash_start_date}} @endif">
                                </div>
                                <div class="col-xs-12 col-md-6">
                                  <input type="time" class="form-control" name="flash_start_time" id="flash_start_time" value="@if(!empty(session('car_info'))){{session('car_info')->flash_start_time}} @endif">
                                </div>
                              </div>
                            </div>

                            <div style="margin-top: 10px;">
                              <label for="name">{{ trans('labels.FlashExpireDate') }}<span style="color:red;">*</span></label>
                              <div style="display: flex;">
                                <div class="col-xs-12 col-md-6">
                                  <input class="form-control" type="date" name="flash_expires_date" id="flash_expires_date" value="@if(!empty(session('car_info'))){{session('car_info')->flash_expires_date}} @endif">                                  
                                </div>
                                <div class="col-xs-12 col-md-6">
                                  <input type="time" class="form-control" name="flash_end_time" id="flash_end_time" value="@if(!empty(session('car_info'))){{session('car_info')->flash_end_time}} @endif">
                                </div>
                              </div>                              
                            </div>

                            <div style="margin-top: 10px;">
                              <label for="name">{{ trans('labels.Status') }}</label>
                              <div>
                                <select class="form-control" name="flash_status" type="button">
                                  <option value="1" @if(!empty(session('car_info'))) @if(session('car_info')->flash_status == '1') selected @endif @endif>{{ trans('labels.Active') }}</option>
                                  <option value="0" @if(!empty(session('car_info'))) @if(session('car_info')->flash_status == '0') selected @endif @endif>{{ trans('labels.Inactive') }}</option>
                                </select>
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ActiveFlashSaleProductText') }}</span>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group special-link">
                          <label for="name">{{ trans('labels.Special') }}</label>
                          <div>
                            <select class="form-control" onChange="showSpecial();" name="isSpecial" id="isSpecial" type="button">
                              <option value="no" @if(!empty(session('car_info'))) @if(session('car_info')->isSpecial == 'no') selected @endif @endif>{{ trans('labels.No') }}</option>
                              <option value="yes" @if(!empty(session('car_info'))) @if(session('car_info')->isSpecial == 'yes') selected @endif @endif>{{ trans('labels.Yes') }}</option>
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.SpecialProductText') }}.</span>
                          </div>                        

                          <div class="special-container" style="display: none; margin-top: 10px;">
                            <div style="margin-top: 10px;">
                              <label for="name">{{ trans('labels.SpecialPrice') }}<span style="color:red;">*</span></label>
                              <div>
                                <input class="form-control" type="text" name="specials_new_products_price" id="special-price" value="@if(!empty(session('car_info'))){{session('car_info')->specials_new_products_price}} @endif">
                              </div>
                            </div>

                            <div style="margin-top: 10px;">
                              <label for="name">{{ trans('labels.ExpiryDate') }}<span style="color:red;">*</span></label>
                              <div>
                                <input class="form-control" type="date" name="expires_date" id="expiry-date" value="@if(!empty(session('car_info'))){{session('car_info')->expires_date}} @endif">
                              </div>
                            </div>

                            <div style="margin-top: 10px;">
                              <label for="name">{{ trans('labels.Status') }}<span style="color:red;">*</span></label>
                              <div>
                                <select class="form-control" name="status" type="button">
                                  <option value="1" @if(!empty(session('car_info'))) @if(session('car_info')->status == '1') selected @endif @endif>{{ trans('labels.Active') }}</option>
                                  <option value="0" @if(!empty(session('car_info'))) @if(session('car_info')->status == '0') selected @endif @endif>{{ trans('labels.Inactive') }}</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <hr>
                      <div class="form-row" style="display: block; margin-top: 5%;">
                        <div class="form-group">
                          <button type="submit"  class="btn swipe-to-top btn-secondary">@lang('website.Continue')</button>
                        </div>
                      </div>                     
                        
                    </form>
                  </div>






                  <div class="tab-pane fade @if(session('step_car') == 1) show active @endif"  id="pills-billing" role="tabpanel" aria-labelledby="pills-billing-tab">                  
                    <div class="">
                      <div class="col-12 col-sm-12">
                        @if(!empty(session('images')))
                          @if(count(session('images')) == 1)
                            @foreach(session('images') as $key => $imgs)                            
                              <img src="{{asset('').$imgs['path']}}" alt="" class="for" style="width: 50%;">
                            @endforeach
                          @else
                            @foreach(session('images') as $key => $imgs)                            
                              <div class="col-3 col-sm-3 form-group">
                                <img src="{{asset('').$imgs['path']}}" alt="" class="for" style="width: 100%;">
                              </div>
                            @endforeach
                          @endif
                        @endif
                      </div>

                      <div class="">
                          <div class="">                              
                            <h4 class="modal-title">Add File Here</h4>
                          </div>
                          <div class="">
                              <p>Click or Drop Images in the Box for Upload.</p>
                              <form action="{{ url('/uploadimage') }}" enctype="multipart/form-data"
                                  class="dropzone " id="my-dropzone">
                                  <input type="hidden" required name="_token" id="csrf-token" value="{{ Session::token() }}" />
                              </form>
                          </div>

                          <form enctype="multipart/form-data" action="{{ URL::to('/savepics')}}" method="post">
                            <input type="hidden" required name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <div class="form-group text-right mt-3" style="width:100%">
                              <button type="submit" class="btn btn-secondary">@lang('website.Continue')</button>                              
                            </div>
                          </form>                          
                      </div>
                    </div>
                  </div>             
                  
                  



                  <div class="tab-pane fade  @if(session('step_car') == 2) show active @endif" id="pills-method" role="tabpanel" aria-labelledby="pills-method-tab">                    
                    <br>
                    <form name="summary" method="post" id="summary" enctype="multipart/form-data" action="{{ URL::to('/postProduct')}}">

                      <input type="hidden" required name="_token" id="csrf-token" value="{{ Session::token() }}" />

                      <div class="row">
                        <div class="col-5 col-sm-5">
                          <div class="form-row">
                            <div class="form-group">
                              <label for=""> @lang('website.Product Name') (@lang('website.English'))</label>
                              <input type="text" readonly class="form-control field-validate" id="{{$product_name_en}}" name="{{$product_name_en}}" value="@if(!empty(session('car_info'))){{session('car_info')->$product_name_en}}@endif" aria-describedby="NameHelp1" placeholder="">
                            </div>

                            <div class="form-group">
                              <label for=""> @lang('website.Product Name') (@lang('website.Arabic'))</label>
                              <input type="text" readonly class="form-control field-validate" id="{{$product_name_ar}}" name="{{$product_name_ar}}" value="@if(!empty(session('car_info'))){{session('car_info')->$product_name_ar}}@endif" aria-describedby="NameHelp1" placeholder=""> 
                            </div>

                            <div class="form-group">
                              <label for=""> @lang('website.Categories')</label>
                              <div class="input-group select-control">
                                <input type="text" readonly class="form-control" value="@if(!empty(session('car_info'))){{session('car_info')->category_name}}@endif">
                                <input type="hidden" class="form-control field-validate" id="category_id" name="category_id" value="@if(!empty(session('car_info'))){{session('car_info')->category_id}}@endif">
                              </div>                              
                            </div>

                            <div class="form-group">
                              <label for=""> @lang('website.Sub Categories')</label>
                              <div class="input-group select-control">
                                <input type="text" readonly class="form-control" value="@if(!empty(session('car_info'))){{session('car_info')->sub_category_name}}@endif">
                                <input type="hidden" class="form-control" id="sub_category_id" name="sub_category_id" value="@if(!empty(session('car_info'))){{session('car_info')->sub_category_id}}@endif">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for=""> @lang('labels.IsFeature')</label>
                              <div class="input-group select-control">
                                <select class="form-control" disabled>
                                  <option value="0" @if(!empty(session('car_info'))) @if(session('car_info')->is_feature == '0') selected @endif @endif>{{ trans('labels.No') }}</option>
                                  <option value="1" @if(!empty(session('car_info'))) @if(session('car_info')->is_feature == '1') selected @endif @endif>{{ trans('labels.Yes') }}</option>
                                </select>
                                <input type="hidden" class="form-control field-validate" id="is_feature" name="is_feature" value="@if(!empty(session('car_info'))){{session('car_info')->is_feature}}@endif">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for=""> @lang('website.Price')</label>
                              <input readonly type="number" class="form-control field-validate" id="price" name="price" value="@if(!empty(session('car_info'))){{session('car_info')->price}}@endif" placeholder="">
                            </div>
                            
                            <div class="form-group">
                              <label for="name">{{ trans('labels.Max Order Limit') }}</label>
                              <div>                            
                                <input type="text" class="form-control field-validate" id="products_max_stock" name="products_max_stock" value="@if(!empty(session('car_info'))){{session('car_info')->products_max_stock}}@else 9999 @endif" aria-describedby="NameHelp1" placeholder="" readonly>
                              </div>
                            </div>                           

                            <div class="form-group">
                              <label for="name">{{ trans('labels.ProductsQuantity') }}</label>
                              <div>                            
                                <input type="text" class="form-control field-validate" id="products_quantity" name="products_quantity" value="@if(!empty(session('car_info'))){{session('car_info')->products_quantity}}@endif" aria-describedby="NameHelp1" placeholder="" readonly>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="name">{{ trans('labels.ProductsWeight') }}</label>
                              <div>                            
                                <input type="number" class="form-control field-validate number-validate" id="products_weight" name="products_weight" value="@if(!empty(session('car_info'))){{session('car_info')->products_weight}}@endif" aria-describedby="NameHelp1" placeholder="" readonly>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for=""> @lang('website.Unit')</label>
                              <div class="input-group select-control">
                                <select class="form-control" name="products_weight_unit" readonly>
                                  <option value="gm">Gm</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="name">{{ trans('labels.Description') }}<span style="color:red;">*</span> (@lang('website.English'))</label>
                              <div>
                                <textarea name="{{$products_description_en}}" class="form-control" rows="5" readonly>@if(!empty(session('car_info'))){{session('car_info')->$products_description_en}}@endif</textarea>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="name">{{ trans('labels.Description') }}<span style="color:red;">*</span> (@lang('website.Arabic'))</label>
                              <div>
                                <textarea name="{{$products_description_ar}}" class="form-control" rows="5" readonly>@if(!empty(session('car_info'))){{session('car_info')->$products_description_ar}}@endif</textarea>
                              </div>
                            </div>
                            
                            <div class="form-group flash-sale-link">
                              <label for="name">{{ trans('labels.FlashSale') }}</label>
                              <div>
                                <select class="form-control" disabled>
                                  <option value="no" @if(!empty(session('car_info'))) @if(session('car_info')->isFlash == 'no') selected @endif @endif>{{ trans('labels.No') }}</option>
                                  <option value="yes" @if(!empty(session('car_info'))) @if(session('car_info')->isFlash == 'yes') selected @endif @endif>{{ trans('labels.Yes') }}</option>
                                </select>
                                <input type="hidden" class="form-control field-validate" id="isFlash" name="isFlash" value="@if(!empty(session('car_info'))){{session('car_info')->isFlash}}@endif">
                              </div>                        

                              <div class="flash-container" style="display: none; margin-top: 10px;">
                                <div>
                                  <label for="name">{{ trans('labels.FlashSalePrice') }}</label>
                                  <div>
                                    <input class="form-control" type="text" name="flash_sale_products_price" id="flash_sale_products_price" value="@if(!empty(session('car_info'))){{session('car_info')->flash_sale_products_price}} @endif" readonly>
                                  </div>
                                </div>

                                <div style="margin-top: 10px;">
                                  <label for="name">{{ trans('labels.FlashSaleDate') }}</label>
                                  <div style="display: flex;">
                                    <input readonly class="form-control" type="text" value="@if(!empty(session('car_info'))){{session('car_info')->flash_start_date}} {{session('car_info')->flash_start_time}} @endif">
                                    <div>
                                      <input type="hidden" class="form-control" name="flash_start_time" id="flash_start_time" value="@if(!empty(session('car_info'))){{session('car_info')->flash_start_time}} @endif">
                                      <input class="form-control" type="hidden" name="flash_start_date" id="flash_start_date" value="@if(!empty(session('car_info'))){{session('car_info')->flash_start_date}} @endif">
                                    </div>
                                  </div>
                                </div>

                                <div style="margin-top: 10px;">
                                  <label for="name">{{ trans('labels.FlashExpireDate') }}</label>
                                  <div style="display: flex;">
                                    <input readonly class="form-control" type="text" value="@if(!empty(session('car_info'))){{session('car_info')->flash_expires_date}} {{session('car_info')->flash_end_time}} @endif">
                                    <div>
                                      <input class="form-control" type="hidden" name="flash_expires_date" id="flash_expires_date" value="@if(!empty(session('car_info'))){{session('car_info')->flash_expires_date}} @endif">
                                      <input type="hidden" class="form-control" name="flash_end_time" id="flash_end_time" value="@if(!empty(session('car_info'))){{session('car_info')->flash_end_time}} @endif">
                                    </div>
                                  </div>                              
                                </div>

                                <div style="margin-top: 10px;">
                                  <label for="name">{{ trans('labels.Status') }}</label>
                                  <div>
                                    <select class="form-control" disabled>
                                      <option value="1" @if(!empty(session('car_info'))) @if(session('car_info')->flash_status == '1') selected @endif @endif>{{ trans('labels.Active') }}</option>
                                      <option value="0" @if(!empty(session('car_info'))) @if(session('car_info')->flash_status == '0') selected @endif @endif>{{ trans('labels.Inactive') }}</option>
                                    </select>
                                    <input type="hidden" class="form-control field-validate" id="flash_status" name="flash_status" value="@if(!empty(session('car_info'))){{session('car_info')->flash_status}}@endif">
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="form-group special-link">
                              <label for="name">{{ trans('labels.Special') }}</label>
                              <div>
                                <select class="form-control" disabled>
                                  <option value="no" @if(!empty(session('car_info'))) @if(session('car_info')->isSpecial == 'no') selected @endif @endif>{{ trans('labels.No') }}</option>
                                  <option value="yes" @if(!empty(session('car_info'))) @if(session('car_info')->isSpecial == 'yes') selected @endif @endif>{{ trans('labels.Yes') }}</option>
                                </select>
                                <input type="hidden" class="form-control field-validate" id="isSpecial" name="isSpecial" value="@if(!empty(session('car_info'))){{session('car_info')->isSpecial}}@endif">
                              </div>                        

                              <div class="special-container" style="display: none; margin-top: 10px;">
                                <div style="margin-top: 10px;">
                                  <label for="name">{{ trans('labels.SpecialPrice') }}</label>
                                  <div>
                                    <input class="form-control" type="text" name="specials_new_products_price" id="special-price" value="@if(!empty(session('car_info'))){{session('car_info')->specials_new_products_price}} @endif" readonly>
                                  </div>
                                </div>

                                <div style="margin-top: 10px;">
                                  <label for="name">{{ trans('labels.ExpiryDate') }}</label>
                                  <div>
                                    <input class="form-control" type="text" name="expires_date" id="expiry-date" value="@if(!empty(session('car_info'))){{session('car_info')->expires_date}} @endif" readonly>
                                  </div>
                                </div>

                                <div style="margin-top: 10px;">
                                  <label for="name">{{ trans('labels.Status') }}</label>
                                  <div>
                                    <select class="form-control" disabled>
                                      <option value="1" @if(!empty(session('car_info'))) @if(session('car_info')->status == '1') selected @endif @endif>{{ trans('labels.Active') }}</option>
                                      <option value="0" @if(!empty(session('car_info'))) @if(session('car_info')->status == '0') selected @endif @endif>{{ trans('labels.Inactive') }}</option>
                                    </select>
                                    <input type="hidden" class="form-control field-validate" id="status" name="status" value="@if(!empty(session('car_info'))){{session('car_info')->status}}@endif">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-7 col-sm-7">
                          @if(!empty(session('images')))
                            @if(count(session('images')) == 1)
                              @foreach(session('images') as $key => $imgs)                            
                                <img src="{{asset('').$imgs['path']}}" alt="" class="for" style="width: 100%;">
                              @endforeach
                            @else
                              @foreach(session('images') as $key => $imgs)                            
                                <div class="col-4 col-sm-4 form-group">
                                  <img src="{{asset('').$imgs['path']}}" alt="" class="for" style="width: 100%;">
                                </div>
                              @endforeach
                            @endif
                          @endif
                        </div>

                      </div>                      

                      <div class="row">
                        <div class="col-12 col-sm-12">
                          <div class="form-group text-right mt-3" style="width:100%">
                            <button type="submit" class="btn btn-secondary">@lang('website.post')</button>                              
                          </div>                        
                        </div>
                      </div>
                      
                    </form>

                  </div>

                </div>
            </div>
          </div>
        </div>

        <div class="col-xl-1">
        </div>   
      </div>
    </div>
  </section>
</section>

<style>
.dropzone.dz-clickable {
    cursor: pointer;
}
.dropzone {
    min-height: 150px;
    border: 2px solid rgba(0, 0, 0, 0.3);
    background: white;
    padding: 20px 20px;
}
.dropzone, .dropzone * {
    box-sizing: border-box;
}
</style>

<link rel="stylesheet" href="{!! asset('web/css/imageuploadify.min.css') !!}">
<link rel="stylesheet" href="{!! asset('web/css/dropzone.css') !!}">

<script src="{!! asset('web/js/imageuploadify.min.js') !!}"></script>
<script src="{!! asset('web/js/dropzone.js') !!}"></script>

<script>
  $('input[type="file"]').imageuploadify();
</script>

<script type="text/javascript">
  $(function() {
    //for multiple languages
    @foreach($result['languages'] as $languages)
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor{{$languages->languages_id}}');
    @endforeach
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });

  function getSubCategories(model_id) {
    console.log(' category_id ====  ' + jQuery('#category_id').val());
    var option = '<option value="" selected disabled>' + '<?php echo Lang::get("website.Select Sub Categories") ?>'  + '</option>';
    $('#sub_category_id').html(option);

    var b_id = model_id;
    var data=<?php echo json_encode($result['categories']) ?>;
    var newdata = data.filter(item => item.categories_id == b_id);
    console.log(newdata);
    $('#category_name').val(newdata[0]['categories_name']);
    $('#sub_category_name').val('');

    if (newdata[0]['childs'] && newdata[0]['childs'].length > 0) {
      for(var i=0; i< newdata[0]['childs'].length; i++){
        option+='<option value="'+newdata[0]['childs'][i]['categories_id']+'">' + newdata[0]['childs'][i]['categories_name'] + '</option>';
      }
    }    
    $('#sub_category_id').html(option);
  }

  function changeSubCategories(sub_cat_id) {
    var cat_id = jQuery('#category_id').val();
    var data=<?php echo json_encode($result['categories']) ?>;
    var newdata = data.filter(item => item.categories_id == cat_id);
    if (newdata.length > 0 && newdata[0]['childs'] && newdata[0]['childs'].length > 0) {
      var subcatsdata = newdata[0]['childs'].filter(item => item.categories_id == sub_cat_id);
      $('#sub_category_name').val(subcatsdata[0]['categories_name']);
    }    
  }
</script>

@endsection