<div class="container-fuild">
  <nav aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>

        @if(!empty($result['category_name']) and !empty($result['sub_category_name']))
        <li class="breadcrumb-item active"><a
            href="{{ URL::to('/shop?category='.$result['category_slug'])}}">{{$result['category_name']}}</a></li>
        <li class="breadcrumb-item active"><a
            href="{{ URL::to('/shop?category='.$result['sub_category_slug'])}}">{{$result['sub_category_name']}}</a>
        </li>
        @elseif(!empty($result['category_name']) and empty($result['sub_category_name']))
        <li class="breadcrumb-item active"><a
            href="{{ URL::to('/shop?category='.$result['category_slug'])}}">{{$result['category_name']}}</a></li>
        @endif
        @if($result['detail']['product_data'])
        <li class="breadcrumb-item active">{{$result['detail']['product_data'][0]->products_name}}</li>
        @endif
      </ol>
    </div>
  </nav>
</div>


<main class="bg_gray">
  <link href="{!! asset('web/css/theme_css/product_page.css') !!}" rel="stylesheet">

  <div class="container margin_30">
    <div class="page_header">      
      <h1>{{$result['detail']['product_data'][0]->products_name}}</h1>
    </div>
    
    <div class="row justify-content-center">
      <div class="col-lg-8" id="carousel-home">
        <div class="owl-carousel owl-theme prod_pics magnific-gallery" style="direction: ltr;">
          <div class="item">
            <a href="{{asset('').$result['detail']['product_data'][0]->default_images }}" title="Photo title" data-effect="mfp-zoom-in"><img
                src="{{asset('').$result['detail']['product_data'][0]->default_images }}" alt="" style="width: 100%;margin-bottom: 10px;"></a>
          </div>
          @foreach( $result['detail']['product_data'][0]->images as $key=>$images )
            @if($images->image_type == 'ACTUAL')
            <div class="item">
              <a href="{{asset('').$images->image_path }}" title="Photo title" data-effect="mfp-zoom-in"><img
                  src="{{asset('').$images->image_path }}" alt="" style="width: 100%;margin-bottom: 10px;"></a>
            </div>            
            @endif
          @endforeach
        </div>        
      </div>
    </div>    
  </div>
  

  <div class="bg_white">
    <div class="container margin_60_35">
      <div class="row justify-content-between">
        <div class="col-lg-6">
          <div class="prod_info version_2">
            <span class="rating">
              @if($result['detail']['product_data'][0]->avarage_rate == 1)
              <i class="icon-star voted"></i>
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              @elseif($result['detail']['product_data'][0]->avarage_rate == 2)
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              @elseif($result['detail']['product_data'][0]->avarage_rate == 3)
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              @elseif($result['detail']['product_data'][0]->avarage_rate == 4)
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              <i class="icon-star"></i>
              @elseif($result['detail']['product_data'][0]->avarage_rate == 5)
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              <i class="icon-star voted"></i>
              @else
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              <i class="icon-star"></i>
              @endif
            <em>{{$result['detail']['product_data'][0]->total_user_rated}} reviews</em>
            </span>

            <p><b>@lang('website.Product ID') : </b>{{$result['detail']['product_data'][0]->products_id}}
            <br>
              <div class="pro-single-info"><b>@lang('website.Categroy') : </b>
                <?php
                  $cates = '';  
                ?>
                @foreach($result['detail']['product_data'][0]->categories as $key=>$category)
                <?php
                  $cates =  "<a href=".url('shop?category='.$category->categories_name).">".$category->categories_name."</a>";
                ?>
                @endforeach
                <?php 
                  echo $cates;
                ?>
              </div>
            </p>
            
            <div class="pro-single-info"><b>@lang('website.Available') : </b>
              @if($result['detail']['product_data'][0]->products_type == 0)
                @if($result['commonContent']['settings']['Inventory'])
                  @if($result['detail']['product_data'][0]->defaultStock < 0) <span class="text-secondary">
                    @lang('website.Out of Stock')</span>
                  @else
                    <span class="text-secondary">@lang('website.In stock')</span>
                  @endif
                @else
                  <span class="text-secondary">@lang('website.In stock')</span>
                @endif
              @endif

              @if($result['detail']['product_data'][0]->products_type == 1)
                <span class="text-secondary variable-stock"></span>
              @endif

              @if($result['detail']['product_data'][0]->products_type == 2)
                <span class="text-secondary">@lang('website.External')</span>
              @endif
            </div>

            <p>
              @if($result['detail']['product_data'][0]->products_min_order>0)
                <div class="pro-single-info" id="min_max_setting3"><b>@lang('website.Min Order Limit') :
                  </b>{{$result['detail']['product_data'][0]->products_min_order}}</div>
              @endif

              <div class="pro-single-info" @if($result['detail']['product_data'][0]->products_max_stock==9999) style="display:none;" @endif id="min_max_setting2"><b>@lang('website.Max Order Limit') :</b>{{$result['detail']['product_data'][0]->products_max_stock}}</div>
            </p>

          </div>
        </div>

        <div class="col-lg-5">
          <div class="prod_options version_2">
            <!-- <div class="row">
              <label class="col-xl-7 col-lg-5  col-md-6 col-6 pt-0"><strong>Color</strong></label>
              <div class="col-xl-5 col-lg-5 col-md-6 col-6 colors">
                <ul>
                  <li><a href="#0" class="color color_1 active"></a></li>
                  <li><a href="#0" class="color color_2"></a></li>
                  <li><a href="#0" class="color color_3"></a></li>
                  <li><a href="#0" class="color color_4"></a></li>
                </ul>
              </div>
            </div>
            <div class="row">
              <label class="col-xl-7 col-lg-5 col-md-6 col-6"><strong>Size</strong> - Size Guide <a href="#0"
                  data-toggle="modal" data-target="#size-modal"><i class="ti-help-alt"></i></a></label>
              <div class="col-xl-5 col-lg-5 col-md-6 col-6">
                <div class="custom-select-form">
                  <select class="wide">
                    <option value="" selected="">Small (S)</option>
                    <option value="">M</option>
                    <option value=" ">L</option>
                    <option value=" ">XL</option>
                  </select>
                </div>
              </div>
            </div> -->

            <form name="attributes" id="add-Product-form" method="post">
              <input type="hidden" name="products_id" value="{{$result['detail']['product_data'][0]->products_id}}">
              
              <input type="hidden" name="products_price" id="products_price"
                  value="@if(!empty($result['detail']['product_data'][0]->flash_price)) {{$result['detail']['product_data'][0]->flash_price+0}} @elseif(!empty($result['detail']['product_data'][0]->discount_price)){{$result['detail']['product_data'][0]->discount_price+0}}@else{{$result['detail']['product_data'][0]->products_price+0}}@endif">

              <input type="hidden" name="checkout" id="checkout_url"
                value="@if(!empty(app('request')->input('checkout'))) {{ app('request')->input('checkout') }} @else false @endif">

              <input type="hidden" id="max_order"
                value="@if(!empty($result['detail']['product_data'][0]->products_max_stock)){{ $result['detail']['product_data'][0]->products_max_stock }}@else 0 @endif">
              
              @if(!empty($result['cart']))
              <input type="hidden" name="customers_basket_id" value="{{$result['cart'][0]->customers_basket_id}}">
              @endif

              <div class="badges" style="margin-bottom: 16px;">

                <?php
                  $current_date = date("Y-m-d", strtotime("now"));

                  $string = substr($result['detail']['product_data'][0]->products_date_added, 0, strpos($result['detail']['product_data'][0]->products_date_added, ' '));
                  $date=date_create($string);
                  date_add($date,date_interval_create_from_date_string($web_setting[20]->value." days"));

                  $after_date = date_format($date,"Y-m-d");

                  if($after_date>=$current_date){
                    print '<span class="ribbon new" style="top: 0px;">';
                    print __('website.New');
                    print '</span>';
                  }
                ?>

                <?php
                $discount_percentage = 0;
                if(!empty($result['detail']['product_data'][0]->discount_price)){
                  $discount_price = $result['detail']['product_data'][0]->discount_price * session('currency_value');
                }
                $orignal_price = $result['detail']['product_data'][0]->products_price * session('currency_value');

                if(!empty($result['detail']['product_data'][0]->discount_price)){

                  if(($orignal_price+0)>0){
                    $discounted_price = $orignal_price-$discount_price;
                    $discount_percentage = $discounted_price/$orignal_price*100;
                  }else{
                    $discount_percentage = 0;
                    $discounted_price = 0;
                  }
                }
                ?>                
                @if($discount_percentage>0)
                  <span class="ribbon off" style="left: 85px;top: 0px;" data-toggle="tooltip" title="<?php echo (int)$discount_percentage; ?>% @lang('website.off')"><?php echo (int)$discount_percentage; ?>%</span>    
                @endif
                
                @if($result['detail']['product_data'][0]->is_feature == 1)
                  <span class="ribbon hot" style="left: 85px;top: 0px;">@lang('website.Featured')</span>
                @endif
                <br>
              </div>


              @if(!empty($result['detail']['product_data'][0]->flash_start_date))
              <div class="countdown pro-timer" style="position: relative; bottom: 1px;" data-toggle="tooltip" data-placement="bottom"
                title="@lang('website.Countdown Timer')"
                id="counter_{{$result['detail']['product_data'][0]->products_id}}">
                <div class='custom_countdown'>0D 00:00:00</div>
              </div>
              @endif

              <div class="pro-counter" style='margin-top: 35px;' @if(!empty($result['detail']['product_data'][0]->flash_start_date) and $result['detail']['product_data'][0]->server_time < $result['detail']['product_data'][0]->flash_start_date ) style="display: none" @endif>              

                <div class="row">
                  <label class="col-xl-7 col-lg-5  col-md-6 col-6" style='font-size: 21px;'><strong>@lang('website.Quantity')</strong></label>
                  <div class="col-xl-5 col-lg-5 col-md-6 col-6">
                    <div class="numbers-row">
                      <input type="text" readonly name="quantity" class="qty2"
                      value="@if(!empty($result['cart'])) {{$result['cart'][0]->customers_basket_quantity}} @else @if($result['detail']['product_data'][0]->products_min_order>0 and $result['detail']['product_data'][0]->defaultStock > $result['detail']['product_data'][0]->products_min_order) {{$result['detail']['product_data'][0]->products_min_order}} @else 1 @endif @endif"
                      min="{{$result['detail']['product_data'][0]->products_min_order}}"
                      max="{{$result['detail']['product_data'][0]->products_max_stock}}">

                      <div class="inc button_inc">+</div>
											<div class="dec button_inc">-</div>
                      
                    </div>
                  </div>
                </div>                

              </div>

              
              <div class="row mt-3">
                <div class="col-lg-7 col-md-6">
                  <?php
                    $discount_price = 0;
                    if(!empty($result['detail']['product_data'][0]->discount_price)){
                      $discount_price = $result['detail']['product_data'][0]->discount_price * session('currency_value');
                    }
                    if(!empty($result['detail']['product_data'][0]->flash_price)){
                      $discount_price = $result['detail']['product_data'][0]->flash_price * session('currency_value');
                    }
                    $orignal_price = $result['detail']['product_data'][0]->products_price * session('currency_value');

                    if($discount_price > 0){
                      if(($orignal_price+0)>0){
                        $discounted_price = $orignal_price - $discount_price;
                        $discount_percentage = $discounted_price / $orignal_price * 100;                        
                      }else{
                        $discount_percentage = 0;
                        $discounted_price = 0;
                      }
                    }
                    else{
                      $discount_percentage = 0;
                      $discounted_price = 0;
                    }
                  ?>

                  <div class="price_main">
                    @if($discounted_price > 0)
                    <span class="new_price">{{Session::get('symbol_left')}}{{$discount_price}}{{Session::get('symbol_right')}}</span>
                    <span class="percentage">-{{(int)$discount_percentage}}% </span>&nbsp;
                    <span class="old_price">{{Session::get('symbol_left')}}{{$orignal_price}}{{Session::get('symbol_right')}}</span>
                    @else
                    <span class="new_price">{{Session::get('symbol_left')}}{{$orignal_price}}{{Session::get('symbol_right')}}</span>
                    @endif
                  </div>
                </div>
                <div class="col-lg-5 col-md-6">
                  <div class="btn_add_to_cart">
                    @if(!empty($result['detail']['product_data'][0]->flash_start_date) and $result['detail']['product_data'][0]->server_time < $result['detail']['product_data'][0]->flash_start_date )

                    @else

                      @if($result['detail']['product_data'][0]->products_type == 0)

                        @if($result['commonContent']['settings']['Inventory'])
                          @if($result['detail']['product_data'][0]->defaultStock <= 0)
                          <button class="btn btn-lg swipe-to-top  btn-danger " type="button">@lang('website.Out of Stock')</button>
                          @else
                          <button class="btn btn-secondary btn-lg swipe-to-top add-to-Cart" type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                          @endif
                        @else
                        <button class="btn btn-secondary btn-lg swipe-to-top add-to-Cart" type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                        @endif

                      @else

                        @if($result['commonContent']['settings']['Inventory'])
                        <button class="btn btn-secondary btn-lg swipe-to-top  add-to-Cart stock-cart" hidden type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                        <button class="btn btn-danger btn btn-lg swipe-to-top  stock-out-cart" hidden type="button">@lang('website.Out of Stock')</button>
                        @else
                        <button class="btn btn-secondary btn-lg swipe-to-top  add-to-Cart" type="button"
                          products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                        @endif
                      @endif

                    @endif

                    @if($result['detail']['product_data'][0]->products_type == 2)
                    <a href="{{$result['detail']['product_data'][0]->products_url}}" target="_blank"
                      class="btn btn-secondary btn-lg swipe-to-top">@lang('website.External Link')</a>
                    @endif
                  </div>
                </div>
              </div>

            </form>

          </div>
        </div>
      </div>
      
    </div>
  </div>
  

  <div class="tabs_product bg_white version_2">
    <div class="container">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab">@lang('website.Descriptions')</a>
        </li>
        <li class="nav-item">
          <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">@lang('website.Reviews')</a>
        </li>
      </ul>
    </div>
  </div>
  

  <div class="tab_content_wrapper">
    <div class="container">
      <div class="tab-content" role="tablist">
        <div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
          
          <div>
            <div class="card-body">
              <div class="row justify-content-between">
                <div class="col-lg-6">
                  <h3>@lang('website.Details')</h3>
                  <p><?=stripslashes($result['detail']['product_data'][0]->products_description)?></p>
                </div>
                <div class="col-lg-5">
                  <h3>@lang('website.Specifications')</h3>
                  <div class="table-responsive">
                    <table class="table table-sm table-striped">
                      <tbody>
                        <!-- <tr>
                          <td><strong>Color</strong></td>
                          <td>Blue, Purple</td>
                        </tr>
                        <tr>
                          <td><strong>Size</strong></td>
                          <td>150x100x100</td>
                        </tr> -->
                        <tr>
                          <td><strong>@lang('website.Weight')</strong></td>
                          <td>{{$result['detail']['product_data'][0]->products_weight}}{{$result['detail']['product_data'][0]->products_weight_unit}}</td>
                        </tr>
                        <tr>
                          <td><strong>@lang('website.Manifacturer')</strong></td>
                          <td>{{$result['detail']['product_data'][0]->manufacturer_name}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        


        <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
          
          <div>
            <div class="card-body">
              <div class="row justify-content-between">
                @if(isset($result['detail']['product_data'][0]->reviewed_customers))
                  @foreach($result['detail']['product_data'][0]->reviewed_customers as $key=>$rev)
                  <div class="col-lg-5">
                    <div class="review_content">
                      <div class="clearfix add_bottom_10">
                        <span class="rating">
                          @if($rev->reviews_rating == 1)
                          <i class="icon-star voted"></i>
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          @elseif($rev->reviews_rating == 2)
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          @elseif($rev->reviews_rating == 3)
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          @elseif($rev->reviews_rating == 4)
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          <i class="icon-star"></i>
                          @elseif($rev->reviews_rating == 5)
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          <i class="icon-star voted"></i>
                          @else
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          <i class="icon-star"></i>
                          @endif
                          <em>{{$rev->reviews_rating}}/5.0</em>
                        </span>
                        <em>Published on {{date("d-M-Y", strtotime($rev->created_at))}}</em>
                      </div>
                      <h4>{{$rev->customers_name}}</h4>
                      <p>{{$rev->reviews_text}}</p>
                    </div>
                  </div>                  
                  @endforeach
                @endif
                
                @if(Auth::guard('customer')->check())
                <div class="write-review custom_reviews">
                  <form id="idForm">
                    {{csrf_field()}}
                    <input value="{{$result['detail']['product_data'][0]->products_id}}" type="hidden"
                      name="products_id">
                    <h2>@lang('website.Write a Review')</h2>
                    <div class="write-review-box">
                      <div class="from-group row mb-3">
                        <div class="col-12"> <label for="inlineFormInputGroup2">@lang('website.Rating')</label>
                        </div>
                        <div class="pro-rating col-12">

                          <fieldset class="ratings">

                            <input type="radio" id="star5" name="rating" value="5" class="rating" />
                            <label class="full fa" for="star5" title="@lang('website.awesome_5_stars')"></label>

                            <input type="radio" id="star4" name="rating" value="4" class="rating" />
                            <label class="full fa" for="star4" title="@lang('website.pretty_good_4_stars')"></label>

                            <input type="radio" id="star3" name="rating" value="3" class="rating" />
                            <label class="full fa" for="star3" title="@lang('website.pretty_good_3_stars')"></label>

                            <input type="radio" id="star2" name="rating" value="2" class="rating" />
                            <label class="full fa" for="star2" title="@lang('website.meh_2_stars')"></label>

                            <input type="radio" id="star1" name="rating" value="1" class="rating" />
                            <label class="full fa" for="star1" title="@lang('website.meh_1_stars')"></label>

                          </fieldset>

                        </div>
                      </div>

                      <div class="from-group row mb-3">
                        <div class="col-12"> <label for="inlineFormInputGroup3">@lang('website.Review')</label>
                        </div>
                        <div class="input-group col-12">
                          <textarea name="reviews_text" id="reviews_text" class="form-control"
                            id="inlineFormInputGroup3" placeholder="@lang('website.Write Your Review')"></textarea>
                        </div>
                      </div>

                      <div class="alert alert-danger" hidden id="review-error" role="alert">
                        @lang('website.Please enter your review')
                      </div>

                      <div class="from-group">
                        <button type="submit" id="review_button" disabled
                          class="btn btn-secondary swipe-to-top">@lang('website.Submit')</button>
                      </div>
                    </div>

                  </form>
                </div>
                @endif
              </div>              
              <!-- <p class="text-right"><a href="leave-review.html" class="btn_1">Leave a review</a></p> -->
            </div>
            
          </div>

        </div>
        
      </div>
      
    </div>
    
  </div>
  

  <div class="bg_white">
    <div class="container margin_60_35">
      <div class="main_title">
        <h2>@lang('website.Related')</h2>
        <span>@lang('website.Products')</span>
        <p>@lang('website.Related Products Text')</p>
      </div>
      <div class="owl-carousel owl-theme products_carousel">        
        @foreach($result['simliar_products']['product_data'] as $key=>$products)
        @if($result['detail']['product_data'][0]->products_id != $products->products_id)
        <div class="item">
          @include('web.common.product')
        </div>
        @endif
        @endforeach
      </div>
      
    </div>
    
  </div>
  
  
  <!-- <div class="modal fade show" id="reviewModal" tabindex="-1" role="dialog" aria-hidden="false">

    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">

          <div class="write-review">
            <form id="idForm">
              {{csrf_field()}}
              <input value="{{$result['detail']['product_data'][0]->products_id}}" type="hidden"
                name="products_id">
              <h2>@lang('website.Write a Review') for {{$result['detail']['product_data'][0]->products_name}}</h2>
              <div class="write-review-box">
                <div class="from-group row mb-3">
                  <div class="col-12"> <label for="inlineFormInputGroup2">@lang('website.Rating')</label>
                  </div>
                  <div class="pro-rating col-12">

                    <fieldset class="ratings">

                      <input type="radio" id="star5" name="rating" value="5" class="rating" />
                      <label class="full fa" for="star5" title="@lang('website.awesome_5_stars')"></label>

                      <input type="radio" id="star4" name="rating" value="4" class="rating" />
                      <label class="full fa" for="star4" title="@lang('website.pretty_good_4_stars')"></label>

                      <input type="radio" id="star3" name="rating" value="3" class="rating" />
                      <label class="full fa" for="star3" title="@lang('website.pretty_good_3_stars')"></label>

                      <input type="radio" id="star2" name="rating" value="2" class="rating" />
                      <label class="full fa" for="star2" title="@lang('website.meh_2_stars')"></label>

                      <input type="radio" id="star1" name="rating" value="1" class="rating" />
                      <label class="full fa" for="star1" title="@lang('website.meh_1_stars')"></label>

                    </fieldset>

                  </div>
                </div>

                <div class="from-group row mb-3">
                  <div class="col-12"> <label for="inlineFormInputGroup3">@lang('website.Review')</label>
                  </div>
                  <div class="input-group col-12">
                    <textarea name="reviews_text" id="reviews_text" class="form-control"
                      id="inlineFormInputGroup3" placeholder="@lang('website.Write Your Review')"></textarea>
                  </div>
                </div>

                <div class="alert alert-danger" hidden id="review-error" role="alert">
                  @lang('website.Please enter your review')
                </div>

                <div class="from-group">
                  <button type="submit" id="review_button" disabled
                    class="btn btn-secondary swipe-to-top">@lang('website.Submit')</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div> -->

</main>


<script>

  jQuery(document).ready(function(e) {
  
    @if(!empty($result['detail']['product_data'][0]->flash_start_date))
        @if( date("Y-m-d",$result['detail']['product_data'][0]->server_time) >= date("Y-m-d",$result['detail']['product_data'][0]->flash_start_date))
        var product_div_{{$result['detail']['product_data'][0]->products_id}} = 'product_div_{{$result['detail']['product_data'][0]->products_id}}';
      var  counter_id_{{$result['detail']['product_data'][0]->products_id}} = 'counter_{{$result['detail']['product_data'][0]->products_id}}';
      var inputTime_{{$result['detail']['product_data'][0]->products_id}} = "{{date('M d, Y H:i:s' ,$result['detail']['product_data'][0]->flash_expires_date)}}";
  
      // Set the date we're counting down to
      var countDownDate_{{$result['detail']['product_data'][0]->products_id}} = new Date(inputTime_{{$result['detail']['product_data'][0]->products_id}}).getTime();
  
      // Update the count down every 1 second
      var x_{{$result['detail']['product_data'][0]->products_id}} = setInterval(function() {
  
        // Get todays date and time
        var now = new Date().getTime();
  
        // Find the distance between now and the count down date
        var distance_{{$result['detail']['product_data'][0]->products_id}} = countDownDate_{{$result['detail']['product_data'][0]->products_id}} - now;
  
        // Time calculations for days, hours, minutes and seconds
        var days_{{$result['detail']['product_data'][0]->products_id}} = Math.floor(distance_{{$result['detail']['product_data'][0]->products_id}} / (1000 * 60 * 60 * 24));    

        var hours_{{$result['detail']['product_data'][0]->products_id}} = Math.floor((distance_{{$result['detail']['product_data'][0]->products_id}} % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        if (hours_{{$result['detail']['product_data'][0]->products_id}} < 10) hours_{{$result['detail']['product_data'][0]->products_id}} = '0' + hours_{{$result['detail']['product_data'][0]->products_id}};

        var minutes_{{$result['detail']['product_data'][0]->products_id}} = Math.floor((distance_{{$result['detail']['product_data'][0]->products_id}} % (1000 * 60 * 60)) / (1000 * 60));
        if (minutes_{{$result['detail']['product_data'][0]->products_id}} < 10) minutes_{{$result['detail']['product_data'][0]->products_id}} = '0' + minutes_{{$result['detail']['product_data'][0]->products_id}};

        var seconds_{{$result['detail']['product_data'][0]->products_id}} = Math.floor((distance_{{$result['detail']['product_data'][0]->products_id}} % (1000 * 60)) / 1000);
        if (seconds_{{$result['detail']['product_data'][0]->products_id}} < 10) seconds_{{$result['detail']['product_data'][0]->products_id}} = '0' + seconds_{{$result['detail']['product_data'][0]->products_id}};

        var days_text = "@lang('website.Days')";
        // Display the result in the element with id="demo"

        // document.getElementById(counter_id_{{$result['detail']['product_data'][0]->products_id}}).innerHTML = "<span class='days'>"+days_{{$result['detail']['product_data'][0]->products_id}} + "<small>@lang('website.Days')</small></span> <span class='hours'>" + hours_{{$result['detail']['product_data'][0]->products_id}} + "<small>@lang('website.Hours')</small></span> <span class='mintues'> "
        // + minutes_{{$result['detail']['product_data'][0]->products_id}} + "<small>@lang('website.Minutes')</small></span> <span class='seconds'>" + seconds_{{$result['detail']['product_data'][0]->products_id}} + "<small>@lang('website.Seconds')</small></span> ";

        document.getElementById(counter_id_{{$result['detail']['product_data'][0]->products_id}}).innerHTML = "<div class='custom_countdown'>"+days_{{$result['detail']['product_data'][0]->products_id}} + "D " + hours_{{$result['detail']['product_data'][0]->products_id}} + ":" + minutes_{{$result['detail']['product_data'][0]->products_id}} + ":" + seconds_{{$result['detail']['product_data'][0]->products_id}} + "</div>";
  
        // If the count down is finished, write some text
        if (distance_{{$result['detail']['product_data'][0]->products_id}} < 0) {
        clearInterval(x_{{$result['detail']['product_data'][0]->products_id}});
        //document.getElementById(counter_id_{{$result['detail']['product_data'][0]->products_id}}).innerHTML = "EXPIRED";
        document.getElementById('product_div_{{$result['detail']['product_data'][0]->products_id}}').remove();
        }
      }, 1000);
          @endif
      @endif

  });
</script>