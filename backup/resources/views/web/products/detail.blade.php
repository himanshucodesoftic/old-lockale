@extends('web.layout')
@section('content')

<!-- checkout Content -->
<section class="checkout-area"> 

  <div class="container-fuild">
    <nav aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
          <li class="breadcrumb-item"><a href="{{ URL::to('/getmyproduct')}}">@lang('website.MyProducts')</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)">@lang('website.EditProduct')</a></li>          
        </ol>
      </div>
    </nav>
  </div>

  <section class="pro-content" style="padding-top: 50px; padding-bottom: 50px;">

    <div class="container">
      <div class="page-heading-title">
        <h2> @lang('website.EditProduct') </h2><span>(You can update quantity and image only)</span>
      </div>
    </div>
  
    <section class="checkout-area">
      <div class="container">
        <div class="row">          
          <div class="col-12 col-xl-6 checkout-left">            

            <div class="row">
              <div class="checkout-module">

                <div class="tab-content" id="pills-tabContent">

                  <div class="tab-pane fade show active" id="pills-shipping" role="tabpanel" aria-labelledby="pills-shipping-tab">
                    <form name="signup" enctype="multipart/form-data" action="{{ URL::to('/updateproduct')}}" method="post">
                      <input type="hidden" required name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <input type="hidden" required name="products_id" id="products_id" value="{{$result['products_detail'][0]->products_id}}" />

                      <div class="form-row">
                        <div class="form-group">
                          <label for=""> @lang('website.Product Name') (@lang('website.English'))<span style="color:red;">*</span></label>
                          <input type="text" class="form-control field-validate" id="products_name_1" name="products_name_1" value="{{$result['products_detail'][0]->products_name}}" aria-describedby="NameHelp1" placeholder="" readonly="true">
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter car name')</span>
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('website.Product Name') (@lang('website.Arabic'))<span style="color:red;">*</span></label>
                          <input type="text" class="form-control field-validate" id="products_name_2" name="products_name_2" value="{{$result['products_detail'][1]->products_name}}" aria-describedby="NameHelp1" placeholder="" readonly="true">
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter car name')</span>
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('website.Categories')<span style="color:red;">*</span></label>
                          <div class="input-group select-control">
                            <select required class="form-control field-validate" id="category_id" name="category_id" type="button" disabled="true">
                              <option value="" selected disabled>@lang('website.Select Categories')</option>
                              @if(!empty($result['categories']))
                                @foreach($result['categories'] as $brand)
                                  <option value="{{$brand->categories_id}}" @if($result['products_detail'][0]->categories_id == $brand->categories_id) selected @endif>{{$brand->categories_name}}</option>
                                @endforeach
                              @endif
                            </select>
                          </div>
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please select category')</span>
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('labels.IsFeature')</label>
                          <div class="input-group select-control">
                            <select class="form-control" name="is_feature" type="button" disabled="true">
                              <option value="0" @if($result['products_detail'][0]->is_feature == '0') selected @endif>{{ trans('labels.No') }}</option>
                              <option value="1" @if($result['products_detail'][0]->is_feature == '1') selected @endif>{{ trans('labels.Yes') }}</option>
                            </select>
                          </div>
                          <small id="stateHelp" class="form-text text-muted"></small>
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('website.Price')<span style="color:red;">*</span></label>
                          <input required type="number" class="form-control field-validate" id="price" name="price" value="{{$result['products_detail'][0]->products_price}}" placeholder="" readonly="true">
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter price')</span>
                        </div>                        

                        <!-- <div class="form-group">
                          <label for="name">{{ trans('labels.Max Order Limit') }}<span style="color:red;">*</span></label>
                          <div>                            
                            <input type="text" class="form-control field-validate" id="products_max_stock" name="products_max_stock" value="{{$result['products_detail'][0]->products_max_stock}}" aria-describedby="NameHelp1" placeholder="">
                          </div>
                        </div> -->

                        <input type="hidden" class="form-control field-validate" id="products_max_stock" name="products_max_stock" value="{{$result['products_detail'][0]->products_max_stock}}" aria-describedby="NameHelp1" placeholder="">

                        <div class="form-group">
                          <label for="name">{{ trans('labels.ProductsQuantity') }}<span style="color:red;">*</span></label>
                          <div>                            
                            <input type="text" class="form-control field-validate" id="products_quantity" name="products_quantity" value="{{$result['products_detail'][0]->products_quantity}}" aria-describedby="NameHelp1" placeholder="">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="name">{{ trans('labels.ProductsWeight') }}<span style="color:red;">*</span></label>
                          <div>                            
                            <input type="number" class="form-control field-validate number-validate" id="products_weight" name="products_weight" value="{{$result['products_detail'][0]->products_weight}}" aria-describedby="NameHelp1" placeholder="" readonly="true">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for=""> @lang('website.Unit')</label>
                          <div class="input-group select-control">
                            <select class="form-control" name="products_weight_unit" type="button" disabled>
                              <option value="gm">Gm</option>
                            </select>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label for="name">{{ trans('labels.Description') }} (@lang('website.English'))</label>
                          <div>
                            <textarea class="form-control" rows="5" readonly>{{$result['products_detail'][0]->products_description}}</textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="name">{{ trans('labels.Description') }} (@lang('website.Arabic'))</label>
                          <div>
                            <textarea class="form-control" rows="5" readonly>{{$result['products_detail'][1]->products_description}}</textarea>
                          </div>
                        </div>
                        
                      </div>

                      <hr>
                      <div class="form-row" style="display: block; margin-top: 5%;">
                        <div class="form-group">
                          <button type="submit"  class="btn swipe-to-top btn-secondary">@lang('website.Update')</button>
                        </div>
                      </div>                     
                        
                    </form>
                  </div>
                </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-xl-6">
          <div class="tab-pane fade show active"  id="pills-billing" role="tabpanel" aria-labelledby="pills-billing-tab">
            <div class="">
              <div>
                <div class="col-7 col-sm-7">
                  <a href="{{asset('').$result['products_detail'][0]->path }}" title="Photo title" data-effect="mfp-zoom-in"><img src="{{asset('').$result['products_detail'][0]->path }}" alt="" style="width: 100%;"></a>
                </div>
                @foreach( $result['product_images'] as $key=>$images )
                  <div class="col-4 col-sm-4">
                    <a href="{{asset('').$images->image_path }}" title="Photo title" data-effect="mfp-zoom-in">
                      <img src="{{asset('').$images->image_path }}" alt="" style="width: 100%;"></a>
                  </div>
                @endforeach
              </div>
              <br>

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
              </div>
            </div>
          </div>
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


@endsection