@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Products') }} <small>{{ trans('labels.ListingAllProducts') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.Products') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">

                            <div CLASS="col-lg-12"> <h7 style="font-weight: bold; padding:0px 16px; float: left;">{{ trans('labels.FilterByCategory/Products') }}:</h7>

                                <br>
                           <div class="col-lg-10 form-inline">

                                <form  name='registration' id="registration" class="registration" method="get">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                    <div class="input-group-form search-panel ">
                                        <select id="FilterBy" type="button" class="btn btn-default dropdown-toggle form-control input-group-form " data-toggle="dropdown" name="categories_id">

                                            <option value="" selected disabled hidden>{{trans('labels.ChooseCategory')}}</option>
                                            @foreach ($results['subCategories'] as  $key=>$subCategories)
                                                <option value="{{ $subCategories->id }}"
                                                        @if(isset($_REQUEST['categories_id']) and !empty($_REQUEST['categories_id']))
                                                          @if( $subCategories->id == $_REQUEST['categories_id'])
                                                            selected
                                                          @endif
                                                        @endif
                                                >{{ $subCategories->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control input-group-form " name="product" placeholder="Search term..." id="parameter"  @if(isset($product)) value="{{$product}}" @endif />
                                        <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                        @if(isset($product,$categories_id))  <a class="btn btn-danger " href="{{url('admin/products/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                    </div>
                                </form>
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/products/add') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                            </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@sortablelink('products_id', trans('labels.ID') )</th>
                                            <th>{{ trans('labels.Image') }}</th>
                                            <th>@sortablelink('categories_name', trans('labels.Category') )</th>
                                            <th>@sortablelink('products_name', trans('labels.Name') )</th>
                                            <th>{{ trans('labels.Additional info') }}</th>
                                            <th>{{ trans('labels.Updated info') }}</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($results['products'])>0)
                                            @php  $resultsProduct = $results['products']->unique('products_id')->keyBy('products_id');  @endphp
                                            @foreach ($resultsProduct as  $key=>$product)
                                                <tr>
                                                    <td>{{ $product->products_id }}</td>
                                                    <td><img src="{{asset($product->path)}}" alt="" height="50px"></td>
                                                    <td>
                                                        {{ $product->categories_name }}
                                                    </td>
                                                    <td>
                                                        {{ $product->products_name }} @if(!empty($product->products_model)) ( {{ $product->products_model }} ) @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ trans('labels.Product Type') }}:</strong>
                                                        @if($product->products_type==0)
                                                            {{ trans('labels.Simple') }}
                                                        @elseif($product->products_type==1)
                                                            {{ trans('labels.Variable') }}
                                                        @elseif($product->products_type==2)
                                                            {{ trans('labels.External') }}
                                                        @endif
                                                        <br>
                                                        @if(!empty($product->manufacturers_name))
                                                            <strong>{{ trans('labels.Manufacturer') }}:</strong> {{ $product->manufacturers_name }}<br>
                                                        @endif
                                                        <strong>{{ trans('labels.Price') }}: </strong>   
                                                        @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $product->products_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                                                        <br>
                                                        <strong>{{ trans('labels.Weight') }}: </strong>  {{ $product->products_weight }}{{ $product->products_weight_unit }}<br>
                                                        <strong>{{ trans('labels.Quantity') }}: </strong>  {{ $product->products_quantity }}<br>
                                                        
                                                        <strong>{{ trans('labels.Created At') }}: </strong> {{ date('Y-m-d',strtotime($product->productcreate)) }}<br>

                                                        <strong>{{ trans('labels.Viewed') }}: </strong>  {{ $product->products_viewed }}<br>

                                                        @if(!empty($product->specials_id))
                                                            <strong class="badge bg-light-blue">{{ trans('labels.Special Product') }}</strong><br>
                                                            <strong>{{ trans('labels.SpecialPrice') }}: </strong>  {{ $product->specials_products_price }}<br>

                                                            @if(($product->specials_id) !== null)
                                                                @php  $mytime = Carbon\Carbon::now()  @endphp
                                                                <strong>{{ trans('labels.ExpiryDate') }}: </strong>

                                                                {{-- @if($product->expires_date > $mytime->toDateTimeString()) --}}
                                                                    {{  date('d-m-Y', $product->expires_date) }}
                                                                {{-- @else
                                                                    <strong class="badge bg-red">{{ trans('labels.Expired') }}</strong>
                                                                @endif --}}
                                                                <br>
                                                            @endif
                                                        @endif

                                                        @if($product->products_status == 2)
                                                            <strong class="badge bg-green">{{ trans('labels.new') }}</strong>
                                                        @endif

                                                        @if($product->products_status == 0)
                                                            <strong class="badge bg-black" style="color: white;">{{ trans('labels.Rejected') }}</strong>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($product->updated_quantity))
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
                                                        @if($product->products_status == 2)
                                                            <a class="btn btn-primary" style="width: 100%;  margin-bottom: 5px;" href="{{url('admin/products/detail')}}/{{ $product->products_id }}">{{ trans('labels.View Detail') }}</a>
                                                            </br>
                                                            <!-- <a class="btn btn-success" style="width: 100%; margin-bottom: 5px;" href="#" onclick="publishcar({{$product->products_id}})">{{ trans('labels.PublishProduct') }}</a>
                                                            </br> -->
                                                            <a class="btn btn-danger" style="width: 100%;  margin-bottom: 5px;" href="#" onclick="decline({{$product->products_id}})">{{ trans('labels.DeclineProduct') }}</a>
                                                            </br>
                                                        @elseif($product->update_request_status == 2)
                                                            <a class="btn btn-primary" style="width: 100%;  margin-bottom: 5px;" href="{{url('admin/products/detail')}}/{{ $product->products_id }}">{{ trans('labels.View Detail') }}</a>
                                                            </br>
                                                            <a class="btn btn-success" style="width: 100%; margin-bottom: 5px;" href="#" onclick="acceptchange({{$product->products_id}})">{{ trans('labels.Accept') }}</a>
                                                            </br>
                                                            <a class="btn btn-danger" style="width: 100%;  margin-bottom: 5px;" href="#" onclick="declinechange({{$product->products_id}})">{{ trans('labels.Decline') }}</a>
                                                            </br>
                                                        @else
                                                            
                                                            <a class="btn btn-primary" style="width: 100%; margin-bottom: 5px;" href="{{url('admin/products/edit')}}/{{ $product->products_id }}">{{ trans('labels.EditProduct') }}</a>
                                                            </br>
                                                            <a class="btn btn-warning" style="width: 100%;  margin-bottom: 5px;" href="{{url('admin/products/images/display/'. $product->products_id) }}">{{ trans('labels.ProductImages') }}</a>
                                                            </br>
                                                           
                                                            <!--<a class="btn btn-primary" style="width: 100%;  margin-bottom: 5px;" href="{{url('admin/products/detail')}}/{{ $product->products_id }}">{{ trans('labels.View Detail') }}</a>-->
                                                            <!--</br>-->
                                                            

                                                            <!--@if($product->products_type==1)-->
                                                            <!--    <a class="btn btn-info" style="width: 100%;  margin-bottom: 5px;" href="{{url('admin/products/attach/attribute/display')}}/{{ $product->products_id }}">{{ trans('labels.ProductAttributes') }}</a>-->
                                                            <!--    </br>-->
                                                            <!--@endif -->

                                                            <a class="btn btn-danger" style="width: 100%;  margin-bottom: 5px;" id="deleteProductId" products_id="{{ $product->products_id }}">{{ trans('labels.DeleteProduct') }}</a>
                                                        @endif                                                      
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
                                    if($results['products']->total()>0){
                                      $fromrecord = ($results['products']->currentpage()-1)*$results['products']->perpage()+1;
                                    }else{
                                      $fromrecord = 0;
                                    }
                                    if($results['products']->total() < $results['products']->currentpage()*$results['products']->perpage()){
                                      $torecord = $results['products']->total();
                                    }else{
                                      $torecord = $results['products']->currentpage()*$results['products']->perpage();
                                    }

                                  @endphp
                                  <div class="col-xs-12 col-md-6" style="padding:30px 15px; border-radius:5px;">
                                    <div>Showing {{$fromrecord}} to {{$torecord}}
                                        of  {{$results['products']->total()}} entries
                                    </div>
                                  </div>
                                <div class="col-xs-12 col-md-6 text-right">
                                    {{$results['products']->links()}}
                                </div>
                              </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>

            <!-- deleteProductModal -->
            <div class="modal fade" id="deleteproductmodal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteProductModalLabel">{{ trans('labels.DeleteProduct') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/products/delete', 'name'=>'deleteProduct', 'id'=>'deleteProduct', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('products_id',  '', array('class'=>'form-control', 'id'=>'products_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteThisProductDiloge') }}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteProduct">{{ trans('labels.DeleteProduct') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <script type="text/javascript">

                function publishcar(prod_id) {
                    var post_url = "{{url('admin/products/publish')}}"; //get form action url
                    var form_data = {pro_id: prod_id}; //Encode form elements for submission
                    console.log(prod_id);

                    $.post(post_url, form_data, function(response) {
                        console.log('===================');
                        window.location.href = "{{url('admin/products/display')}}";
                    });                    
                }

                function acceptchange(prod_id) {
                    var post_url = "{{url('admin/products/acceptchange')}}"; //get form action url
                    var form_data = {pro_id: prod_id}; //Encode form elements for submission
                    console.log(prod_id);

                    $.post(post_url, form_data, function(response) {
                        console.log('===================');
                        window.location.href = "{{url('admin/products/display')}}";
                    });
                }

                function declinechange(prod_id) {
                    var post_url = "{{url('admin/products/declinechange')}}"; //get form action url
                    var form_data = {pro_id: prod_id}; //Encode form elements for submission
                    console.log(prod_id);

                    $.post(post_url, form_data, function(response) {
                        console.log('===================');
                        window.location.href = "{{url('admin/products/display')}}";
                    });
                }

                function decline(prod_id) {
                    var post_url = "{{url('admin/products/decline')}}"; //get form action url
                    var form_data = {pro_id: prod_id}; //Encode form elements for submission
                    console.log(prod_id);

                    $.post(post_url, form_data, function(response) {
                        console.log('===================');
                        window.location.href = "{{url('admin/products/display')}}";
                    });
                }
                
            </script>
            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
