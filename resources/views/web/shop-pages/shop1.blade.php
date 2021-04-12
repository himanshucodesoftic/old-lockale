  <!-- Shop Page One content -->
  <div class="container-fuild">
    <nav aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          @if(!empty($result['category_name']) and !empty($result['sub_category_name']))
          <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
          <li class="breadcrumb-item"><a href="{{ URL::to('/shop')}}">@lang('website.Shop')</a></li>
          <li class="breadcrumb-item"><a
              href="{{ URL::to('/shop?category='.$result['category_slug'])}}">{{$result['category_name']}}</a></li>
          <li class="breadcrumb-item active">{{$result['sub_category_name']}}</li>
          @elseif(!empty($result['category_name']) and empty($result['sub_category_name']))
          <li class="breadcrumb-item active">{{$result['category_name']}}</li>
          @else
          <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
          <li class="breadcrumb-item active">@lang('website.Shop')</li>
          @endif
        </ol>
      </div>
    </nav>
  </div>




  <!-- <div id="stick_here"></div> -->
  <section class="pro-content" style="padding-bottom: 50px;">
    <div class="container">
      <div class="page-heading-title">
        <h2> @lang('website.Shop')
        </h2>

      </div>
    </div>

    <section class="shop-content shop-two">

      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-3  d-lg-block d-xl-block right-menu" id="sidebar_fixed">
            <div class="filter_col">
            <div class="inner_bt"><a href="#" class="open_filters"><i class="ti-close"></i></a></div>

            <div class="right-menu-categories">
              @include('web.common.shopCategories')
              @php shopCategories(); @endphp
            </div>

            {{-- Hide filters if record does not exist --}}


            @if(!empty($result['categories']))
            <form enctype="multipart/form-data" name="filters" id="test" method="get">
              <input type="hidden" name="min_price" id="min_price" value="0">
              <input type="hidden" name="max_price" id="max_price" value="{{$result['filters']['maxPrice']}}">
              <input type="hidden" name="price" id="price" value="0">
              @if(app('request')->input('category'))
              <input type="hidden" name="category" value="{{app('request')->input('category')}}">
              @endif
              @if(app('request')->input('filters_applied')==1)
              <input type="hidden" name="filters_applied" id="filters_applied" value="1">
              <input type="hidden" name="options" id="options"
                value="<?php echo implode(',',$result['filter_attribute']['options'])?>">
              <input type="hidden" name="options_value" id="options_value"
                value="<?php echo implode(',' , $result['filter_attribute']['option_values'])?>">
              @else
              <input type="hidden" name="filters_applied" id="filters_applied" value="0">
              @endif              

              <div class="filter_type version_2" style="border: 1px solid #ededed; margin: 20px 0px 15px 0px; padding: 0 15px;">
								<h4><a style="padding: 13px 6px 6px; margin: 0px 0px 0 0px;">@lang('website.Price')</a></h4>
								<div id="filter_4">
									<ul>
										<li>
											<label class="container_check">{{Session::get('symbol_left')}}0{{Session::get('symbol_right')}} — {{Session::get('symbol_left')}}50{{Session::get('symbol_right')}}
												<input type="checkbox" value="0;50" onchange="changePriceRank(this)">
												<span class="checkmark"></span>
											</label>
										</li>
                    @if($result['filters']['maxPrice'] >= 100)
										<li>
											<label class="container_check">{{Session::get('symbol_left')}}50{{Session::get('symbol_right')}} — {{Session::get('symbol_left')}}100{{Session::get('symbol_right')}}
												<input type="checkbox" value="50;100" onchange="changePriceRank(this)">
												<span class="checkmark"></span>
											</label>
										</li>
                    @endif
										@if($result['filters']['maxPrice'] >= 200)
										<li>
											<label class="container_check">{{Session::get('symbol_left')}}100{{Session::get('symbol_right')}} — {{Session::get('symbol_left')}}200{{Session::get('symbol_right')}}
												<input type="checkbox" value="100;200" onchange="changePriceRank(this)">
												<span class="checkmark"></span>
											</label>
										</li>
                    @else
                    <li>
											<label class="container_check">{{Session::get('symbol_left')}}100{{Session::get('symbol_right')}} — {{Session::get('symbol_left')}}{{$result['filters']['maxPrice']}}{{Session::get('symbol_right')}}
												<input type="checkbox" value="100;{{$result['filters']['maxPrice']}}" onchange="changePriceRank(this)">
												<span class="checkmark"></span>
											</label>
										</li>
                    @endif
                    @if($result['filters']['maxPrice'] >= 300)
										<li>
											<label class="container_check">{{Session::get('symbol_left')}}200{{Session::get('symbol_right')}} — {{Session::get('symbol_left')}}300{{Session::get('symbol_right')}}
												<input type="checkbox" value="200;300" onchange="changePriceRank(this)">
												<span class="checkmark"></span>
											</label>
										</li>
                    @else
                    <li>
											<label class="container_check">{{Session::get('symbol_left')}}200{{Session::get('symbol_right')}} — {{Session::get('symbol_left')}}{{$result['filters']['maxPrice']}}{{Session::get('symbol_right')}}
												<input type="checkbox" value="200;{{$result['filters']['maxPrice']}}" onchange="changePriceRank(this)">
												<span class="checkmark"></span>
											</label>
										</li>
                    @endif
                    @if($result['filters']['maxPrice'] > 300)
										<li>
											<label class="container_check">{{Session::get('symbol_left')}}300{{Session::get('symbol_right')}} — {{Session::get('symbol_left')}}{{$result['filters']['maxPrice']}}{{Session::get('symbol_right')}}
												<input type="checkbox" value="300;{{$result['filters']['maxPrice']}}" onchange="changePriceRank(this)">
												<span class="checkmark"></span>
											</label>
										</li>
                    @endif
									</ul>
								</div>
							</div>

              @include('web.common.scripts.slider')

              @if(count($result['filters']['attr_data'])>0)
                @foreach($result['filters']['attr_data'] as $key=>$attr_data)
                <div class="color-range-main">
                  <h1 @if(count($result['filters']['attr_data'])==$key+1) last @endif>{{$attr_data['option']['name']}}
                  </h1>
                  <div class="block">
                    <div class="card-body">
                      <ul class="list" style="list-style:none; padding: 0px;">
                        @foreach($attr_data['values'] as $key=>$values)
                        <li>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input filters_box" name="{{$attr_data['option']['name']}}[]"
                                type="checkbox" value="{{$values['value']}}" <?php
                                if(!empty($result['filter_attribute']['option_values']) and in_array($values['value_id'],$result['filter_attribute']['option_values'])) print 'checked';
                                ?>>
                              {{$values['value']}}
                            </label>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
                @endforeach
              @endif

              <div class="color-range-main">

                <div class="alret alert-danger" id="filter_required">
                </div>

                <div class="button" style="text-align: center;">
                  <?php
                    $url = '';
                          if(isset($_REQUEST['category'])){
                      $url = "?category=".$_REQUEST['category'];
                      $sign = '&';
                    }else{
                      $sign = '?';
                    }
                    if(isset($_REQUEST['search'])){
                      $url.= $sign."search=".$_REQUEST['search'];
                    }
                  ?>

                  <a href="{{ URL::to('/shop')}}" class="btn btn-dark" id="apply_options"> @lang('website.Reset') </a>
                  @if(app('request')->input('filters_applied')==1)
                  <button type="button" class="btn btn-secondary" id="apply_options_btn">
                    @lang('website.Apply')</button>
                  @else
                  <button type="button" class="btn btn-secondary" id="apply_options_btn">
                    @lang('website.Apply')</button>
                  @endif
                </div>

              </div>
            </form>
            @endif


            @if(!empty($result['commonContent']['manufacturers']) and count($result['commonContent']['manufacturers'])>0)
            <div class="range-slider-main" style='margin-bottom: 30px;'>
              <a class=" main-manu" data-toggle="collapse" href="#brands" role="button" aria-expanded="false"
                aria-controls="men-cloth">
                @lang('website.Brands')
              </a>
              
              <div id="brands" style="margin-top: 13px;">
                <ul class="unorder-list">
                  @foreach($result['commonContent']['manufacturers'] as $item)
                  <li class="list-item">
                    <a class="brands-btn list-item" href="{{ URL::to('/shop?brand='.$item->manufacturer_name)}}"
                      role="button">{{$item->manufacturer_name}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
            @endif
            </div>
          </div>

          <div class="col-12 col-lg-9">
            <!-- /top_banner -->
            @if($result['products']['success']==1)
            <form id="load_products_form">
              
            <div id="stick_here"></div>
						<div class="toolbox elemento_stick add_bottom_30">
							<div class="container">
								<ul class="clearfix">
									<li>
                    <div class="form-inline justify-content-end"><!-- form -->
                      <div class="form-group">
                        <label>@lang('website.Sort')</label>
                        <div class="select-control">
                          <select name="type" id="sortbytype" class="form-control"
                          style="padding: 0 5px; border: none; width: 62px; height: 23px; background: transparent; font-size: 13px;">
                            <option value="desc" @if(app('request')->input('type')=='desc') selected
                              @endif>@lang('website.Newest')</option>
                            <option value="atoz" @if(app('request')->input('type')=='atoz') selected
                              @endif>@lang('website.A - Z')</option>
                            <option value="ztoa" @if(app('request')->input('type')=='ztoa') selected
                              @endif>@lang('website.Z - A')</option>
                            <option value="hightolow" @if(app('request')->input('type')=='hightolow') selected
                              @endif>@lang('website.Price: High To Low')</option>
                            <option value="lowtohigh" @if(app('request')->input('type')=='lowtohigh') selected
                              @endif>@lang('website.Price: Low To High')</option>
                            <option value="topseller" @if(app('request')->input('type')=='topseller') selected
                              @endif>@lang('website.Top Seller')</option>
                            <option value="special" @if(app('request')->input('type')=='special') selected
                              @endif>@lang('website.Special Products')</option>
                            <option value="mostliked" @if(app('request')->input('type')=='mostliked') selected
                              @endif>@lang('website.Most Liked')</option>
                          </select>
                        </div>
                      </div>
                      &nbsp;&nbsp;

                      <div class="form-group">
                        <label>@lang('website.Limit')</label>
                        <div class="select-control">
                          <select class="form-control" name="limit" id="sortbylimit"
                          style="padding: 0 5px; border: none; width: 35px; height: 23px; background: transparent;font-size: 13px;">
                            <option value="15" @if(app('request')->input('limit')=='15') selected @endif>15
                            </option>
                            <option value="30" @if(app('request')->input('limit')=='30') selected @endif>30
                            </option>
                            <option value="60" @if(app('request')->input('limit')=='60') selected @endif>60
                            </option>
                          </select>
                        </div>
                      </div>
                    </div>
									</li>

									<li>
										<a href="javascript:void(0);" id="grid"><i class="ti-view-grid"></i></a>
										<a href="javascript:void(0);" id="list"><i class="ti-view-list"></i></a>
									</li>

									<li>
										<a href="#0" class="open_filters">
											<i class="ti-filter"></i><span>Filters</span>
										</a>
									</li>
								</ul>
							</div>
						</div>

            <div class="products-area">
              <div>
                <div class="row">
                  <div class="col-12 col-lg-12">
                    <div class="row align-items-center">
                      <div class="col-12 col-lg-6">                        
                      </div>

                      <div class="col-12 col-lg-6">
                        <div><!-- form -->
                          <input type="hidden" name="min_price" value="0">
                          <input type="hidden" name="max_price" value="{{$result['filters']['maxPrice']}}">
                          @if(isset($_GET['price']))
                          <input type="hidden" name="price" value="{{ $_GET['price'] }}">
                          @endif
                          <input type="hidden" value="1" name="page_number" id="page_number">
                          @if(!empty(app('request')->input('search')))
                          <input type="hidden" name="search" value="{{ app('request')->input('search') }}">
                          @endif
                          @if(!empty(app('request')->input('category')))
                          <input type="hidden" name="category"
                            value="@if(app('request')->input('category')!='all'){{ app('request')->input('category') }} @endif">
                          @endif

                          <input type="hidden" name="load_products" value="1">
                          <input type="hidden" name="products_style" id="products_style" value="grid">
                        </div><!-- remove -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <section id="swap" class="shop-content">
                <div class="products-area">
                  <div class="row">
                    @if($result['categories_status'] == 1)
                      @foreach($result['products']['product_data'] as $key=>$products)

                      <?php 
                        $is_status = false;
                        if(!empty($products->categories)){
                          foreach($products->categories as $key=>$category){
                              if($category->categories_status == 1)
                                $is_status = true;                                         
                          } 
                        }
                        
                        if($is_status == true){
                      ?>

                        <div class="col-12 col-lg-4 col-sm-6 griding">
                          @include('web.common.product')
                        </div>
                      <?php }?>

                      @endforeach
                    @else
                    <div class="col-12 col-lg-4 col-sm-6 griding">
                      <br>
                      <h3>@lang('website.No Record Found!')</h3>
                    </div>
                    @endif

                    @include('web.common.scripts.addToCompare')

                  </div>
                </div>
              </section>
            </div>

            @if($result['categories_status'] == 1)
            <div class="pagination justify-content-between" style="padding: 16px 25px;">
              <input id="record_limit" type="hidden" value="{{$result['limit']}}">
              <input id="total_record" type="hidden" value="{{$result['products']['total_record']}}">
              <label for="staticEmail" class="col-form-label" style='display: flex; width: 50%; float: left;'> @lang('website.Showing')&nbsp;
              <span class="showing_record">{{$result['limit']}}</span>&nbsp;@lang('website.of')&nbsp;
              <span class="showing_total_record">{{$result['products']['total_record']}}</span>
                &nbsp;@lang('website.results')</label>

              <div class=" justify-content-end">

                <?php
                  if(!empty(app('request')->input('limit'))){
                      $record = app('request')->input('limit');
                  }else{
                      $record = '15';
                  }
                ?>
                <button class="btn btn-dark" type="button" id="load_products" @if(count($result['products']['product_data']) < $record ) style="display:none" @endif>@lang('website.Load More')</button>
              </div>
            </div>
            @endif
            @else
            <h3>@lang('website.No Record Found!')</h3>
            @endif
            </form>

          </div>

        </div>
      </div>

      @include('web.common.scripts.shop_page_load_products')

      <script>
        var priceRank = [];
        function changePriceRank(obj) {
          var val = $(obj).val();        
          if ($(obj).is(":checked")) {
            priceRank.push(val);
          } else {
            const index = priceRank.indexOf(val);
            if (index > -1) {
              priceRank.splice(index, 1);
            }
          }        
          
          var eachPrice = []
          if (priceRank.length > 0) {
            priceRank.forEach(element => {            
              element.split(";").forEach(ele => {
                eachPrice.push(Number(ele));
              });
            });
          }
          eachPrice.sort((a,b) => {
            if (a > b) return 1;
            else if (a < b) return -1;
            else return 0;
          });
          console.log(eachPrice);
          if (eachPrice.length > 0) {
            $('#price').val(Math.min.apply(Math, eachPrice) + ';' + Math.max.apply(Math, eachPrice));
          } else {
            $('#price').val('');
          }        
        }

        $('.dropdown-cart, .dropdown-access').hover(function () {
          $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn(300);
        }, function () {
          $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeOut(300);
        });

        $('a.open_filters').on("click", function () {
          $('.filter_col').toggleClass('show');
          $('main').toggleClass('freeze');
          $('.layer').toggleClass('layer-is-visible');
        });
      </script>

      <style>
        .select-control::before {
          bottom: -2px;
          right: 0px;
        }
        .btn {
          padding: 0.6rem 1.7rem;
        }       
      </style>
      
    </section>    
    
  </section>