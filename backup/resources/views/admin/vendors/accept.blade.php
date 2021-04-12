@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.AddVendor') }} <small>{{ trans('labels.AddVendor') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/vendors/requests')}}"><i class="fa fa-users"></i> {{ trans('labels.ListingAllRequests') }}</a></li>
            <li class="active">{{ trans('labels.AddVendor') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.AddVendor') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!--<div class="box-header with-border">
                                          <h3 class="box-title">Edit category</h3>
                                        </div>-->
                                    <!-- /.box-header -->
                                  <br>

                                  @if (count($errors) > 0)
                                    @if($errors->any())
                                      <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                      </div>
                                    @endif
                                  @endif

                                    @if(session()->has('message'))
                                        <div class="alert alert-success" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif

                                    <div class="box-body">

                                      {!! Form::open(array('url' =>'admin/vendors/acceptRequest', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                        {!! Form::hidden('request_id', $data['vendors']->id, array('class'=>'form-control', 'id'=>'request_id')) !!}
                                        {!! Form::hidden('first_name', $data['vendors']->first_name, array('class'=>'form-control', 'id'=>'first_name')) !!}
                                        {!! Form::hidden('last_name', $data['vendors']->last_name, array('class'=>'form-control', 'id'=>'last_name')) !!}
                                        {!! Form::hidden('home_address', $data['vendors']->address, array('class'=>'form-control', 'id'=>'home_address')) !!}
                                        {!! Form::hidden('city', $data['vendors']->city, array('class'=>'form-control', 'id'=>'city')) !!}
                                        {!! Form::hidden('zipcode', $data['vendors']->zipcode, array('class'=>'form-control', 'id'=>'zipcode')) !!}
                                        {!! Form::hidden('country_id', $data['vendors']->country_id, array('class'=>'form-control', 'id'=>'country_id')) !!}
                                        {!! Form::hidden('password', $data['vendors']->password, array('class'=>'form-control', 'id'=>'password')) !!}

                                        <div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }} </label>
                                                <div class="col-sm-10 col-md-4">

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                            <h3 class="modal-title text-primary" id="myModalLabel">Choose Image </h3>
                                                        </div>

                                                        <div class="modal-body manufacturer-image-embed">
                                                            @if(isset($allimage))
                                                            <select class="image-picker show-html " name="image_id" id="select_img">
                                                                <option value=""></option>
                                                                @foreach($allimage as $key=>$image)
                                                                <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                @endforeach
                                                            </select>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left">{{ trans('labels.Add Image') }}</a>
                                                            <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                            <button type="button" class="btn btn-primary" id="selected" data-dismiss="modal">Done</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>

                                                    <div id="imageselected">
                                                    {!! Form::button(trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                                                    <br>
                                                    <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                                                    <div class="closimage">
                                                        <button type="button" class="close pull-left image-close " id="image-close"
                                                        style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    </div>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UploadVendorImageText') }}</span>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <hr>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_name',  $data['vendors']->title, array('class'=>'form-control field-validate', 'id'=>'vendor_name', 'readonly' => 'true')) !!}
                                          </div>

                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_name_arabic',  $data['vendors']->title_arabic, array('class'=>'form-control field-validate', 'id'=>'vendor_name_arabic', 'readonly' => 'true')) !!}
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Telephone') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_phone',  $data['vendors']->phone, array('class'=>'form-control', 'id'=>'vendor_phone', 'readonly' => 'true')) !!}
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Address') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_address',  $data['full_address'], array('class'=>'form-control field-validate', 'id'=>'vendor_address', 'readonly' => 'true')) !!}
                                          </div>
                                        </div>
                                        <hr>                                        

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.EmailAddress') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('email',  $data['vendors']->email, array('class'=>'form-control email-validate', 'id'=>'email', 'readonly' => 'true')) !!}
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Owner') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('user_name',  $data['vendors']->first_name.' '.$data['vendors']->last_name, array('class'=>'form-control', 'id'=>'user_name', 'readonly' => 'true')) !!}                                              
                                          </div>
                                        </div>

                                        <!-- <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Password') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::password('password', array('class'=>'form-control field-validate', 'id'=>'password')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.PasswordText') }}</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                          </div>
                                        </div> -->

                                        <!-- <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Confirm Password') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::password('confirm_password', array('class'=>'form-control field-validate', 'id'=>'confirm_password')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.ConfirmPasswordText') }}</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                          </div>
                                        </div> -->
                                        <hr>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Current Status') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            <label>
                                              <input type="radio" name="vendor_open" value="1" class="minimal" checked> {{ trans('labels.Open') }}
                                            </label><br>

                                            <label>
                                              <input type="radio" name="vendor_open" value="0" class="minimal"> {{ trans('labels.Close') }}
                                            </label>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select class="form-control" name="isActive">
                                              <option value="1">{{ trans('labels.Active') }}</option>
                                              <option value="0">{{ trans('labels.Inactive') }}</option>
                                            </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.StatusText') }}</span>
                                          </div>
                                        </div>
                                        <div class="box-footer text-center">
                                          <button type="submit" class="btn btn-primary" style="margin-right: 16px;">{{ trans('labels.Accept') }}</button>
                                          <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Decline') }}" id="deleteCustomerFrom" users_id="{{ $data['vendors']->id }}" type="button" class="btn btn-danger" style="margin-right: 16px;">{{ trans('labels.Decline') }}</a>
                                          <a href="{{ URL::to('admin/vendors/requests')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                        </div>

                                      {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="deleteCustomerModalLabel">{{ trans('labels.Decline') }}</h4>
              </div>
              {!! Form::open(array('url' =>'admin/vendors/decline', 'name'=>'deleteRequest', 'id'=>'deleteRequest', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
              {!! Form::hidden('action', 'delete', array('class'=>'form-control')) !!}
              {!! Form::hidden('users_id', '', array('class'=>'form-control', 'id'=>'users_id')) !!}
              <div class="modal-body">
                <p>{{ trans('labels.DeclineVendorRequest') }}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                <button type="submit" class="btn btn-primary">{{ trans('labels.Decline') }}</button>
              </div>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
