@extends('web.layout')
@section('content')
<section>
  <style>
    a {
      font-size: 11px;
    }
  </style>
  <link href="{!! asset('admin/dist/css/AdminLTE.min.css')  !!} " media="all" rel="stylesheet" type="text/css" />

  <div class="container-fuild">
    <nav aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
          <li class="breadcrumb-item"><a href="{{ URL::to('/getmyproduct')}}">@lang('website.MyProducts')</a></li>
        </ol>
      </div>
    </nav>
  </div>

  <section class="pro-content" style="padding-top: 50px;">
    <div class="container">
      <div class="page-heading-title">
        <h2> @lang('website.MyProducts') </h2>
      </div>
    </div>

    <div class="container" style="padding: 0;">
      <div>
        <div class="box">
          <div class="box-body">

            <div>
              <div>
                @if (count($errors) > 0)
                  @if($errors->any())
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                    {{$errors->first()}}
                  </div>
                  @endif
                @endif

                @if (isset($message))                  
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                    {{$message}}
                  </div>
                @endif
              </div>
            </div>

            <div>
              <div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>@sortablelink('products_id', trans('labels.ID') )</th>
                      <th>{{ trans('labels.Image') }}</th>
                      <th>@sortablelink('categories_name', trans('labels.Category') )</th>
                      <th>@sortablelink('products_name', trans('labels.Name') )</th>
                      <th>{{ trans('labels.Additional info') }}</th>
                      <th>{{ trans('labels.Updated info') }}</th>
                      <th>{{ trans('labels.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($result['products'])>0)
                    @php $resultsProduct = $result['products']->unique('products_id')->keyBy('products_id'); @endphp
                    @foreach ($resultsProduct as $key=>$product)
                    <tr>
                      <td>{{ $product->products_id }}</td>
                      <td><img src="{{asset($product->path)}}" alt="" height="50px"></td>
                      <td>
                        {{ $product->categories_name }}
                      </td>
                      <td>
                        {{ $product->products_name }} @if(!empty($product->products_model)) (
                        {{ $product->products_model }} ) @endif
                      </td>
                      <td>                        
                        @if(!empty($product->manufacturers_name))
                        <strong>{{ trans('labels.Manufacturer') }}:</strong> {{ $product->manufacturers_name }}<br>
                        @endif
                        <strong>{{ trans('labels.Price') }}: </strong>
                        @if(!empty($result['commonContent']['currency']->symbol_left)){{$result['commonContent']['currency']->symbol_left}} @endif {{ $product->products_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                        <br>
                        <strong>{{ trans('labels.Weight') }}: </strong>
                        {{ $product->products_weight }}{{ $product->products_weight_unit }}<br>
                        <strong>{{ trans('labels.Quantity') }}: </strong>  {{ $product->products_quantity }}<br>
                        <strong>{{ trans('labels.Created At') }}: </strong> {{ date('Y-m-d',strtotime($product->productcreated)) }}<br>
                        @if(!empty($product->specials_id))
                        <strong class="badge bg-light-blue">{{ trans('labels.Special Product') }}</strong><br>
                        <strong>{{ trans('labels.SpecialPrice') }}: </strong>
                        {{ $product->specials_products_price }}<br>
                        @endif                      

                        @if($product->products_status == 2)
                        <strong class="badge bg-red">{{ trans('labels.Pending') }}</strong>
                        @endif

                        @if($product->products_status == 1)
                        <strong class="badge bg-green">{{ trans('labels.Approved') }}</strong>
                        @endif

                        @if($product->products_status == 0)
                        <strong class="badge bg-black" style="color: white;">{{ trans('labels.Rejected') }}</strong>
                        @endif
                      </td>
                      <td>
                        @if($product->updated_by_vendor == 1)
                          <strong>{{ trans('labels.Quantity') }}: </strong>  {{ $product->updated_quantity }}<br>
                          
                          @php $imagess = json_decode($product->updated_images); @endphp
                          @if(count($imagess) > 0)
                          <!-- <strong>{{ trans('labels.Images') }}: </strong> -->
                          @foreach($imagess as $img)
                          <img src="{{asset($img->path)}}" alt="" height="50px">
                          @endforeach
                          <br>
                          @endif

                          <strong>{{ trans('labels.Updated At') }}: </strong> {{ date('Y-m-d',strtotime($product->productupdate)) }}<br>

                          @if($product->update_request_status == 2)
                          <strong class="badge bg-red">{{ trans('labels.Pending') }}</strong>
                          @elseif($product->update_request_status == 1)
                          <strong class="badge bg-green">{{ trans('labels.Approved') }}</strong>
                          @elseif($product->update_request_status == 0)
                          <strong class="badge bg-black" style="color: white;">{{ trans('labels.Rejected') }}</strong>
                          @endif
                        @endif
                      </td>

                      <td>                        
                        <a class="btn btn-primary" style="margin-bottom: 5px; font-size: 8px; color: white !important; padding: 8px 10px; width: 115px;" href="{{url('/editproduct')}}/{{ $product->products_id }}">{{ trans('labels.EditProduct') }}</a>
                        </br>                        
                        <a class="btn btn-danger" style="margin-bottom: 5px; font-size: 8px; color: white !important; padding: 8px 10px; width: 115px;" id="deleteProductId" products_id="{{ $product->products_id }}">{{ trans('labels.DeleteProduct') }}</a>
                      </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-xs-12" style="background: #eee;">
              @php

              if($result['products']->total()>0){
                $fromrecord = ($result['products']->currentpage()-1)*$result['products']->perpage()+1;
              }else{
                $fromrecord = 0;
              }

              if($result['products']->total() < $result['products']->currentpage()*$result['products']->perpage()){
                $torecord = $result['products']->total();
              }else{
                $torecord = $result['products']->currentpage()*$result['products']->perpage();
              }

              @endphp
              <div class="col-xs-12 col-md-6" style="padding:30px 15px; border-radius:5px;">
                <div>Showing {{$fromrecord}} to {{$torecord}}
                  of {{$result['products']->total()}} entries
                </div>
              </div>
              <div class="col-xs-12 col-md-6 text-right">
                {{$result['products']->links()}}
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="deleteproductmodal" tabindex="-1" role="dialog"
      aria-labelledby="deleteProductModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="deleteProductModalLabel">{{ trans('labels.DeleteProduct') }}</h4>
          </div>
          {!! Form::open(array('url' =>'/deleteproduct', 'name'=>'deleteProduct', 'id'=>'deleteProduct',
          'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
          {!! Form::hidden('action', 'delete', array('class'=>'form-control')) !!}
          {!! Form::hidden('products_id', '', array('class'=>'form-control', 'id'=>'products_id')) !!}
          <input type="hidden" required name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <div class="modal-body">
            <p>{{ trans('labels.DeleteThisProductDiloge') }}?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
            <button type="submit" class="btn btn-primary"
              id="deleteProduct">{{ trans('labels.DeleteProduct') }}</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>

  </section>

</section>
@endsection